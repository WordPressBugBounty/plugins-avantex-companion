<?php
/**
 * Avantex Theme Reset — Complete theme reset functionality.
 *
 * Provides a safe, phased AJAX mechanism to reverse all demo-imported content
 * and restore the theme to its first-installed default state.
 *
 * @package avantex
 * @since 1.2.0
 */

// phpcs:disable WordPress.Files.FileName, PEAR.NamingConventions.ValidClassName

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Avantex Theme Reset Handler.
 */
if ( ! class_exists( 'Reavantex_Theme_Reset' ) ) :
class Reavantex_Theme_Reset {

	/**
	 * Constructor — register AJAX handlers.
	 */
	public function __construct() {
		add_action( 'wp_ajax_avantex_theme_reset', array( $this, 'ajax_theme_reset' ) );
		add_action( 'wp_ajax_avantex_reset_status', array( $this, 'ajax_reset_status' ) );
	}

	/**
	 * Get the list of imported demo slugs found in the database.
	 *
	 * @return array List of distinct demo slugs.
	 */
	public static function get_imported_demo_slugs() {
		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$slugs = $wpdb->get_col(
			"SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = '_avantex_demo_slug' AND meta_value != '' ORDER BY meta_value ASC"
		);

		return $slugs ? $slugs : array();
	}

	/**
	 * Count tagged content per demo slug (or all).
	 *
	 * @param string $demo_slug Optional. Specific demo slug to count. Empty = all.
	 * @return array Associative array with counts per type.
	 */
	public static function count_tagged_content( $demo_slug = '' ) {
		global $wpdb;

		$where_slug = '';
		if ( ! empty( $demo_slug ) ) {
			$where_slug = $wpdb->prepare( ' AND pm2.meta_value = %s', $demo_slug );
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$results = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			"SELECT p.post_type, COUNT(*) as count
			FROM $wpdb->posts p
			INNER JOIN $wpdb->postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_avantex_demo_imported' AND pm.meta_value = '1'
			LEFT JOIN $wpdb->postmeta pm2 ON p.ID = pm2.post_id AND pm2.meta_key = '_avantex_demo_slug'
			WHERE 1=1 {$where_slug}
			GROUP BY p.post_type"
		);

		$counts = array(
			'posts'       => 0,
			'pages'       => 0,
			'attachments' => 0,
			'nav_menus'   => 0,
			'other'       => 0,
			'total'       => 0,
		);

		if ( $results ) {
			foreach ( $results as $row ) {
				switch ( $row->post_type ) {
					case 'post':
						$counts['posts'] += (int) $row->count;
						break;
					case 'page':
						$counts['pages'] += (int) $row->count;
						break;
					case 'attachment':
						$counts['attachments'] += (int) $row->count;
						break;
					case 'nav_menu_item':
						$counts['nav_menus'] += (int) $row->count;
						break;
					default:
						$counts['other'] += (int) $row->count;
						break;
				}
				$counts['total'] += (int) $row->count;
			}
		}

		return $counts;
	}

