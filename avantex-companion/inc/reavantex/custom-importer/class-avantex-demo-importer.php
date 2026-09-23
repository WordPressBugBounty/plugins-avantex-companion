<?php
/**
 * Custom Standalone Demo Importer for Avantex.
 *
 * @package Avantex
 * @since 1.1.0
 */

// phpcs:disable WordPress.Files.FileName, PEAR.NamingConventions.ValidClassName, Generic.Files.OneObjectStructurePerFile.MultipleFound

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'AVANTEX_COMPANION_VERSION' ) ) {
	define( 'AVANTEX_COMPANION_VERSION', '0.2.6' );
}

// Ensure the core WordPress upgrader class is loaded for our silent skin subclass.
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

/**
 * Custom Standalone Demo Importer for Avantex.
 */
class Reavantex_Demo_Importer {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Register admin submenu page with late priority to override OCDI.
		add_action( 'admin_menu', array( $this, 'register_submenu_page' ), 999 );

		// Enqueue scripts and styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );

		// AJAX handlers.
		add_action( 'wp_ajax_avantex_import_plugins', array( $this, 'ajax_import_plugins' ) );
		add_action( 'wp_ajax_avantex_upload_custom_zip', array( $this, 'ajax_upload_custom_zip' ) );
		add_action( 'wp_ajax_avantex_download_package', array( $this, 'ajax_download_package' ) );
		add_action( 'wp_ajax_avantex_import_xml_chunk', array( $this, 'ajax_import_xml_chunk' ) );
		add_action( 'wp_ajax_avantex_import_customizer', array( $this, 'ajax_import_customizer' ) );
		add_action( 'wp_ajax_avantex_import_widgets', array( $this, 'ajax_import_widgets' ) );
		add_action( 'wp_ajax_avantex_import_finalize', array( $this, 'ajax_import_finalize' ) );
	}

	/**
	 * Remote server base URL for downloading demo ZIP packages.
	 * Can be overridden by developers via filter if necessary.
	 */
	private static function get_remote_package_base_url() {
		return apply_filters( 'avantex_demo_package_base_url', 'https://wpfrank.com/demo_assets/avantex/' );
	}

	/**
	 * Get the local path of the downloaded demo files.
	 *
	 * @param string $demo      Demo slug.
	 * @param string $file_type Optional. File type extension.
	 * @return string Local file path or directory path.
	 */
	private static function get_demo_package_path( $demo, $file_type = '' ) {
		$uploads_dir = wp_upload_dir();
		$base_dir    = $uploads_dir['basedir'] . '/avantex-demos/' . $demo;

		if ( empty( $file_type ) ) {
			return $base_dir;
		}

		return $base_dir . '/' . $demo . '.' . $file_type;
	}

	/**
	 * Helper to recursively delete a directory and its contents.
	 *
	 * @param string $dir Directory path.
	 * @return bool True on success, false on failure.
	 */
	private static function delete_directory( $dir ) {
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ( ! $wp_filesystem ) {
			return false;
		}

		return $wp_filesystem->delete( $dir, true );
	}

	/**
	 * Register the submenu page.
	 */
	public function register_submenu_page() {
		add_theme_page(
			esc_html__( 'ReAvantex Demo Import', 'avantex' ),
			esc_html__( 'ReAvantex Demo Import', 'avantex' ),
			'manage_options',
			'avantex-demo-import',
			array( $this, 'render_importer_page' ),
			6
		);

		// Hide the redundant OCDI menu from Appearance if active.
		remove_submenu_page( 'themes.php', 'one-click-demo-import' );
	}

	/**
	 * Enqueue assets for the importer.
	 *
	 * @param string $hook The current admin page hook.
	 */
	public function enqueue_assets( $hook ) {
		if ( 'appearance_page_avantex-demo-import' !== $hook ) {
			return;
		}

		// Enqueue Dashicons.
		wp_enqueue_style( 'dashicons' );

		// Register and enqueue custom styles and scripts.
		wp_register_style( 'avantex-importer-css', AVANTEX_COMPANION_REAVANTEX_URL . 'custom-importer/importer-page.css', array(), AVANTEX_COMPANION_VERSION );
		wp_enqueue_style( 'avantex-importer-css' );

		wp_register_script( 'avantex-importer-js', AVANTEX_COMPANION_REAVANTEX_URL . 'custom-importer/importer-scripts.js', array( 'jquery' ), AVANTEX_COMPANION_VERSION, true );
		wp_enqueue_script( 'avantex-importer-js' );

		// Localize AJAX variables.
		wp_localize_script(
			'avantex-importer-js',
			'avantexImporterAjax',
			array(
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'avantex-importer-nonce' ),
				'messages' => array(
					'plugins'    => esc_html__( 'Installing and activating required plugins...', 'avantex' ),
					'xml_start'  => esc_html__( 'Connecting to raw GitHub CDN and parsing XML content...', 'avantex' ),
					/* translators: %s: percentage completed */
					'xml_loop'   => esc_html__( 'Importing posts, pages, and media files (%s%% completed)...', 'avantex' ),
					'customizer' => esc_html__( 'Applying Customizer configuration & theme mods...', 'avantex' ),
					'widgets'    => esc_html__( 'Configuring widget areas and sidebar modules...', 'avantex' ),
					'finalize'   => esc_html__( 'Finalizing navigation menu, page mapping, and re-linking...', 'avantex' ),
					'success'    => esc_html__( 'Import completed successfully!', 'avantex' ),
					'error'      => esc_html__( 'An error occurred during import. Please refresh and try again.', 'avantex' ),
				),
			)
		);
	}

	/**
	 * Render the visual template.
	 */
	public function render_importer_page() {
		// Include HTML layout.
		require_once __DIR__ . '/importer-template.php';
	}

	/**
	 * Validate if the requested demo slug is part of the pre-approved whitelist.
	 *
	 * @param string $demo Demo slug.
	 * @return bool True if valid, false otherwise.
	 */
	private static function validate_demo_slug( $demo ) {
		$allowed_demos = array(
			'avantex-business',
			'avantex-market',
			'avantex-pro',
			'avantex-automobile',
			'avantex-yoga',
			'avantex-metaverse',
			'avantex-medical',
			'avantex-construction',
			'avantex-education',
		);
		if ( in_array( $demo, $allowed_demos, true ) ) {
			return true;
		}

		// Allow dynamic manually uploaded custom ZIP package slugs.
		if ( preg_match( '/^[a-z0-9\-]+$/', $demo ) ) {
			$path = self::get_demo_package_path( $demo );
			if ( is_dir( $path ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * AJAX Phase 1: Install & Activate Required Plugins.
	 */
	public function ajax_import_plugins() {
		check_ajax_referer( 'avantex-importer-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$required_plugins = array(
			array(
				'name' => 'Lead Generation Form',
				'slug' => 'lead-generation-form',
			),
			array(
				'name' => 'Slider Factory',
				'slug' => 'slider-factory',
			),
			array(
				'name' => 'Filter Gallery',
				'slug' => 'filter-gallery',
			),
			array(
				'name' => 'Coming Soon Maintenance Mode',
				'slug' => 'coming-soon-maintenance-mode',
			),
		);

		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		// Silent upgrader skin is declared at the bottom of this file.

		foreach ( $required_plugins as $plugin ) {
			$plugin_file = $plugin['slug'] . '/' . $plugin['slug'] . '.php';

			if ( ! is_plugin_active( $plugin_file ) ) {
				// Install if doesn't exist.
				if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {
					$api = plugins_api( 'plugin_information', array( 'slug' => $plugin['slug'] ) );
					if ( ! is_wp_error( $api ) ) {
						$upgrader = new Plugin_Upgrader( new Reavantex_Silent_Upgrader_Skin() );
						$upgrader->install( $api->download_link );
					}
				}
				// Activate.
				activate_plugin( $plugin_file );
			}
		}

		wp_send_json_success( array( 'message' => esc_html__( 'Plugins ready.', 'avantex' ) ) );
	}

	/**
	 * AJAX Phase 2: Download and extract the remote demo package ZIP.
	 */
	public function ajax_download_package() {
		check_ajax_referer( 'avantex-importer-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$demo = isset( $_POST['demo'] ) ? sanitize_key( $_POST['demo'] ) : '';
		if ( ! self::validate_demo_slug( $demo ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid demo selected.', 'avantex' ) ) );
		}

		// Ensure WordPress filesystem functions are loaded.
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		global $wp_filesystem;

		$target_dir = self::get_demo_package_path( $demo );

		// Create target folder if it doesn't exist.
		if ( ! file_exists( $target_dir ) ) {
			wp_mkdir_p( $target_dir );
		}

		// Remote ZIP package URL dynamically loaded from central method with cache-buster.
		$remote_url = self::get_remote_package_base_url() . $demo . '.zip?t=' . time();

		// Download temporary file.
		$temp_file = download_url( $remote_url );
		if ( is_wp_error( $temp_file ) ) {
			wp_send_json_error(
				array(
					'message' => sprintf(
						/* translators: %s: error message details */
						esc_html__( 'Failed to download demo package. Error: %s', 'avantex' ),
						$temp_file->get_error_message()
					),
				)
			);
		}

		// Extract ZIP file.
		$result = unzip_file( $temp_file, $target_dir );

		// Clean up the temp zip file.
		if ( $wp_filesystem ) {
			$wp_filesystem->delete( $temp_file );
		} else {
			wp_delete_file( $temp_file );
		}

		if ( is_wp_error( $result ) ) {
			wp_send_json_error(
				array(
					'message' => sprintf(
						/* translators: %s: error message details */
						esc_html__( 'Failed to extract package. Error: %s', 'avantex' ),
						$result->get_error_message()
					),
				)
			);
		}

		wp_send_json_success( array( 'message' => esc_html__( 'Demo package deployed successfully.', 'avantex' ) ) );
	}

	/**
	 * AJAX Custom ZIP Upload Handler.
	 */
	public function ajax_upload_custom_zip() {
		check_ajax_referer( 'avantex-importer-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$raw_file = isset( $_FILES['demo_zip'] ) ? wp_unslash( $_FILES['demo_zip'] ) : array();
		if ( empty( $raw_file ) || ! isset( $raw_file['name'] ) || ! isset( $raw_file['tmp_name'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'No file uploaded.', 'avantex' ) ) );
		}

		$file_name = sanitize_file_name( $raw_file['name'] );

		// Validate file extension.
		$ext = pathinfo( $file_name, PATHINFO_EXTENSION );
		if ( 'zip' !== strtolower( $ext ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Please upload a valid .zip file.', 'avantex' ) ) );
		}

		// Clean the temporary slug from the zip filename.
		$temp_slug = sanitize_key( pathinfo( $file_name, PATHINFO_FILENAME ) );
		if ( ! preg_match( '/^[a-z0-9\-]+$/', $temp_slug ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid ZIP file name slug format.', 'avantex' ) ) );
		}

		// Ensure WordPress filesystem and upload functions are loaded.
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		global $wp_filesystem;

		// Bypass MIME type restriction for .zip files on some browsers/platforms (like Windows)
		$zip_mime_bypass = function ( $data, $file, $filename, $mimes ) {
			$ext = pathinfo( $filename, PATHINFO_EXTENSION );
			if ( 'zip' === strtolower( $ext ) ) {
				$data['ext']  = 'zip';
				$data['type'] = 'application/zip';
			}
			return $data;
		};
		add_filter( 'wp_check_filetype_and_ext', $zip_mime_bypass, 10, 4 );

		// Move the uploaded file securely to the uploads directory using wp_handle_upload
		$upload_overrides = array(
			'test_form' => false,
			'mimes'     => array( 'zip' => 'application/zip' ),
		);

		$moved_file = wp_handle_upload( $_FILES['demo_zip'], $upload_overrides );

		remove_filter( 'wp_check_filetype_and_ext', $zip_mime_bypass, 10 );

		if ( ! $moved_file || isset( $moved_file['error'] ) ) {
			$error_msg = isset( $moved_file['error'] ) ? $moved_file['error'] : esc_html__( 'Failed to upload package.', 'avantex' );
			wp_send_json_error( array( 'message' => $error_msg ) );
		}

		$file_tmp_path   = $moved_file['file'];
		$temp_target_dir = self::get_demo_package_path( $temp_slug );

		// Clean up existing directory if present to avoid pollution.
		if ( file_exists( $temp_target_dir ) ) {
			self::delete_directory( $temp_target_dir );
		}

		wp_mkdir_p( $temp_target_dir );

		// Extract ZIP file from the secure uploads folder.
		$result = unzip_file( $file_tmp_path, $temp_target_dir );

		// Delete the temporary zip file after extraction
		if ( $wp_filesystem ) {
			$wp_filesystem->delete( $file_tmp_path );
		} else {
			wp_delete_file( $file_tmp_path );
		}

		if ( is_wp_error( $result ) ) {
			wp_send_json_error(
				array(
					'message' => sprintf(
						/* translators: %s: error message details */
						esc_html__( 'Failed to extract package. Error: %s', 'avantex' ),
						$result->get_error_message()
					),
				)
			);
		}

		// Find the internal XML file to determine the real slug.
		$xml_files = glob( $temp_target_dir . '/*.xml' );
		if ( empty( $xml_files ) ) {
			self::delete_directory( $temp_target_dir );
			wp_send_json_error( array( 'message' => esc_html__( 'No XML file found inside the uploaded ZIP package.', 'avantex' ) ) );
		}

		// Use the first XML file name as the real slug.
		$real_slug = sanitize_key( pathinfo( $xml_files[0], PATHINFO_FILENAME ) );
		if ( ! preg_match( '/^[a-z0-9\-]+$/', $real_slug ) ) {
			self::delete_directory( $temp_target_dir );
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid internal XML file name slug format.', 'avantex' ) ) );
		}

		$real_target_dir = self::get_demo_package_path( $real_slug );

		if ( $real_slug !== $temp_slug ) {
			// Clean up existing real target directory if present.
			if ( file_exists( $real_target_dir ) ) {
				self::delete_directory( $real_target_dir );
			}
			// Rename/move extracted folder to the real slug folder using standard WordPress filesystem.
			if ( ! $wp_filesystem || ! $wp_filesystem->move( $temp_target_dir, $real_target_dir ) ) {
				self::delete_directory( $temp_target_dir );
				wp_send_json_error( array( 'message' => esc_html__( 'Failed to rename the package folder to match the internal slug.', 'avantex' ) ) );
			}
		}

		// Set transient to identify this slug as a custom manual upload.
		set_transient( 'avantex_is_custom_import_' . $real_slug, true, HOUR_IN_SECONDS );

		wp_send_json_success(
			array(
				'message' => esc_html__( 'Custom package uploaded and deployed.', 'avantex' ),
				'slug'    => $real_slug,
				'name'    => ucwords( str_replace( array( '-', '_' ), ' ', $real_slug ) ),
			)
		);
	}

	/**
	 * AJAX Phase 3: Import XML Content dynamically in chunks.
	 */
	public function ajax_import_xml_chunk() {
		check_ajax_referer( 'avantex-importer-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$demo       = isset( $_POST['demo'] ) ? sanitize_key( $_POST['demo'] ) : '';
		$offset     = isset( $_POST['offset'] ) ? (int) $_POST['offset'] : 0;
		$chunk_size = 15; // Number of items per request.

		if ( ! self::validate_demo_slug( $demo ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid demo selected.', 'avantex' ) ) );
		}

		$xml_file = self::get_demo_package_path( $demo, 'xml' );
		if ( ! file_exists( $xml_file ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Demo XML content file not found.', 'avantex' ) ) );
		}

		$items = self::parse_xml( $xml_file );
		if ( is_wp_error( $items ) ) {
			wp_send_json_error( array( 'message' => $items->get_error_message() ) );
		}

		$total_items = count( $items );
		if ( $offset >= $total_items ) {
			wp_send_json_success(
				array(
					'status'   => 'done',
					'progress' => 100,
					'offset'   => $total_items,
					'total'    => $total_items,
				)
			);
		}

		$chunk = array_slice( $items, $offset, $chunk_size );

		// Set execution limits.
		// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged, WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_set_time_limit
		@set_time_limit( 0 );
		wp_raise_memory_limit( 'admin' );

		$imported_count = 0;
		foreach ( $chunk as $item ) {
			self::import_single_item( $item );
			++$imported_count;
		}

		$new_offset = $offset + $imported_count;
		$progress   = round( ( $new_offset / $total_items ) * 100 );

		wp_send_json_success(
			array(
				'status'   => 'importing',
				'progress' => $progress,
				'offset'   => $new_offset,
				'total'    => $total_items,
			)
		);
	}

	/**
	 * AJAX Phase 4: Import Customizer Settings.
	 */
	public function ajax_import_customizer() {
		check_ajax_referer( 'avantex-importer-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$demo = isset( $_POST['demo'] ) ? sanitize_key( $_POST['demo'] ) : '';
		if ( ! self::validate_demo_slug( $demo ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid demo selected.', 'avantex' ) ) );
		}

		$dat_file = self::get_demo_package_path( $demo, 'dat' );
		$result   = self::import_customizer( $dat_file );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( array( 'message' => esc_html__( 'Customizer settings applied.', 'avantex' ) ) );
	}

	/**
	 * AJAX Phase 5: Import Widgets.
	 */
	public function ajax_import_widgets() {
		check_ajax_referer( 'avantex-importer-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$demo = isset( $_POST['demo'] ) ? sanitize_key( $_POST['demo'] ) : '';
		if ( ! self::validate_demo_slug( $demo ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid demo selected.', 'avantex' ) ) );
		}

		$wie_file = self::get_demo_package_path( $demo, 'wie' );
		$result   = self::import_widgets( $wie_file );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( array( 'message' => esc_html__( 'Widgets configured.', 'avantex' ) ) );
	}

	/**
	 * AJAX Phase 5: Finalize.
	 */
	public function ajax_import_finalize() {
		check_ajax_referer( 'avantex-importer-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$demo = isset( $_POST['demo'] ) ? sanitize_key( $_POST['demo'] ) : '';
		if ( ! self::validate_demo_slug( $demo ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid demo selected.', 'avantex' ) ) );
		}

		$result = self::finalize_import( $demo );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		// Cleanup the deployed temporary local demo files to prevent uploads directory bloat.
		$target_dir = self::get_demo_package_path( $demo );
		self::delete_directory( $target_dir );

		wp_send_json_success( array( 'message' => esc_html__( 'Import completed!', 'avantex' ) ) );
	}

	/**
	 * Parses a standard WXR (WordPress XML export) file into an array of structural item nodes.
	 *
	 * @param string $xml_file_path Path to the XML file.
	 * @return array|WP_Error Array of items or WP_Error on failure.
	 */
	private static function parse_xml( $xml_file_path ) {
		if ( ! file_exists( $xml_file_path ) ) {
			return new WP_Error( 'file_not_found', esc_html__( 'XML file not found.', 'avantex' ) );
		}

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}
		$content = $wp_filesystem->get_contents( $xml_file_path );
		if ( ! $content ) {
			return new WP_Error( 'empty_file', esc_html__( 'XML file is empty.', 'avantex' ) );
		}

		// Dynamically repair corrupted closing tags that were messed up in search-and-replace.
		$content = str_replace( '<link>%%WPFRANK_DEMO_URL%%/link>', '<link>%%WPFRANK_DEMO_URL%%</link>', $content );
		$content = str_replace( '<wp:base_site_url>%%WPFRANK_DEMO_URL%%/wp:base_site_url>', '<wp:base_site_url>%%WPFRANK_DEMO_URL%%</wp:base_site_url>', $content );
		$content = str_replace( '<wp:base_blog_url>%%WPFRANK_DEMO_URL%%/wp:base_blog_url>', '<wp:base_blog_url>%%WPFRANK_DEMO_URL%%</wp:base_blog_url>', $content );

		// Replace the placeholder with the local site URL.
		$site_url = untrailingslashit( get_option( 'siteurl' ) );
		$content  = str_replace( '%%WPFRANK_DEMO_URL%%', $site_url, $content );

		// Also replace any hardcoded remote domains with local site URL.
		$demo_slug = basename( dirname( $xml_file_path ) );
		$content   = str_replace( 'http://wpfrank.com/demo/' . $demo_slug, $site_url, $content );
		$content   = str_replace( 'https://wpfrank.com/demo/' . $demo_slug, $site_url, $content );

		$xml = simplexml_load_string( $content, 'SimpleXMLElement', LIBXML_NOCDATA );
		if ( ! $xml ) {
			return new WP_Error( 'xml_parse_error', esc_html__( 'Failed to parse XML file.', 'avantex' ) );
		}

		$namespaces = $xml->getDocNamespaces( true );
		$wp_ns      = isset( $namespaces['wp'] ) ? $namespaces['wp'] : '';
		$content_ns = isset( $namespaces['content'] ) ? $namespaces['content'] : '';

		$items = array();
		foreach ( $xml->channel->item as $item ) {
			$wp      = $wp_ns ? $item->children( $wp_ns ) : $item;
			$content = $content_ns ? $item->children( $content_ns ) : $item;

			$postmeta = array();
			if ( isset( $wp->postmeta ) ) {
				foreach ( $wp->postmeta as $meta ) {
					$postmeta[] = array(
						'key'   => (string) $meta->meta_key,
						'value' => (string) $meta->meta_value,
					);
				}
			}

			$terms = array();
			if ( isset( $item->category ) ) {
				foreach ( $item->category as $cat ) {
					$terms[] = array(
						'taxonomy' => (string) $cat['domain'],
						'slug'     => (string) $cat['nicename'],
						'name'     => (string) $cat,
					);
				}
			}

			$subpath        = '';
			$attachment_url = isset( $wp->attachment_url ) ? (string) $wp->attachment_url : '';
			if ( $attachment_url ) {
				$uploads_pos = strpos( $attachment_url, 'wp-content/uploads' );
				if ( false !== $uploads_pos ) {
					$subpath = substr( $attachment_url, $uploads_pos + strlen( 'wp-content/uploads' ) );
					$subpath = ltrim( $subpath, '/' );
					if ( preg_match( '/^sites\/[0-9]+\/(.+)$/', $subpath, $matches ) ) {
						$subpath = $matches[1];
					}
				}
			}

			$items[] = array(
				'title'              => (string) $item->title,
				'link'               => (string) $item->link,
				'post_id'            => (int) $wp->post_id,
				'post_name'          => (string) $wp->post_name,
				'post_type'          => (string) $wp->post_type,
				'status'             => (string) $wp->status,
				'post_parent'        => (int) $wp->post_parent,
				'menu_order'         => (int) $wp->menu_order,
				'post_date'          => isset( $wp->post_date ) ? (string) $wp->post_date : '',
				'post_content'       => (string) $content->encoded,
				'attachment_url'     => $attachment_url,
				'attachment_subpath' => $subpath,
				'postmeta'           => $postmeta,
				'terms'              => $terms,
			);
		}

		return $items;
	}

	/**
	 * Imports a single WXR item.
	 *
	 * @param array $item The WXR item data array.
	 */
	private static function import_single_item( $item ) {
		// Check if the item already exists to avoid garbage entries.
		$existing_post_id  = 0;
		$was_newly_created = false;

		if ( ! empty( $item['post_name'] ) ) {
			$existing_post = get_page_by_path( $item['post_name'], OBJECT, $item['post_type'] );
			if ( $existing_post ) {
				$existing_post_id = $existing_post->ID;
			}
		}

		if ( ! $existing_post_id && ! empty( $item['title'] ) && 'attachment' !== $item['post_type'] ) {
			$posts_query = new WP_Query(
				array(
					'post_type'              => $item['post_type'],
					'title'                  => $item['title'],
					'post_status'            => 'any',
					'posts_per_page'         => 1,
					'no_found_rows'          => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
				)
			);
			if ( $posts_query->have_posts() ) {
				$existing_post_id = $posts_query->posts[0]->ID;
			}
		}

		if ( 'attachment' === $item['post_type'] ) {
			$clean_url = wp_parse_url( $item['attachment_url'], PHP_URL_PATH );
			$filename  = basename( $clean_url ? $clean_url : $item['attachment_url'] );

			global $wpdb;
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$attachment_exists = $wpdb->get_col(
				$wpdb->prepare(
					"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_attached_file' AND ( meta_value = %s OR meta_value LIKE %s )",
					$filename,
					'%/' . $wpdb->esc_like( $filename )
				)
			);

			if ( ! empty( $attachment_exists ) ) {
				$new_post_id   = $attachment_exists[0];
				$attached_file = get_attached_file( $new_post_id );
				// If the database entry exists but the physical file was deleted, force re-download!
				if ( ! $attached_file || ! file_exists( $attached_file ) ) {
					$attachment_exists = false;
				}
			}

			if ( ! empty( $attachment_exists ) ) {
				$new_post_id = $attachment_exists[0];
			} else {
				// Sideload attachment securely from GitHub CDN.
				require_once ABSPATH . 'wp-admin/includes/image.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/media.php';

				$year  = '';
				$month = '';

				// 1. Try to extract year/month from attachment_subpath (e.g. 2023/03/filename.png)
				if ( ! empty( $item['attachment_subpath'] ) ) {
					if ( preg_match( '/^([0-9]{4})\/([0-9]{2})\//', $item['attachment_subpath'], $matches ) ) {
						$year  = $matches[1];
						$month = $matches[2];
					}
				}

				// 2. Try to extract from attachment_url as fallback
				if ( ( ! $year || ! $month ) && ! empty( $item['attachment_url'] ) ) {
					if ( preg_match( '/\/uploads\/(sites\/\d+\/)?([0-9]{4})\/([0-9]{2})\//', $item['attachment_url'], $matches ) ) {
						$year  = $matches[2];
						$month = $matches[3];
					}
				}

				// 3. Try to use post_date as last resort
				if ( ( ! $year || ! $month ) && ! empty( $item['post_date'] ) && '0000-00-00 00:00:00' !== $item['post_date'] ) {
					$time = strtotime( $item['post_date'] );
					if ( $time ) {
						$year  = gmdate( 'Y', $time );
						$month = gmdate( 'm', $time );
					}
				}

				// Temporarily force upload directory to match the original XML attachment path or post date.
				$upload_dir_filter = function ( $uploads ) use ( $year, $month ) {
					if ( $year && $month ) {
						$uploads['subdir'] = '/' . $year . '/' . $month;
						$uploads['path']   = $uploads['basedir'] . $uploads['subdir'];
						$uploads['url']    = $uploads['baseurl'] . $uploads['subdir'];
					}
					return $uploads;
				};
				add_filter( 'upload_dir', $upload_dir_filter );

				// Force WP to accept WebP files regardless of server configuration/WP version.
				$allow_webp        = function ( $mimes ) {
					$mimes['webp'] = 'image/webp';
					return $mimes;
				};
				$bypass_file_check = function ( $data, $file, $filename ) {
					$ext = pathinfo( $filename, PATHINFO_EXTENSION );
					if ( 'webp' === strtolower( $ext ) ) {
						$data['ext']             = 'webp';
						$data['type']            = 'image/webp';
						$data['proper_filename'] = $filename;
					}
					return $data;
				};
				add_filter( 'upload_mimes', $allow_webp );
				add_filter( 'wp_check_filetype_and_ext', $bypass_file_check, 10, 3 );

				// Pass post_date matching the extracted folder to media_handle_sideload.
				$post_data = array();
				if ( $year && $month ) {
					$post_data['post_date'] = $year . '-' . $month . '-01 00:00:00';
				}

				$local_file_found = false;
				$attachment_id    = null;

				if ( ! empty( $item['attachment_subpath'] ) ) {
					// phpcs:ignore WordPress.Security.NonceVerification.Missing
					$demo_slug = isset( $_POST['demo'] ) ? sanitize_key( $_POST['demo'] ) : '';
					if ( ! empty( $demo_slug ) ) {
						$local_file_path = self::get_demo_package_path( $demo_slug ) . '/uploads/' . $item['attachment_subpath'];
						if ( file_exists( $local_file_path ) && is_file( $local_file_path ) ) {
							$local_file_found = true;

							// Copy the file to a temp location so WordPress can safely move/import it.
							$tmp_file = wp_tempnam( $local_file_path );
							if ( $tmp_file && copy( $local_file_path, $tmp_file ) ) {
								$file_array    = array(
									'name'     => $filename,
									'tmp_name' => $tmp_file,
								);
								$attachment_id = media_handle_sideload( $file_array, 0, $item['title'], $post_data );
								if ( is_wp_error( $attachment_id ) ) {
									wp_delete_file( $tmp_file );
								}
							} else {
								$local_file_found = false; // Fall back to remote download if copy fails.
							}
						}
					}
				}

				if ( ! $local_file_found ) {
					// Fall back to original remote URL if local file is missing.
					$tmp_file = download_url( $item['attachment_url'] );
					if ( ! is_wp_error( $tmp_file ) ) {
						$file_array    = array(
							'name'     => $filename,
							'tmp_name' => $tmp_file,
						);
						$attachment_id = media_handle_sideload( $file_array, 0, $item['title'], $post_data );
						if ( is_wp_error( $attachment_id ) ) {
							wp_delete_file( $file_array['tmp_name'] );
						}
					} else {
						$attachment_id = $tmp_file; // Pass WP_Error.
					}
				}

				remove_filter( 'upload_dir', $upload_dir_filter );
				remove_filter( 'upload_mimes', $allow_webp );
				remove_filter( 'wp_check_filetype_and_ext', $bypass_file_check, 10 );

				if ( ! is_wp_error( $attachment_id ) ) {
					$new_post_id       = $attachment_id;
					$was_newly_created = true;
				} else {
					$new_post_id = 0;
				}
			}
		} else {
			// Determine the correct post_status.
			// nav_menu_item posts use 'publish' in WXR; forcing 'inherit' breaks them.
			if ( 'nav_menu_item' === $item['post_type'] ) {
				$post_status = 'publish';
			} else {
				$post_status = 'publish' === $item['status'] ? 'publish' : $item['status'];
			}

			$post_data = array(
				'post_title'   => $item['title'],
				'post_name'    => $item['post_name'],
				'post_content' => $item['post_content'],
				'post_type'    => $item['post_type'],
				'post_status'  => $post_status,
				'menu_order'   => $item['menu_order'],
			);

			if ( ! empty( $item['post_date'] ) && '0000-00-00 00:00:00' !== $item['post_date'] ) {
				$post_data['post_date'] = $item['post_date'];
			}

			if ( ! empty( $item['post_date'] ) && '0000-00-00 00:00:00' !== $item['post_date'] ) {
				$post_data['post_date'] = $item['post_date'];
			}

			if ( $existing_post_id ) {
				$post_data['ID'] = $existing_post_id;
				$new_post_id     = wp_update_post( $post_data );
			} else {
				$new_post_id       = wp_insert_post( $post_data );
				$was_newly_created = true;
			}
		}

		if ( $new_post_id && ! is_wp_error( $new_post_id ) ) {
			// Update the ID mappings transient/option.
			$id_map                     = get_option( 'avantex_import_id_map', array() );
			$id_map[ $item['post_id'] ] = $new_post_id;
			update_option( 'avantex_import_id_map', $id_map );

			// Tag demo-imported content for the Theme Reset feature.
			// Only tag genuinely NEW posts/attachments to protect pre-existing user content.
			// phpcs:ignore WordPress.Security.NonceVerification.Missing
			$current_demo_slug = isset( $_POST['demo'] ) ? sanitize_key( $_POST['demo'] ) : '';
			if ( ! empty( $was_newly_created ) ) {
				update_post_meta( $new_post_id, '_avantex_demo_imported', 1 );
				if ( $current_demo_slug ) {
					update_post_meta( $new_post_id, '_avantex_demo_slug', $current_demo_slug );
				}
			}

			// Save postmeta.
			foreach ( $item['postmeta'] as $meta ) {
				// Prevent XML from overwriting natively generated attachment metadata
				// which causes orphaned -1/-2 suffixed files during reset.
				if ( 'attachment' === $item['post_type'] && in_array( $meta['key'], array( '_wp_attached_file', '_wp_attachment_metadata' ), true ) ) {
					continue;
				}
				update_post_meta( $new_post_id, $meta['key'], $meta['value'] );
			}

			// Save taxonomy terms.
			foreach ( $item['terms'] as $term ) {
				if ( taxonomy_exists( $term['taxonomy'] ) ) {
					$existing_term = term_exists( $term['slug'], $term['taxonomy'] );
					if ( ! $existing_term ) {
						$inserted_term = wp_insert_term( $term['name'], $term['taxonomy'], array( 'slug' => $term['slug'] ) );
						$term_id       = ( ! is_wp_error( $inserted_term ) && isset( $inserted_term['term_id'] ) ) ? $inserted_term['term_id'] : 0;

						// Tag newly created terms for the Theme Reset feature.
						if ( $term_id ) {
							update_term_meta( $term_id, '_avantex_demo_imported', 1 );
							if ( $current_demo_slug ) {
								update_term_meta( $term_id, '_avantex_demo_slug', $current_demo_slug );
							}
						}
					} else {
						$term_id = is_array( $existing_term ) ? $existing_term['term_id'] : $existing_term;
					}

					if ( $term_id ) {
						wp_set_object_terms( $new_post_id, (int) $term_id, $term['taxonomy'], true );
					}
				}
			}
		}
	}

	/**
	 * Robust character-by-character serialized string repair helper.
	 *
	 * @param string $serialized Serialized string to repair.
	 * @return string Repaired serialized string.
	 */
	public static function repair_serialized_string( $serialized ) {
		$len    = strlen( $serialized );
		$output = '';
		$i      = 0;

		while ( $i < $len ) {
			if ( substr( $serialized, $i, 2 ) === 's:' ) {
				// Find the colon after the length.
				$colon = strpos( $serialized, ':', $i + 2 );
				if ( false === $colon ) {
					$output .= $serialized[ $i ];
					++$i;
					continue;
				}

				// Check if it's a valid string format s:X:".
				if ( substr( $serialized, $colon + 1, 1 ) === '"' ) {
					// Find the correct closing quote and semicolon.
					$start = $colon + 2;
					$j     = $start;
					$found = false;

					while ( $j < $len ) {
						// Search for the closing sequence: ";.
						$next_close = strpos( $serialized, '";', $j );
						if ( false === $next_close ) {
							break;
						}

						// Check if this "; is the actual end of string.
						// It must be followed by a transition: s, i, b, a, d, N, O, } or end of serialized data.
						$next_char = substr( $serialized, $next_close + 2, 1 );
						if ( '' === $next_char || false !== strpos( 'sibadNO}', $next_char ) ) {
							$actual_str = substr( $serialized, $start, $next_close - $start );
							$new_len    = strlen( $actual_str );
							$output    .= 's:' . $new_len . ':"' . $actual_str . '";';
							$i          = $next_close + 2;
							$found      = true;
							break;
						} else {
							// Not a valid close, continue searching from the next character.
							$j = $next_close + 2;
						}
					}

					if ( $found ) {
						continue;
					}
				}
			}

			$output .= $serialized[ $i ];
			++$i;
		}

		return $output;
	}

	/**
	 * Imports Customizer options and applies values.
	 *
	 * @param string $dat_file_path Path to the Customizer DAT file.
	 * @return bool|WP_Error True on success, WP_Error on failure.
	 */
	private static function import_customizer( $dat_file_path ) {
		if ( ! file_exists( $dat_file_path ) ) {
			return new WP_Error( 'file_not_found', esc_html__( 'Customizer file not found.', 'avantex' ) );
		}

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}
		$content = $wp_filesystem->get_contents( $dat_file_path );
		if ( ! $content ) {
			return new WP_Error( 'empty_file', esc_html__( 'Customizer file is empty.', 'avantex' ) );
		}

		// First, replace placeholders and domain names dynamically in the raw content.
		$placeholder = '%%WPFRANK_DEMO_URL%%';
		$site_url    = untrailingslashit( get_option( 'siteurl' ) );
		$content     = str_replace( $placeholder, $site_url, $content );

		// Replace any hardcoded remote domains with local site URL.
		$demo_slug = basename( dirname( $dat_file_path ) );
		$content   = str_replace( 'http://wpfrank.com/demo/' . $demo_slug, $site_url, $content );
		$content   = str_replace( 'https://wpfrank.com/demo/' . $demo_slug, $site_url, $content );
		$content   = str_replace( 'http:\/\/wpfrank.com\/demo\/' . $demo_slug, str_replace( '/', '\/', $site_url ), $content );
		$content   = str_replace( 'https:\/\/wpfrank.com\/demo\/' . $demo_slug, str_replace( '/', '\/', $site_url ), $content );

		// Now, repair the serialized lengths of the resulting string!
		$content = self::repair_serialized_string( $content );

		// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_unserialize
		$data = unserialize( $content );
		if ( ! $data ) {
			return new WP_Error( 'invalid_data', esc_html__( 'Failed to unserialize Customizer data.', 'avantex' ) );
		}

		$mods = isset( $data['mods'] ) ? $data['mods'] : ( isset( $data['theme_mods'] ) ? $data['theme_mods'] : $data );

		if ( is_array( $mods ) ) {
			// Wipe all existing theme mods so that settings from a previously
			// imported demo do not bleed into the new one.
			remove_theme_mods();

			foreach ( $mods as $key => $value ) {
				set_theme_mod( $key, $value );
			}
		}

		return true;
	}

	/**
	 * Imports widget JSON data.
	 *
	 * @param string $wie_file_path Path to the widget JSON file.
	 * @return bool|WP_Error True on success, WP_Error on failure.
	 */
	private static function import_widgets( $wie_file_path ) {
		if ( ! file_exists( $wie_file_path ) ) {
			return new WP_Error( 'file_not_found', esc_html__( 'Widget file not found.', 'avantex' ) );
		}

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}
		$content = $wp_filesystem->get_contents( $wie_file_path );
		if ( ! $content ) {
			return new WP_Error( 'empty_file', esc_html__( 'Widget file is empty.', 'avantex' ) );
		}

		$data = json_decode( $content, true );
		if ( ! $data ) {
			return new WP_Error( 'invalid_json', esc_html__( 'Failed to decode Widget JSON.', 'avantex' ) );
		}

		// Clear existing widgets before importing to avoid duplication.
		$sidebars_widgets = get_option( 'sidebars_widgets' );
		if ( is_array( $sidebars_widgets ) ) {
			foreach ( $sidebars_widgets as $sidebar => $widgets ) {
				if ( 'wp_inactive_widgets' !== $sidebar && 'array_version' !== $sidebar ) {
					$sidebars_widgets[ $sidebar ] = array();
				}
			}
			update_option( 'sidebars_widgets', $sidebars_widgets );
		}

		// Import widgets.
		foreach ( $data as $sidebar_id => $widgets ) {
			if ( empty( $widgets ) ) {
				continue;
			}

			foreach ( $widgets as $widget_id => $widget_data ) {
				$widget_type = preg_replace( '/-[0-9]+$/', '', $widget_id );
				$option_name = 'widget_' . $widget_type;
				$widget_opt  = get_option( $option_name, array() );

				if ( ! is_array( $widget_opt ) ) {
					$widget_opt = array();
				}

				$new_index                = count( $widget_opt ) + 1;
				$widget_opt[ $new_index ] = $widget_data;

				if ( ! isset( $widget_opt['_multiwidget'] ) ) {
					$widget_opt['_multiwidget'] = 1;
				}

				// Replace placeholders inside widget configuration.
				$placeholder = '%%WPFRANK_DEMO_URL%%';
				$site_url    = untrailingslashit( get_option( 'siteurl' ) );

				array_walk_recursive(
					$widget_opt[ $new_index ],
					function ( &$item ) use ( $placeholder, $site_url ) {
						if ( is_string( $item ) ) {
							$item = str_replace( $placeholder, $site_url, $item );
						}
					}
				);

				update_option( $option_name, $widget_opt );

				// Assign to sidebars.
				$sidebars_widgets = get_option( 'sidebars_widgets', array() );
				if ( ! isset( $sidebars_widgets[ $sidebar_id ] ) ) {
					$sidebars_widgets[ $sidebar_id ] = array();
				}
				$sidebars_widgets[ $sidebar_id ][] = $widget_type . '-' . $new_index;
				update_option( 'sidebars_widgets', $sidebars_widgets );
			}
		}

		return true;
	}

	/**
	 * Finalizes the import by remapping IDs, assigning menus, static homepages, and fonts.
	 *
	 * @param string $demo_name Name of the demo being finalized.
	 * @return bool|WP_Error True on success, WP_Error on failure.
	 */
	private static function finalize_import( $demo_name ) {
		global $wpdb;

		$id_map = get_option( 'avantex_import_id_map', array() );

		// 1. Remap post parent IDs.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$imported_posts = $wpdb->get_results( "SELECT ID, post_parent FROM $wpdb->posts WHERE post_type IN ('post', 'page', 'attachment')" );
		foreach ( $imported_posts as $post ) {
			if ( $post->post_parent && isset( $id_map[ $post->post_parent ] ) ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$wpdb->update(
					$wpdb->posts,
					array( 'post_parent' => $id_map[ $post->post_parent ] ),
					array( 'ID' => $post->ID )
				);
			}
		}

		// 2. Remap menu item target object IDs & parent items.
		$menu_items = get_posts(
			array(
				'post_type'      => 'nav_menu_item',
				'posts_per_page' => -1,
				'post_status'    => 'any',
			)
		);
		foreach ( $menu_items as $item ) {
			$object_id = get_post_meta( $item->ID, '_menu_item_object_id', true );
			$item_type = get_post_meta( $item->ID, '_menu_item_type', true );

			if ( $object_id && isset( $id_map[ $object_id ] ) ) {
				update_post_meta( $item->ID, '_menu_item_object_id', $id_map[ $object_id ] );
			} elseif ( 'custom' === $item_type ) {
				// Custom links should point _menu_item_object_id to their own post ID.
				update_post_meta( $item->ID, '_menu_item_object_id', $item->ID );
			} elseif ( $object_id && 'post_type' === $item_type ) {
				// Fallback: the target page exists but wasn't in the id_map (matched as existing).
				// Check if the old object_id actually exists as a valid post; if not, try to find the page by the menu item title.
				$target_post = get_post( (int) $object_id );
				if ( ! $target_post ) {
					$object_type       = get_post_meta( $item->ID, '_menu_item_object', true );
					$lookup_type       = $object_type ? $object_type : 'page';
					$found_pages_query = new WP_Query(
						array(
							'post_type'              => $lookup_type,
							'title'                  => $item->post_title,
							'post_status'            => 'any',
							'posts_per_page'         => 1,
							'no_found_rows'          => true,
							'update_post_meta_cache' => false,
							'update_post_term_cache' => false,
						)
					);
					$found_page        = $found_pages_query->have_posts() ? $found_pages_query->posts[0] : null;
					if ( $found_page ) {
						update_post_meta( $item->ID, '_menu_item_object_id', $found_page->ID );
					}
				}
			}

			$menu_parent_id = get_post_meta( $item->ID, '_menu_item_menu_item_parent', true );
			if ( $menu_parent_id && isset( $id_map[ $menu_parent_id ] ) ) {
				update_post_meta( $item->ID, '_menu_item_menu_item_parent', $id_map[ $menu_parent_id ] );
			} elseif ( $menu_parent_id && ! get_post( (int) $menu_parent_id ) ) {
				// Parent menu item ID is stale/orphaned — reset to 0 (top-level).
				update_post_meta( $item->ID, '_menu_item_menu_item_parent', 0 );
			}
		}

		// 2.5 Remap featured image attachment IDs (_thumbnail_id) for all posts.
		$all_posts = get_posts(
			array(
				'post_type'      => 'any',
				'posts_per_page' => -1,
				'post_status'    => 'any',
			)
		);
		foreach ( $all_posts as $post ) {
			$thumbnail_id = get_post_meta( $post->ID, '_thumbnail_id', true );
			if ( $thumbnail_id && isset( $id_map[ (int) $thumbnail_id ] ) ) {
				update_post_meta( $post->ID, '_thumbnail_id', $id_map[ (int) $thumbnail_id ] );
			}
		}

		// 3. Assign Menu, Static Front Page, and Curated Fonts.
		$menu_name        = '';
		$front_page_title = '';

		switch ( $demo_name ) {
			case 'avantex-business':
				$menu_name        = 'Avantex Business Menu';
				$front_page_title = 'Business Home';
				break;
			case 'avantex-pro':
				$menu_name        = 'Avantex Pro Menu';
				$front_page_title = 'Avantex Home';
				break;
			case 'avantex-automobile':
				$menu_name        = 'Avantex Auto Menu';
				$front_page_title = 'Automobile Home';
				break;
			case 'avantex-market':
				$menu_name        = 'Avantex Market Menu';
				$front_page_title = 'Market Home';
				break;
			case 'avantex-yoga':
				$menu_name        = 'Avantex Yoga Menu';
				$front_page_title = 'Yoga Home';
				break;
			case 'avantex-metaverse':
				$menu_name        = 'Avantex Metaverse Menu';
				$front_page_title = 'Metaverse Home';
				break;
			case 'avantex-medical':
				$menu_name        = 'Avantex Medical Menu';
				$front_page_title = 'Medical Home';
				break;
			case 'avantex-construction':
				$menu_name        = 'Avantex Construction Menu';
				$front_page_title = 'Construction Home';
				break;
			case 'avantex-education':
				$menu_name        = 'Education Pro Menu';
				$front_page_title = 'Education Home';
				break;
		}

		// 3. Assign Menu locations (Primary & Footer).
		$all_nav_menus   = wp_get_nav_menus();
		$primary_menu_id = 0;
		$footer_menu_id  = 0;

		$clean_demo_name = str_replace( array( 'avantex-', 'reavantex-' ), '', $demo_name );
		$candidate_primary_names = array(
			$menu_name,
			'Avantex ' . ucwords( $clean_demo_name ) . ' Menu',
			ucwords( $clean_demo_name ) . ' Menu',
			'ReAvantex Header Menu',
			'Header Menu',
			'Primary Menu',
			'Main Menu',
			'Primary',
			'Main Navigation',
			'Menu 1',
		);

		$candidate_footer_names = array(
			'ReAvantex Footer Menu',
			'Footer Menu',
			'Footer',
			'Secondary Menu',
			'Bottom Menu',
		);

		if ( ! empty( $all_nav_menus ) && is_array( $all_nav_menus ) ) {
			// Find Primary Menu.
			foreach ( $candidate_primary_names as $cand ) {
				if ( empty( $cand ) ) {
					continue;
				}
				foreach ( $all_nav_menus as $nav_m ) {
					if ( 0 === strcasecmp( $nav_m->name, $cand ) || false !== stripos( $nav_m->name, $cand ) ) {
						$primary_menu_id = $nav_m->term_id;
						break 2;
					}
				}
			}

			if ( ! $primary_menu_id ) {
				foreach ( $all_nav_menus as $nav_m ) {
					if ( false !== stripos( $nav_m->name, 'header' ) || false !== stripos( $nav_m->name, 'main' ) || false !== stripos( $nav_m->name, 'primary' ) ) {
						$primary_menu_id = $nav_m->term_id;
						break;
					}
				}
			}
			if ( ! $primary_menu_id && ! empty( $all_nav_menus[0] ) ) {
				$primary_menu_id = $all_nav_menus[0]->term_id;
			}

			// Find Footer Menu.
			foreach ( $candidate_footer_names as $cand ) {
				foreach ( $all_nav_menus as $nav_m ) {
					if ( 0 === strcasecmp( $nav_m->name, $cand ) || false !== stripos( $nav_m->name, $cand ) ) {
						$footer_menu_id = $nav_m->term_id;
						break 2;
					}
				}
			}

			if ( ! $footer_menu_id ) {
				foreach ( $all_nav_menus as $nav_m ) {
					if ( (int) $nav_m->term_id !== (int) $primary_menu_id && false !== stripos( $nav_m->name, 'footer' ) ) {
						$footer_menu_id = $nav_m->term_id;
						break;
					}
				}
			}

			if ( ! $footer_menu_id ) {
				$re_footer = wp_get_nav_menu_object( 'ReAvantex Footer Menu' );
				if ( $re_footer ) {
					$footer_menu_id = $re_footer->term_id;
				} elseif ( $primary_menu_id ) {
					$footer_menu_id = $primary_menu_id;
				}
			}
		} else {
			// If no menus exist, initialize default companion menus.
			if ( function_exists( 'reavantex_companion_setup_default_pages' ) ) {
				reavantex_companion_setup_default_pages();
			}
			$re_header = wp_get_nav_menu_object( 'ReAvantex Header Menu' );
			$re_footer = wp_get_nav_menu_object( 'ReAvantex Footer Menu' );
			if ( $re_header ) {
				$primary_menu_id = $re_header->term_id;
			}
			if ( $re_footer ) {
				$footer_menu_id = $re_footer->term_id;
			}
		}

		$locations = get_theme_mod( 'nav_menu_locations', array() );
		if ( ! is_array( $locations ) ) {
			$locations = array();
		}
		if ( $primary_menu_id ) {
			$locations['primary'] = (int) $primary_menu_id;
		}
		if ( $footer_menu_id ) {
			$locations['footer'] = (int) $footer_menu_id;
		}

		set_theme_mod( 'nav_menu_locations', $locations );
		update_option( 'nav_menu_locations', $locations );

		// Ensure ReAvantex Services Menu exists for Footer Our Services column.
		$services_menu = wp_get_nav_menu_object( 'ReAvantex Services Menu' );
		if ( ! $services_menu ) {
			$services_menu = wp_get_nav_menu_object( 'Services Menu' );
		}
		if ( ! $services_menu ) {
			$services_menu = wp_get_nav_menu_object( 'Our Services' );
		}
		if ( ! $services_menu ) {
			$services_menu_id = wp_create_nav_menu( 'ReAvantex Services Menu' );
			if ( ! is_wp_error( $services_menu_id ) ) {
				$service_items = array(
					array( 'title' => 'Web Development', 'url' => home_url( '/services/' ) ),
					array( 'title' => 'UI/UX Design', 'url' => home_url( '/services/' ) ),
					array( 'title' => 'Digital Marketing', 'url' => home_url( '/services/' ) ),
					array( 'title' => 'Brand Strategy', 'url' => home_url( '/services/' ) ),
					array( 'title' => 'Cloud Solutions', 'url' => home_url( '/services/' ) ),
				);
				$s_order = 1;
				foreach ( $service_items as $s_item ) {
					wp_update_nav_menu_item(
						$services_menu_id,
						0,
						array(
							'menu-item-title'    => $s_item['title'],
							'menu-item-url'      => $s_item['url'],
							'menu-item-status'   => 'publish',
							'menu-item-type'     => 'custom',
							'menu-item-position' => $s_order,
						)
					);
					++$s_order;
				}
				$services_menu = wp_get_nav_menu_object( 'ReAvantex Services Menu' );
			}
		}

		// Remap Navigation Menu widgets in sidebars (e.g. Footer Our Services & Quick Links).
		$widget_nav_menu = get_option( 'widget_nav_menu', array() );
		if ( is_array( $widget_nav_menu ) && ! empty( $widget_nav_menu ) ) {
			$footer_menu_obj       = wp_get_nav_menu_object( $footer_menu_id );
			$services_menu_term_id = $services_menu ? (int) $services_menu->term_id : 0;
			$footer_menu_term_id   = $footer_menu_obj ? (int) $footer_menu_obj->term_id : 0;

			$updated_widgets = false;
			foreach ( $widget_nav_menu as $w_idx => &$w_data ) {
				if ( ! is_array( $w_data ) || ! isset( $w_data['title'] ) ) {
					continue;
				}
				$w_title = trim( $w_data['title'] );
				if ( false !== stripos( $w_title, 'service' ) ) {
					if ( $services_menu_term_id ) {
						$w_data['nav_menu'] = $services_menu_term_id;
						$updated_widgets    = true;
					}
				} elseif ( false !== stripos( $w_title, 'link' ) || false !== stripos( $w_title, 'footer' ) || false !== stripos( $w_title, 'company' ) || false !== stripos( $w_title, 'explore' ) ) {
					if ( $footer_menu_term_id ) {
						$w_data['nav_menu'] = $footer_menu_term_id;
						$updated_widgets    = true;
					}
				}
			}
			unset( $w_data );
			if ( $updated_widgets ) {
				update_option( 'widget_nav_menu', $widget_nav_menu );
			}
		}

		// Set homepage and blog page.
		$front_page = null;
		$blog_page  = null;

		$candidate_front_titles = array_filter( array( $front_page_title, 'Home', 'Front Page' ) );
		foreach ( $candidate_front_titles as $title_cand ) {
			$found = get_posts(
				array(
					'post_type'      => 'page',
					'title'          => $title_cand,
					'posts_per_page' => 1,
				)
			);
			if ( ! empty( $found ) ) {
				$front_page = $found[0];
				break;
			}
		}

		if ( ! $front_page ) {
			$front_page = get_page_by_path( 'home' );
		}

		$candidate_blog_titles = array( 'Blog', 'News' );
		foreach ( $candidate_blog_titles as $blog_cand ) {
			$found_blog = get_posts(
				array(
					'post_type'      => 'page',
					'title'          => $blog_cand,
					'posts_per_page' => 1,
				)
			);
			if ( ! empty( $found_blog ) ) {
				$blog_page = $found_blog[0];
				break;
			}
		}

		if ( ! $blog_page ) {
			$blog_page = get_page_by_path( 'blog' );
		}

		if ( $front_page ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $front_page->ID );
			update_post_meta( $front_page->ID, '_wp_page_template', 'templates/avantex-frontpage.php' );
		}
		if ( $blog_page ) {
			update_option( 'page_for_posts', $blog_page->ID );
		}

			// Remap legacy blog templates to the unified blog template and set the Customizer layout settings.
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$legacy_template_posts = $wpdb->get_results( "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = '_wp_page_template' AND meta_value LIKE 'templates/avantex-blog-%'" );
			foreach ( $legacy_template_posts as $post_meta ) {
				$old_temp    = $post_meta->meta_value;
				$new_layout  = 'grid';
				$new_sidebar = 'none-sidebar';
				if ( strpos( $old_temp, 'left-sidebar' ) !== false ) {
					$new_layout  = 'stack';
					$new_sidebar = 'left-sidebar';
				} elseif ( strpos( $old_temp, 'right-sidebar' ) !== false ) {
					$new_layout  = 'stack';
					$new_sidebar = 'right-sidebar';
				}
				update_post_meta( $post_meta->post_id, '_wp_page_template', 'templates/avantex-blog-template.php' );
				set_theme_mod( 'avantex-blog-template-layout', $new_layout );
				set_theme_mod( 'avantex-blog-template-sidebar', $new_sidebar );
			}

		// Curated Fonts.
		$fonts = array(
			'avantex-business'     => array(
				'heading' => 'Outfit',
				'body'    => 'Inter',
			),
			'avantex-pro'          => array(
				'heading' => 'Plus Jakarta Sans',
				'body'    => 'Inter',
			),
			'avantex-automobile'   => array(
				'heading' => 'Sora',
				'body'    => 'Inter',
			),
			'avantex-market'       => array(
				'heading' => 'Lexend',
				'body'    => 'Jost',
			),
			'avantex-yoga'         => array(
				'heading' => 'Playfair Display',
				'body'    => 'Montserrat',
			),
			'avantex-metaverse'    => array(
				'heading' => 'Space Grotesk',
				'body'    => 'Space Grotesk',
			),
			'avantex-medical'      => array(
				'heading' => 'Work Sans',
				'body'    => 'Inter',
			),
			'avantex-construction' => array(
				'heading' => 'Barlow',
				'body'    => 'Open Sans',
			),
			'avantex-education'    => array(
				'heading' => 'Poppins',
				'body'    => 'Open Sans',
			),
		);

		$is_custom_import = get_transient( 'avantex_is_custom_import_' . $demo_name );
		if ( $is_custom_import ) {
			delete_transient( 'avantex_is_custom_import_' . $demo_name );
		}

		if ( ! $is_custom_import && isset( $fonts[ $demo_name ] ) ) {
			set_theme_mod( 'avantex-typo-font-global', $fonts[ $demo_name ]['body'] );
			set_theme_mod( 'avantex-typo-font-headings', $fonts[ $demo_name ]['heading'] );
			set_theme_mod( 'avantex-typo-weight-headings', '700' );
			set_theme_mod( 'avantex-typo-weight-global', '400' );
		}

		// 3.5 Remap Customizer attachment IDs and image URLs using the XML import ID map.
		$mods = get_theme_mods();
		if ( is_array( $mods ) ) {
			$attachments       = get_posts(
				array(
					'post_type'      => 'attachment',
					'posts_per_page' => -1,
				)
			);
			$attachment_map    = array();
			$attachment_id_map = array();
			foreach ( $attachments as $attachment ) {
				$file = get_post_meta( $attachment->ID, '_wp_attached_file', true );
				if ( $file ) {
					$base                       = strtolower( basename( $file ) );
					$url                        = wp_get_attachment_url( $attachment->ID );
					$attachment_map[ $base ]    = $url;
					$attachment_id_map[ $base ] = $attachment->ID;

					$ext        = pathinfo( $base, PATHINFO_EXTENSION );
					$name       = pathinfo( $base, PATHINFO_FILENAME );
					$name_clean = preg_replace( '/-[0-9]+$/', '', $name );

					if ( ! isset( $attachment_map[ $name_clean . '.' . $ext ] ) ) {
						$attachment_map[ $name_clean . '.' . $ext ] = $url;
					}
					if ( ! isset( $attachment_map[ $name_clean ] ) ) {
						$attachment_map[ $name_clean ] = $url;
					}
					if ( ! isset( $attachment_id_map[ $name_clean . '.' . $ext ] ) ) {
						$attachment_id_map[ $name_clean . '.' . $ext ] = $attachment->ID;
					}
					if ( ! isset( $attachment_id_map[ $name_clean ] ) ) {
						$attachment_id_map[ $name_clean ] = $attachment->ID;
					}
				}
			}

			$remap_value = function ( $val, $key = '' ) use ( $id_map, $attachment_map, $attachment_id_map, &$remap_value ) {
				if ( is_numeric( $val ) ) {
					$allowed_keys = array( 'custom_logo', 'attachment_id', 'id', 'image_id', 'logo', 'site_logo' );
					if ( in_array( $key, $allowed_keys, true ) ) {
						$val_int = (int) $val;
						if ( isset( $id_map[ $val_int ] ) ) {
							return $id_map[ $val_int ];
						}
					}
				} elseif ( is_string( $val ) ) {
					// Check if it's a JSON string.
					$decoded = json_decode( $val, true );
					if ( is_array( $decoded ) ) {
						array_walk_recursive(
							$decoded,
							function ( &$item, $item_key ) use ( $id_map, $attachment_map, $attachment_id_map ) {
								if ( is_numeric( $item ) ) {
									$allowed_keys = array( 'custom_logo', 'attachment_id', 'id', 'image_id', 'logo', 'site_logo' );
									if ( in_array( $item_key, $allowed_keys, true ) ) {
										$item_int = (int) $item;
										if ( isset( $id_map[ $item_int ] ) ) {
											$item = $id_map[ $item_int ];
										}
									}
								} elseif ( is_string( $item ) ) {
									if ( strpos( $item, 'http' ) !== false || strpos( $item, 'wp-content/uploads' ) !== false ) {
										$base = strtolower( basename( $item ) );
										if ( isset( $attachment_map[ $base ] ) ) {
											$item = $attachment_map[ $base ];
										} else {
											$clean_base = preg_replace( '/-[0-9]+x[0-9]+/', '', $base );
											if ( isset( $attachment_map[ $clean_base ] ) ) {
												$item = $attachment_map[ $clean_base ];
											}
										}
									}
								}
							}
						);
						return wp_json_encode( $decoded );
					}

					// If it's a regular URL string.
					if ( strpos( $val, 'http' ) !== false || strpos( $val, 'wp-content/uploads' ) !== false ) {
						$base = strtolower( basename( $val ) );
						if ( isset( $attachment_map[ $base ] ) ) {
							return $attachment_map[ $base ];
						} else {
							$clean_base = preg_replace( '/-[0-9]+x[0-9]+/', '', $base );
							if ( isset( $attachment_map[ $clean_base ] ) ) {
								return $attachment_map[ $clean_base ];
							}
						}
					}
				} elseif ( is_array( $val ) ) {
					// Recurse into native nested arrays!
					foreach ( $val as $k => $v ) {
						$val[ $k ] = $remap_value( $v, $k );
					}
				}
				return $val;
			};

			foreach ( $mods as $key => $value ) {
				$new_value = $remap_value( $value, $key );
				if ( $new_value !== $value ) {
					set_theme_mod( $key, $new_value );
				}
			}
		}

		// 3.6 Remap Widget attachment IDs and URLs.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$widget_options = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'widget_%'" );
		foreach ( $widget_options as $opt ) {
			if ( is_serialized( $opt->option_value ) ) {
				// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_unserialize
				$val = unserialize( $opt->option_value );
				if ( is_array( $val ) ) {
					$updated = false;
					foreach ( $val as $k => $v ) {
						$new_v = $remap_value( $v, $k );
						if ( $new_v !== $v ) {
							$val[ $k ] = $new_v;
							$updated   = true;
						}
					}
					if ( $updated ) {
						update_option( $opt->option_name, $val );
					}
				}
			}
		}

		// 4. Force global search and replace for %%WPFRANK_DEMO_URL%%.
		self::replace_placeholders();

		// Clear transient mapping.
		delete_option( 'avantex_import_id_map' );

		return true;
	}

	/**
	 * Automatically replace demo placeholders with the actual site URL.
	 */
	public static function replace_placeholders() {
		global $wpdb;

		$placeholder = '%%WPFRANK_DEMO_URL%%';
		$site_url    = untrailingslashit( get_option( 'siteurl' ) );

		// 1. Update Post Content.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE $wpdb->posts SET post_content = REPLACE(post_content, %s, %s)",
				$placeholder,
				$site_url
			)
		);

		// 2. Update Theme Mods (Customizer).
		$theme_slug = get_option( 'stylesheet' );
		$mods       = get_option( "theme_mods_$theme_slug" );
		if ( $mods && is_array( $mods ) ) {
			array_walk_recursive(
				$mods,
				function ( &$item ) use ( $placeholder, $site_url ) {
					if ( is_string( $item ) ) {
						$item = str_replace( $placeholder, $site_url, $item );
					}
				}
			);
			update_option( "theme_mods_$theme_slug", $mods );
		}

		// 3. Update Widgets.
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$widget_options = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'widget_%'" );
		foreach ( $widget_options as $opt ) {
			if ( is_serialized( $opt->option_value ) ) {
				// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_unserialize
				$val = unserialize( $opt->option_value );
				if ( is_array( $val ) ) {
					array_walk_recursive(
						$val,
						function ( &$item ) use ( $placeholder, $site_url ) {
							if ( is_string( $item ) ) {
								$item = str_replace( $placeholder, $site_url, $item );
							}
						}
					);
					update_option( $opt->option_name, $val );
				}
			}
		}
	}
}

new Reavantex_Demo_Importer();

if ( ! class_exists( 'Reavantex_Silent_Upgrader_Skin' ) ) {
	/**
	 * Silent Upgrader Skin for Suppressing HTML Outputs during AJAX calls.
	 */
	class Reavantex_Silent_Upgrader_Skin extends WP_Upgrader_Skin {

		/**
		 * Suppress upgrader header output.
		 */
		public function header() {}

		/**
		 * Suppress upgrader footer output.
		 */
		public function footer() {}

		/**
		 * Suppress upgrader error output.
		 *
		 * @param string|WP_Error $errors Upgrader error.
		 */
		public function error( $errors ) {}

		/**
		 * Suppress upgrader feedback output.
		 *
		 * @param string $text Feedback message.
		 * @param mixed  ...$args Optional arguments.
		 */
		public function feedback( $text, ...$args ) {}
	}
}