	/**
	 * Create a backup manifest (JSON log) of everything that will be deleted.
	 *
	 * @param string $demo_slug Optional. Specific demo slug. Empty = all.
	 * @return string|WP_Error Path to the backup JSON file, or WP_Error.
	 */
	private static function create_backup_manifest( $demo_slug = '' ) {
		global $wpdb;

		$uploads_dir = wp_upload_dir();
		$backup_dir  = $uploads_dir['basedir'] . '/avantex-reset-backups';
		if ( ! file_exists( $backup_dir ) ) {
			wp_mkdir_p( $backup_dir );
		}

		$timestamp = gmdate( 'Y-m-d_H-i-s' );
		$slug_part = ! empty( $demo_slug ) ? $demo_slug : 'full-reset';
		$filename  = 'avantex-reset-backup_' . $slug_part . '_' . $timestamp . '.json';
		$filepath  = $backup_dir . '/' . $filename;

		// Query all tagged posts.
		$where_slug = '';
		if ( ! empty( $demo_slug ) ) {
			$where_slug = $wpdb->prepare(
				" AND p.ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_avantex_demo_slug' AND meta_value = %s)",
				$demo_slug
			);
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$posts = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			"SELECT p.ID, p.post_title, p.post_type, p.post_name, p.post_status
			FROM $wpdb->posts p
			INNER JOIN $wpdb->postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_avantex_demo_imported' AND pm.meta_value = '1'
			WHERE 1=1 {$where_slug}
			ORDER BY p.post_type, p.post_title"
		);

		// Collect attachment file paths.
		$attachment_files = array();
		if ( $posts ) {
			foreach ( $posts as $post ) {
				if ( 'attachment' === $post->post_type ) {
					$file = get_attached_file( $post->ID );
					if ( $file ) {
						$attachment_files[] = $file;
					}
				}
			}
		}

		// Query tagged terms.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$terms = $wpdb->get_results(
			"SELECT t.term_id, t.name, t.slug, tt.taxonomy
			FROM $wpdb->terms t
			INNER JOIN $wpdb->term_taxonomy tt ON t.term_id = tt.term_id
			INNER JOIN $wpdb->termmeta tm ON t.term_id = tm.term_id AND tm.meta_key = '_avantex_demo_imported' AND tm.meta_value = '1'
			ORDER BY tt.taxonomy, t.name"
		);

		// Collect customizer mods.
		$theme_mods = get_theme_mods();

		$manifest = array(
			'backup_created'   => gmdate( 'Y-m-d H:i:s' ) . ' UTC',
			'demo_slug'        => $slug_part,
			'site_url'         => get_option( 'siteurl' ),
			'theme'            => get_template(),
			'posts'            => $posts ? $posts : array(),
			'attachment_files' => $attachment_files,
			'terms'            => $terms ? $terms : array(),
			'customizer'       => $theme_mods ? $theme_mods : array(),
			'options'          => array(
				'show_on_front'  => get_option( 'show_on_front' ),
				'page_on_front'  => get_option( 'page_on_front' ),
				'page_for_posts' => get_option( 'page_for_posts' ),
			),
		);

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$json = wp_json_encode( $manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
		if ( $wp_filesystem ) {
			$wp_filesystem->put_contents( $filepath, $json );
		}

		return $filepath;
	}

	/**
	 * Main AJAX reset handler — processes in chunked phases.
	 */
	public function ajax_theme_reset() {
		check_ajax_referer( 'avantex-importer-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$phase     = isset( $_POST['phase'] ) ? sanitize_key( $_POST['phase'] ) : '';
		$demo_slug = isset( $_POST['demo_slug'] ) ? sanitize_key( $_POST['demo_slug'] ) : '';

		switch ( $phase ) {
			case 'backup':
				return $this->phase_backup( $demo_slug );
			case 'posts':
				return $this->phase_delete_posts( $demo_slug );
			case 'attachments':
				return $this->phase_delete_attachments( $demo_slug );
			case 'nav_menus':
				return $this->phase_delete_nav_menus( $demo_slug );
			case 'terms':
				return $this->phase_delete_terms( $demo_slug );
			case 'customizer':
				return $this->phase_reset_customizer( $demo_slug );
			case 'widgets':
				return $this->phase_reset_widgets( $demo_slug );
			case 'options':
				return $this->phase_reset_options( $demo_slug );
			case 'cleanup':
				return $this->phase_cleanup();
			default:
				wp_send_json_error( array( 'message' => esc_html__( 'Invalid reset phase.', 'avantex' ) ) );
		}
	}

	/**
	 * AJAX handler to get reset status info for the UI.
	 */
	public function ajax_reset_status() {
		check_ajax_referer( 'avantex-importer-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$demo_slug = isset( $_POST['demo_slug'] ) ? sanitize_key( $_POST['demo_slug'] ) : '';
		$counts    = self::count_tagged_content( $demo_slug );
		$slugs     = self::get_imported_demo_slugs();

		wp_send_json_success(
			array(
				'counts' => $counts,
				'slugs'  => $slugs,
			)
		);
	}

	/**
	 * Phase: Create backup manifest before deletion.
	 *
	 * @param string $demo_slug Demo slug or empty for all.
	 */
	private function phase_backup( $demo_slug ) {
		$filepath = self::create_backup_manifest( $demo_slug );

		if ( is_wp_error( $filepath ) ) {
			wp_send_json_error( array( 'message' => $filepath->get_error_message() ) );
		}

		wp_send_json_success(
			array(
				'message'     => esc_html__( 'Backup manifest created.', 'avantex' ),
				'backup_file' => basename( $filepath ),
			)
		);
	}

	/**
	 * Phase: Delete demo-imported posts, pages, and any other non-attachment post types.
	 *
	 * Uses a direct DB query to catch ALL tagged post types (including custom post types
	 * from plugins like Slider Factory, Filter Gallery, etc.) — not just 'post' and 'page'.
	 * Attachments are excluded here because they need wp_delete_attachment() for file cleanup.
	 *
	 * @param string $demo_slug Demo slug or empty for all.
	 */
	private function phase_delete_posts( $demo_slug ) {
		global $wpdb;

		$where_slug = '';
		if ( ! empty( $demo_slug ) ) {
			$where_slug = $wpdb->prepare(
				" AND p.ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_avantex_demo_slug' AND meta_value = %s)",
				$demo_slug
			);
		}

		// Get ALL tagged posts except attachments (handled in their own phase with wp_delete_attachment).
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$post_ids = $wpdb->get_col(
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			"SELECT p.ID
			FROM $wpdb->posts p
			INNER JOIN $wpdb->postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_avantex_demo_imported' AND pm.meta_value = '1'
			WHERE p.post_type != 'attachment' {$where_slug}"
		);

		$deleted = 0;
		if ( $post_ids ) {
			foreach ( $post_ids as $post_id ) {
				wp_delete_post( (int) $post_id, true ); // Force delete, skip trash.
				++$deleted;
			}
		}

		wp_send_json_success(
			array(
				/* translators: %d: number of deleted posts/pages */
				'message' => sprintf( esc_html__( 'Deleted %d demo posts, pages, and custom content.', 'avantex' ), $deleted ),
				'deleted' => $deleted,
			)
		);
	}

	/**
	 * Phase: Delete demo-imported media attachments and their physical files.
	 *
	 * @param string $demo_slug Demo slug or empty for all.
	 */
	private function phase_delete_attachments( $demo_slug ) {
		$attachments = $this->get_tagged_posts( array( 'attachment' ), $demo_slug );

		$deleted = 0;
		foreach ( $attachments as $attachment_id ) {
			// wp_delete_attachment with force_delete=true removes the physical files and all thumbnails.
			wp_delete_attachment( $attachment_id, true );
			++$deleted;
		}

		wp_send_json_success(
			array(
				/* translators: %d: number of deleted media files */
				'message' => sprintf( esc_html__( 'Deleted %d demo media files from server.', 'avantex' ), $deleted ),
				'deleted' => $deleted,
			)
		);
	}

	/**
	 * Phase: Delete demo-imported nav menu items and clean empty menu terms.
	 *
	 * @param string $demo_slug Demo slug or empty for all.
	 */
	private function phase_delete_nav_menus( $demo_slug ) {
		$menu_items = $this->get_tagged_posts( array( 'nav_menu_item' ), $demo_slug );

		$deleted = 0;
		foreach ( $menu_items as $item_id ) {
			wp_delete_post( $item_id, true );
			++$deleted;
		}

		// Clean up nav_menu terms that were demo-imported.
		$nav_menus = get_terms(
			array(
				'taxonomy'   => 'nav_menu',
				'hide_empty' => false,
			)
		);

		$menus_deleted = 0;
		if ( ! is_wp_error( $nav_menus ) ) {
			foreach ( $nav_menus as $menu ) {
				$is_demo_menu   = get_term_meta( $menu->term_id, '_avantex_demo_imported', true );
				$menu_slug_meta = get_term_meta( $menu->term_id, '_avantex_demo_slug', true );

				$should_delete = false;
				if ( ! empty( $demo_slug ) ) {
					if ( $menu_slug_meta === $demo_slug ) {
						$should_delete = true;
					}
				} elseif ( $is_demo_menu ) {
						$should_delete = true;
				}

				if ( $should_delete ) {
					wp_delete_nav_menu( $menu->term_id );
					++$menus_deleted;
				}
			}
		}

		// Reset only the matching nav_menu_locations.
		$locations = get_theme_mod( 'nav_menu_locations' );
		if ( is_array( $locations ) && ! empty( $locations ) ) {
			foreach ( $locations as $location => $menu_id ) {
				if ( ! empty( $demo_slug ) ) {
					$menu_slug_meta = get_term_meta( $menu_id, '_avantex_demo_slug', true );
					if ( $menu_slug_meta === $demo_slug ) {
						$locations[ $location ] = 0;
					}
				} else {
					$is_demo_menu = get_term_meta( $menu_id, '_avantex_demo_imported', true );
					if ( $is_demo_menu ) {
						$locations[ $location ] = 0;
					}
				}
			}
			set_theme_mod( 'nav_menu_locations', $locations );
		}

		wp_send_json_success(
			array(
				/* translators: 1: number of deleted items, 2: number of deleted menus */
				'message'       => sprintf( esc_html__( 'Deleted %1$d menu items and %2$d menus.', 'avantex' ), $deleted, $menus_deleted ),
				'items_deleted' => $deleted,
				'menus_deleted' => $menus_deleted,
			)
		);
	}

	/**
	 * Phase: Delete demo-imported taxonomy terms.
	 *
	 * @param string $demo_slug Demo slug or empty for all.
	 */
	private function phase_delete_terms( $demo_slug ) {
		global $wpdb;

		$where_slug = '';
		if ( ! empty( $demo_slug ) ) {
			$where_slug = $wpdb->prepare( ' AND tm2.meta_value = %s', $demo_slug );
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$terms = $wpdb->get_results(
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			"SELECT t.term_id, tt.taxonomy
			FROM $wpdb->terms t
			INNER JOIN $wpdb->term_taxonomy tt ON t.term_id = tt.term_id
			INNER JOIN $wpdb->termmeta tm ON t.term_id = tm.term_id AND tm.meta_key = '_avantex_demo_imported' AND tm.meta_value = '1'
			LEFT JOIN $wpdb->termmeta tm2 ON t.term_id = tm2.term_id AND tm2.meta_key = '_avantex_demo_slug'
			WHERE tt.taxonomy NOT IN ('nav_menu') {$where_slug}"
		);

		$deleted = 0;
		if ( $terms ) {
			foreach ( $terms as $term ) {
				wp_delete_term( $term->term_id, $term->taxonomy );
				++$deleted;
			}
		}

		wp_send_json_success(
			array(
				/* translators: %d: number of deleted terms */
				'message' => sprintf( esc_html__( 'Deleted %d demo taxonomy terms.', 'avantex' ), $deleted ),
				'deleted' => $deleted,
			)
		);
	}

	/**
	 * Phase: Reset all Customizer theme mods to defaults.
	 *
	 * @param string $demo_slug Optional. Specific demo slug.
	 */
	private function phase_reset_customizer( $demo_slug = '' ) {
		if ( empty( $demo_slug ) ) {
			remove_theme_mods();
			$message = esc_html__( 'Customizer settings restored to theme defaults.', 'avantex' );
		} else {
			$message = esc_html__( 'Customizer settings preserved for other active demos.', 'avantex' );
		}

		wp_send_json_success(
			array(
				'message' => $message,
			)
		);
	}

	/**
	 * Phase: Reset all widget sidebar assignments.
	 *
	 * @param string $demo_slug Optional. Specific demo slug.
	 */
	private function phase_reset_widgets( $demo_slug = '' ) {
		if ( empty( $demo_slug ) ) {
			// Clear all sidebar widget assignments.
			$sidebars_widgets = get_option( 'sidebars_widgets' );
			if ( is_array( $sidebars_widgets ) ) {
				foreach ( $sidebars_widgets as $sidebar => $widgets ) {
					if ( 'wp_inactive_widgets' !== $sidebar && 'array_version' !== $sidebar ) {
						$sidebars_widgets[ $sidebar ] = array();
					}
				}
				update_option( 'sidebars_widgets', $sidebars_widgets );
			}

			// Reset widget option groups for known theme widget types.
			global $wpdb;
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$widget_options = $wpdb->get_col( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'widget_%'" );
			foreach ( $widget_options as $option_name ) {
				$val = get_option( $option_name );
				if ( is_array( $val ) ) {
					// Keep only the _multiwidget key, remove all instance data.
					$clean = array( '_multiwidget' => 1 );
					update_option( $option_name, $clean );
				}
			}
			$message = esc_html__( 'Widget areas and sidebar configurations cleared.', 'avantex' );
		} else {
			$message = esc_html__( 'Widgets preserved for other active demos.', 'avantex' );
		}

		wp_send_json_success(
			array(
				'message' => $message,
			)
		);
	}

	/**
	 * Phase: Reset WordPress reading/display settings.
	 *
	 * @param string $demo_slug Optional. Specific demo slug.
	 */
	private function phase_reset_options( $demo_slug = '' ) {
		if ( empty( $demo_slug ) ) {
			// Restore to default "Your latest posts" reading mode.
			update_option( 'show_on_front', 'posts' );
			delete_option( 'page_on_front' );
			delete_option( 'page_for_posts' );
			$message = esc_html__( 'Reading settings restored to WordPress defaults.', 'avantex' );
		} else {
			$message = esc_html__( 'Reading settings preserved.', 'avantex' );
		}

		wp_send_json_success(
			array(
				'message' => $message,
			)
		);
	}

	/**
	 * Phase: Final cleanup — orphan data, caches, and transients.
	 */
	private function phase_cleanup() {
		// Remove stale import ID map if it lingered from an interrupted import.
		delete_option( 'avantex_import_id_map' );

		// Flush rewrite rules to refresh permalinks.
		flush_rewrite_rules();

		// Clear any object caches.
		wp_cache_flush();

		wp_send_json_success(
			array(
				'message' => esc_html__( 'Cleanup complete. Theme is now in its default state.', 'avantex' ),
			)
		);
	}

	/**
	 * Helper: Get post IDs tagged as demo-imported, filtered by post types and optional demo slug.
	 *
	 * @param array  $post_types Post types to query.
	 * @param string $demo_slug  Optional demo slug filter.
	 * @return array Array of post IDs.
	 */
	private function get_tagged_posts( $post_types, $demo_slug = '' ) {
		$meta_query = array(
			array(
				'key'   => '_avantex_demo_imported',
				'value' => '1',
			),
		);

		if ( ! empty( $demo_slug ) ) {
			$meta_query[] = array(
				'key'   => '_avantex_demo_slug',
				'value' => $demo_slug,
			);
		}

		$query = new WP_Query(
			array(
				'post_type'      => $post_types,
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'no_found_rows'  => true,
				'meta_query'     => $meta_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			)
		);

		return $query->posts;
	}
}

new Reavantex_Theme_Reset();
endif;
