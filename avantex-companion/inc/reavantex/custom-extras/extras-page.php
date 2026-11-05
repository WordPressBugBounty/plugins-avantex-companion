<?php
/**
 * Avantex Extras — Admin submenu page.
 *
 * Registers the "Avantex Extras" admin page, enqueues assets only on that
 * screen, and handles all AJAX actions for plugin/theme install, update,
 * and activate operations.
 *
 * @package avantex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'AVANTEX_COMPANION_VERSION' ) ) {
	define( 'AVANTEX_COMPANION_VERSION', '0.2.8' );
}

/*
────────────────────────────────────────────
 * 1. Register the submenu page
 * ────────────────────────────────────────────
*/

/**
 * Add "ReAvantex Extras" under Appearance.
 */
function reavantex_extras_register_page() {
	add_theme_page(
		esc_html__( 'ReAvantex Extras', 'avantex' ),
		esc_html__( 'ReAvantex Extras', 'avantex' ),
		'manage_options',
		'avantex-extras',
		'reavantex_extras_render_page',
		5
	);
}
add_action( 'admin_menu', 'reavantex_extras_register_page' );

/**
 * Render the page content.
 */
function reavantex_extras_render_page() {
	require_once __DIR__ . '/extras-template.php';
}

/*
────────────────────────────────────────────
 * 2. Enqueue assets — only on the extras page
 * ────────────────────────────────────────────
 */

/**
 * Enqueue CSS and JS for the extras page only.
 *
 * @param string $hook_suffix The current admin page hook.
 */
function reavantex_extras_enqueue_assets( $hook_suffix ) {

	if ( 'appearance_page_avantex-extras' !== $hook_suffix ) {
		return;
	}

	// Bootstrap (already registered in reavantex_admin_enqueue_scripts).
	wp_enqueue_style( 'admin-bootstrap-min-css' );

	// Extras page stylesheet.
	wp_enqueue_style(
		'avantex-extras-css',
		AVANTEX_COMPANION_REAVANTEX_URL . 'custom-extras/extras-page.css',
		array( 'admin-bootstrap-min-css' ),
		AVANTEX_COMPANION_VERSION
	);

	// Extras page script (vanilla JS, no jQuery dependency).
	wp_enqueue_script(
		'avantex-extras-js',
		AVANTEX_COMPANION_REAVANTEX_URL . 'custom-extras/extras-scripts.js',
		array(),
		AVANTEX_COMPANION_VERSION,
		true
	);

	wp_localize_script(
		'avantex-extras-js',
		'avantexExtras',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'avantex-extras-nonce' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'reavantex_extras_enqueue_assets' );

/*
────────────────────────────────────────────
 * 3. Data helpers
 * ────────────────────────────────────────────
*/

/**
 * Return the list of recommended plugin slugs.
 *
 * @return string[]
 */
function reavantex_extras_get_plugin_slugs() {
	return array(
		'filter-gallery',
		'flickr-album-gallery',
		'slider-factory',
		'ultimate-responsive-image-slider',
		'lead-generation-form',
		'frank-dead-link-checker',
		'frank-schema-markup-generator',
	);
}

/**
 * Return the list of recommended theme slugs with their demo/buy links.
 *
 * @return array[] Associative array keyed by slug.
 */
function reavantex_extras_get_theme_data() {
	return array(
		// ── Newer themes ──
		'paws-clinic'           => array(
			'demo' => 'https://wpfrank.com/demo/paws-clinic/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/paws-clinic-premium/',
		),
		'paws-and-care'         => array(
			'demo' => 'https://wpfrank.com/demo/paws-and-care/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/paws-and-care-premium/',
		),
		'modern-house'          => array(
			'demo' => 'https://wpfrank.com/demo/modern-house/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/modern-house-premium/',
		),
		'leather-house'         => array(
			'demo' => 'https://wpfrank.com/demo/leather-house/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/leather-house-premium/',
		),
		'marin'                 => array(
			'demo' => 'https://wpfrank.com/demo/marin/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/marin-premium/',
		),
		'meme-token'            => array(
			'demo' => 'https://wpfrank.com/demo/meme-token/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/meme-token-premium/',
		),
		// ── Original themes ──
		'crypto-airdrop'        => array(
			'demo' => 'https://wpfrank.com/demo/crypto-airdrop-premium/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/crypto-airdrop-premium/',
		),
		'businessexpo'          => array(
			'demo' => 'https://wpfrank.com/demo/businessexpo-premium/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/businessexpo-premium/',
		),
		'architect-designs'     => array(
			'demo' => 'https://wpfrank.com/demo/architect-design-premium/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/architect-designs-premium/',
		),
		'crypto-mining'         => array(
			'demo' => 'https://wpfrank.com/demo/crypto-mining-premium/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/crypto-mining-premium/',
		),
		'crypto-compare'        => array(
			'demo' => 'https://wpfrank.com/demo/crypto-compare-premium/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/crypto-compare-premium/',
		),
		'building-construction' => array(
			'demo' => 'https://wpfrank.com/demo/building-construction-premium/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/building-construction-premium/',
		),
		'crypto-token'          => array(
			'demo' => 'https://wpfrank.com/demo/crypto-token-pro/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/crypto-token-premium/',
		),
		'medical-health'        => array(
			'demo' => 'https://wpfrank.com/demo/medical-health-premium/',
			'buy'  => 'https://wpfrank.com/wordpress-themes/medical-health-premium/',
		),
	);
}

/**
 * Build star-rating HTML from a ratings array.
 *
 * @param array $ratings Associative array [ star_value => count ].
 * @return string HTML markup.
 */
function reavantex_extras_star_rating_html( $ratings ) {

	$total_score = 0;
	$total_count = 0;

	foreach ( $ratings as $star => $count ) {
		$total_score += ( $star * $count );
		$total_count += $count;
	}

	$average  = $total_count > 0 ? $total_score / $total_count : 0;
	$filled   = floor( $average );
	$has_half = ( round( $average - $filled, 1 ) >= 0.5 );

	$html = '<div class="avantex-stars" title="' . esc_attr( round( $average, 1 ) . ' out of 5 stars' ) . '">';

	for ( $i = 0; $i < $filled; $i++ ) {
		$html .= '<span class="dashicons dashicons-star-filled"></span>';
	}
	if ( $has_half ) {
		$html .= '<span class="dashicons dashicons-star-half"></span>';
	}
	$empty = 5 - $filled - ( $has_half ? 1 : 0 );
	for ( $i = 0; $i < $empty; $i++ ) {
		$html .= '<span class="dashicons dashicons-star-empty"></span>';
	}

	$html .= '</div>';

	return $html;
}

/**
 * Retrieve cached plugins data from WordPress.org API.
 * Uses transient to cache API calls for 12 hours.
 *
 * @return array
 */
function reavantex_extras_get_cached_plugins() {
	$slugs  = reavantex_extras_get_plugin_slugs();
	$cached = get_transient( 'avantex_extras_plugins_data' );

	// Allow overriding cache via URL query param (?clear_avantex_cache=1).
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['clear_avantex_cache'] ) ) {
		$cached = false;
	}

	if ( false === $cached || ! is_array( $cached ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		$cached = array();

		foreach ( $slugs as $slug ) {
			$api = plugins_api(
				'plugin_information',
				array(
					'slug'   => $slug,
					'fields' => array(
						'name'              => true,
						'short_description' => true,
						'active_installs'   => true,
						'icons'             => true,
						'last_updated'      => true,
						'rating'            => true,
						'ratings'           => true,
						'downloaded'        => true,
						'version'           => true,
					),
				)
			);

			if ( ! is_wp_error( $api ) ) {
				$cached[ $slug ] = array(
					'name'              => $api->name,
					'short_description' => $api->short_description,
					'icons'             => $api->icons,
					'downloaded'        => $api->downloaded,
					'author'            => $api->author,
					'last_updated'      => $api->last_updated,
					'ratings'           => $api->ratings,
					'version'           => $api->version,
					'raw_api'           => $api,
				);
			}
		}

		set_transient( 'avantex_extras_plugins_data', $cached, 12 * HOUR_IN_SECONDS );
	}

	return $cached;
}

/**
 * Retrieve cached themes data from WordPress.org API.
 * Uses transient to cache API calls for 12 hours.
 *
 * @return array
 */
function reavantex_extras_get_cached_themes() {
	$theme_slugs_data = reavantex_extras_get_theme_data();
	$cached           = get_transient( 'avantex_extras_themes_data' );

	// Allow overriding cache via URL query param (?clear_avantex_cache=1).
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['clear_avantex_cache'] ) ) {
		$cached = false;
	}

	if ( false === $cached || ! is_array( $cached ) ) {
		require_once ABSPATH . 'wp-admin/includes/theme-install.php';
		$cached = array();

		foreach ( $theme_slugs_data as $slug => $links ) {
			// Skip avantex parent and child themes since avantex is already installed.
			if ( 'avantex' === $slug || strpos( $slug, 'avantex-' ) === 0 ) {
				continue;
			}

			$api = themes_api(
				'theme_information',
				array(
					'slug'   => $slug,
					'fields' => array(
						'name'            => true,
						'downloaded'      => true,
						'active_installs' => true,
						'screenshot_url'  => true,
						'last_updated'    => true,
						'rating'          => true,
						'ratings'         => true,
						'version'         => true,
						'preview_url'     => true,
						'parent'          => true,
						'author'          => true,
					),
				)
			);

			if ( ! is_wp_error( $api ) ) {
				// Skip if the fetched theme's parent is avantex.
				$is_parent_avantex = false;
				if ( isset( $api->parent ) ) {
					$parent_data = $api->parent;
					if ( is_array( $parent_data ) ) {
						if ( ( isset( $parent_data['slug'] ) && 'avantex' === $parent_data['slug'] ) || ( isset( $parent_data['name'] ) && strtolower( $parent_data['name'] ) === 'avantex' ) ) {
							$is_parent_avantex = true;
						}
					} elseif ( is_object( $parent_data ) ) {
						if ( ( isset( $parent_data->slug ) && 'avantex' === $parent_data->slug ) || ( isset( $parent_data->name ) && strtolower( $parent_data->name ) === 'avantex' ) ) {
							$is_parent_avantex = true;
						}
					} elseif ( is_string( $parent_data ) && 'avantex' === strtolower( $parent_data ) ) {
						$is_parent_avantex = true;
					}
				}

				if ( $is_parent_avantex ) {
					continue;
				}

				$cached[ $slug ] = array(
					'name'           => $api->name,
					'screenshot_url' => $api->screenshot_url,
					'downloaded'     => $api->downloaded,
					'last_updated'   => $api->last_updated,
					'ratings'        => $api->ratings,
					'version'        => $api->version,
					'author'         => $api->author,
					'parent'         => isset( $api->parent ) ? $api->parent : null,
					'demo'           => $links['demo'],
					'buy'            => $links['buy'],
				);
			}
		}

		set_transient( 'avantex_extras_themes_data', $cached, 12 * HOUR_IN_SECONDS );
	}

	return $cached;
}

/**
 * Render recommended plugins HTML.
 *
 * @return string HTML markup.
 */
function reavantex_extras_get_plugins_html() {
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	$avantex_cached_plugins = reavantex_extras_get_cached_plugins();

	ob_start();

	foreach ( $avantex_cached_plugins as $avantex_plugin_slug => $plugin_data ) :

		// Plugin metadata.
		$avantex_p_name     = $plugin_data['name'];
		$avantex_p_desc     = $plugin_data['short_description'];
		$avantex_p_icons    = $plugin_data['icons'];
		$avantex_p_dl       = $plugin_data['downloaded'];
		$avantex_p_author   = $plugin_data['author'];
		$avantex_p_updated  = $plugin_data['last_updated'];
		$avantex_p_ratings  = $plugin_data['ratings'];
		$avantex_p_version  = $plugin_data['version'];
		$avantex_plugin_api = $plugin_data['raw_api'];

		// Trim long plugin names (e.g. "Starter Templates — Starter Sites & Templates" → first 5 words).
		$avantex_p_words = explode( ' ', $avantex_p_name );
		if ( count( $avantex_p_words ) > 5 ) {
			$avantex_p_name = implode( ' ', array_slice( $avantex_p_words, 0, 5 ) ) . '…';
		}

		// Icon.
		$avantex_p_icon = isset( $avantex_p_icons['2x'] ) ? $avantex_p_icons['2x'] : ( isset( $avantex_p_icons['1x'] ) ? $avantex_p_icons['1x'] : '' );

		// Stars.
		$avantex_p_stars = reavantex_extras_star_rating_html( $avantex_p_ratings );

		// Button state.
		$avantex_p_install_status = install_plugin_install_status( $avantex_plugin_api );
		$avantex_p_btn_class      = 'avantex-extras-btn';
		$avantex_p_btn_label      = '';
		$avantex_p_btn_action     = '';
		$avantex_p_btn_disabled   = false;

		switch ( $avantex_p_install_status['status'] ) {
			case 'install':
				$avantex_p_btn_label  = esc_html__( 'Install Now', 'avantex' );
				$avantex_p_btn_action = 'avantex_extras_plugin_install';
				break;

			case 'update_available':
				$avantex_p_btn_label  = esc_html__( 'Update Now', 'avantex' );
				$avantex_p_btn_action = 'avantex_extras_plugin_update';
				break;

			case 'latest_installed':
			case 'newer_installed':
				$avantex_p_plugin_file = $avantex_plugin_slug . '/' . $avantex_plugin_slug . '.php';
				if ( is_plugin_active( $avantex_p_plugin_file ) ) {
					$avantex_p_btn_label    = esc_html__( 'Active', 'avantex' );
					$avantex_p_btn_class   .= ' avantex-extras-btn--success';
					$avantex_p_btn_disabled = true;
				} else {
					$avantex_p_btn_label  = esc_html__( 'Activate', 'avantex' );
					$avantex_p_btn_action = 'avantex_extras_plugin_activate';
				}
				break;
		}
		?>

		<div class="avantex-extras-card" id="avantex-plugin-<?php echo esc_attr( $avantex_plugin_slug ); ?>">
			<div class="avantex-extras-card__img">
				<?php if ( $avantex_p_icon ) : ?>
					<img src="<?php echo esc_url( $avantex_p_icon ); ?>" alt="<?php echo esc_attr( $avantex_p_name ); ?>" loading="lazy" />
				<?php endif; ?>
			</div>
			<div class="avantex-extras-card__body">
				<h3 class="avantex-extras-card__title"><?php echo esc_html( $avantex_p_name ); ?></h3>
				<?php echo wp_kses_post( $avantex_p_stars ); ?>
				<p class="avantex-extras-card__desc"><?php echo esc_html( $avantex_p_desc ); ?></p>
				<div class="avantex-extras-card__meta">
					<span><strong><?php esc_html_e( 'Downloads:', 'avantex' ); ?></strong> <?php echo esc_html( number_format_i18n( $avantex_p_dl ) ); ?></span>
					<span><strong><?php esc_html_e( 'Version:', 'avantex' ); ?></strong> <?php echo esc_html( $avantex_p_version ); ?></span>
				</div>
			</div>
			<div class="avantex-extras-card__footer">
				<span class="avantex-extras-card__updated">
					<?php
					/* translators: %s: Last updated date */
					printf( esc_html__( 'Updated: %s', 'avantex' ), esc_html( date_i18n( get_option( 'date_format' ), strtotime( $avantex_p_updated ) ) ) );
					?>
				</span>
				<button
					type="button"
					class="<?php echo esc_attr( $avantex_p_btn_class ); ?>"
					data-slug="<?php echo esc_attr( $avantex_plugin_slug ); ?>"
					data-action="<?php echo esc_attr( $avantex_p_btn_action ); ?>"
					<?php disabled( $avantex_p_btn_disabled ); ?>
				><?php echo esc_html( $avantex_p_btn_label ); ?></button>
			</div>
		</div>

		<?php
	endforeach;

	return ob_get_clean();
}

/**
 * Render recommended themes HTML.
 *
 * @return string HTML markup.
 */
function reavantex_extras_get_themes_html() {
	require_once ABSPATH . 'wp-admin/includes/theme-install.php';

	$avantex_cached_themes = reavantex_extras_get_cached_themes();
	$theme_slugs_data      = reavantex_extras_get_theme_data();

	ob_start();

	foreach ( $avantex_cached_themes as $avantex_theme_slug => $theme_data ) :

		// Theme metadata.
		$avantex_t_name       = $theme_data['name'];
		$avantex_t_screenshot = $theme_data['screenshot_url'];
		$avantex_t_dl         = $theme_data['downloaded'];
		$avantex_t_updated    = $theme_data['last_updated'];
		$avantex_t_ratings    = $theme_data['ratings'];
		$avantex_t_version    = $theme_data['version'];
		$avantex_t_author     = $theme_data['author'];
		$avantex_t_parent     = $theme_data['parent'];

		// Skip any other avantex child themes and the parent theme itself since we already have avantex installed.
		$is_avantex_child = false;
		if ( strpos( $avantex_theme_slug, 'avantex-' ) === 0 || 'avantex' === $avantex_theme_slug ) {
			$is_avantex_child = true;
		}
		if ( ! empty( $avantex_t_parent ) ) {
			if ( is_array( $avantex_t_parent ) ) {
				if ( ( isset( $avantex_t_parent['slug'] ) && 'avantex' === $avantex_t_parent['slug'] ) || ( isset( $avantex_t_parent['name'] ) && strtolower( $avantex_t_parent['name'] ) === 'avantex' ) ) {
					$is_avantex_child = true;
				}
			} elseif ( is_object( $avantex_t_parent ) ) {
				if ( ( isset( $avantex_t_parent->slug ) && 'avantex' === $avantex_t_parent->slug ) || ( isset( $avantex_t_parent->name ) && strtolower( $avantex_t_parent->name ) === 'avantex' ) ) {
					$is_avantex_child = true;
				}
			} elseif ( is_string( $avantex_t_parent ) && 'avantex' === strtolower( $avantex_t_parent ) ) {
				$is_avantex_child = true;
			}
		}

		if ( $is_avantex_child ) {
			continue;
		}

		// Stars.
		$avantex_t_stars = reavantex_extras_star_rating_html( $avantex_t_ratings );

		// Button state.
		$avantex_t_btn_class    = 'avantex-extras-btn';
		$avantex_t_btn_label    = '';
		$avantex_t_btn_action   = '';
		$avantex_t_btn_disabled = false;

		$avantex_t_theme_obj = wp_get_theme( $avantex_theme_slug );
		$avantex_t_installed = $avantex_t_theme_obj->exists() && is_dir( get_theme_root() . '/' . $avantex_theme_slug );

		if ( $avantex_t_installed ) {
			$avantex_t_current   = wp_get_theme();
			$avantex_t_is_active = ( $avantex_t_current->get_stylesheet() === $avantex_t_theme_obj->get_stylesheet() );

			if ( version_compare( $avantex_t_theme_obj->get( 'Version' ), $avantex_t_version, '<' ) ) {
				$avantex_t_btn_label  = esc_html__( 'Update Now', 'avantex' );
				$avantex_t_btn_action = 'avantex_extras_theme_update';
			} elseif ( $avantex_t_is_active ) {
				$avantex_t_btn_label    = esc_html__( 'Active', 'avantex' );
				$avantex_t_btn_class   .= ' avantex-extras-btn--success';
				$avantex_t_btn_disabled = true;
			} else {
				$avantex_t_btn_label  = esc_html__( 'Activate', 'avantex' );
				$avantex_t_btn_action = 'avantex_extras_theme_activate';
			}
		} else {
			$avantex_t_btn_label  = esc_html__( 'Install Free', 'avantex' );
			$avantex_t_btn_action = 'avantex_extras_theme_install';
		}
		?>

		<div class="avantex-extras-card avantex-extras-card--theme" id="avantex-theme-<?php echo esc_attr( $avantex_theme_slug ); ?>">
			<div class="avantex-extras-card__img avantex-extras-card__img--theme">
				<img src="<?php echo esc_url( $avantex_t_screenshot ); ?>" alt="<?php echo esc_attr( $avantex_t_name ); ?>" loading="lazy" />
			</div>
			<div class="avantex-extras-card__body">
				<h3 class="avantex-extras-card__title"><?php echo esc_html( $avantex_t_name ); ?></h3>
				<?php echo wp_kses_post( $avantex_t_stars ); ?>
				<?php if ( $avantex_t_parent && ! empty( $avantex_t_parent['name'] ) ) : ?>
					<p class="avantex-extras-card__parent">
						<?php
						/* translators: %s: Parent theme name */
						printf( esc_html__( 'Child theme of %s', 'avantex' ), '<strong>' . esc_html( $avantex_t_parent['name'] ) . '</strong>' );
						?>
					</p>
				<?php endif; ?>
				<div class="avantex-extras-card__meta">
					<span><strong><?php esc_html_e( 'Downloads:', 'avantex' ); ?></strong> <?php echo esc_html( number_format_i18n( $avantex_t_dl ) ); ?></span>
					<span><strong><?php esc_html_e( 'Version:', 'avantex' ); ?></strong> <?php echo esc_html( $avantex_t_version ); ?></span>
				</div>
			</div>
			<div class="avantex-extras-card__footer">
				<span class="avantex-extras-card__updated">
					<?php
					/* translators: %s: Last updated date */
					printf( esc_html__( 'Updated: %s', 'avantex' ), esc_html( date_i18n( get_option( 'date_format' ), strtotime( $avantex_t_updated ) ) ) );
					?>
				</span>
				<div class="avantex-extras-card__actions">
					<button
						type="button"
						class="<?php echo esc_attr( $avantex_t_btn_class ); ?>"
						data-slug="<?php echo esc_attr( $avantex_theme_slug ); ?>"
						data-action="<?php echo esc_attr( $avantex_t_btn_action ); ?>"
						<?php disabled( $avantex_t_btn_disabled ); ?>
					><?php echo esc_html( $avantex_t_btn_label ); ?></button>
					<a href="<?php echo esc_url( $theme_data['demo'] ); ?>" class="avantex-extras-btn avantex-extras-btn--demo" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Pro Demo', 'avantex' ); ?>
					</a>
					<a href="<?php echo esc_url( $theme_data['buy'] ); ?>" class="avantex-extras-btn avantex-extras-btn--buy" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Buy Now', 'avantex' ); ?>
					</a>
				</div>
			</div>
		</div>

		<?php
	endforeach;

	return ob_get_clean();
}

add_action( 'wp_ajax_avantex_extras_get_data', 'reavantex_extras_ajax_get_data' );

/**
 * AJAX: Fetch and return plugins & themes card markup.
 */
function reavantex_extras_ajax_get_data() {
	check_ajax_referer( 'avantex-extras-nonce', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
	}

	$plugins_html = reavantex_extras_get_plugins_html();
	$themes_html  = reavantex_extras_get_themes_html();

	wp_send_json_success(
		array(
			'plugins' => $plugins_html,
			'themes'  => $themes_html,
		)
	);
}

/*
────────────────────────────────────────────
 * 4. AJAX helpers (shared)
 * ────────────────────────────────────────────
*/

/**
 * Verify nonce + capability before processing an AJAX action.
 *
 * @param string $capability Required capability.
 */
function reavantex_extras_verify_ajax( $capability ) {

	check_ajax_referer( 'avantex-extras-nonce', 'nonce' );

	if ( ! current_user_can( $capability ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
	}
}

/**
 * Retrieve sanitised slug from $_POST.
 *
 * @return string
 */
function reavantex_extras_get_slug() {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	return isset( $_POST['slug'] ) ? sanitize_key( wp_unslash( $_POST['slug'] ) ) : '';
}

/*
────────────────────────────────────────────
 * 5. Plugin AJAX actions
 * ────────────────────────────────────────────
*/

add_action( 'wp_ajax_avantex_extras_plugin_install', 'reavantex_extras_ajax_install_plugin' );
add_action( 'wp_ajax_avantex_extras_plugin_update', 'reavantex_extras_ajax_update_plugin' );
add_action( 'wp_ajax_avantex_extras_plugin_activate', 'reavantex_extras_ajax_activate_plugin' );

/**
 * AJAX: Install a plugin, then activate it.
 */
function reavantex_extras_ajax_install_plugin() {

	reavantex_extras_verify_ajax( 'install_plugins' );
	$slug = reavantex_extras_get_slug();

	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

	$api = plugins_api( 'plugin_information', array( 'slug' => $slug ) );

	if ( is_wp_error( $api ) ) {
		wp_send_json_error( array( 'message' => $api->get_error_message() ) );
	}

	$skin     = new WP_Ajax_Upgrader_Skin();
	$upgrader = new Plugin_Upgrader( $skin );
	$result   = $upgrader->install( $api->download_link );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}

	// Auto-activate after install.
	$activate = activate_plugin( $slug . '/' . $slug . '.php' );

	if ( is_wp_error( $activate ) ) {
		// Installed but activation failed — still acceptable.
		wp_send_json_success( array( 'message' => esc_html__( 'Plugin installed. Activation failed — please activate manually.', 'avantex' ) ) );
	}

	wp_send_json_success( array( 'message' => esc_html__( 'Plugin installed and activated.', 'avantex' ) ) );
}

/**
 * AJAX: Update a plugin.
 */
function reavantex_extras_ajax_update_plugin() {

	reavantex_extras_verify_ajax( 'update_plugins' );
	$slug = reavantex_extras_get_slug();

	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

	$skin     = new WP_Ajax_Upgrader_Skin();
	$upgrader = new Plugin_Upgrader( $skin );
	$result   = $upgrader->upgrade( $slug . '/' . $slug . '.php' );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}

	wp_send_json_success( array( 'message' => esc_html__( 'Plugin updated successfully.', 'avantex' ) ) );
}

/**
 * AJAX: Activate a plugin.
 */
function reavantex_extras_ajax_activate_plugin() {

	reavantex_extras_verify_ajax( 'activate_plugins' );
	$slug = reavantex_extras_get_slug();

	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	$result = activate_plugin( $slug . '/' . $slug . '.php' );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}

	wp_send_json_success( array( 'message' => esc_html__( 'Plugin activated successfully.', 'avantex' ) ) );
}

/*
────────────────────────────────────────────
 * 6. Theme AJAX actions
 * ────────────────────────────────────────────
*/

add_action( 'wp_ajax_avantex_extras_theme_install', 'reavantex_extras_ajax_install_theme' );
add_action( 'wp_ajax_avantex_extras_theme_update', 'reavantex_extras_ajax_update_theme' );
add_action( 'wp_ajax_avantex_extras_theme_activate', 'reavantex_extras_ajax_activate_theme' );

/**
 * AJAX: Install a theme.
 */
function reavantex_extras_ajax_install_theme() {

	reavantex_extras_verify_ajax( 'install_themes' );
	$slug = reavantex_extras_get_slug();

	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/theme-install.php';

	$api = themes_api( 'theme_information', array( 'slug' => $slug ) );

	if ( is_wp_error( $api ) ) {
		wp_send_json_error( array( 'message' => $api->get_error_message() ) );
	}

	$skin     = new WP_Ajax_Upgrader_Skin();
	$upgrader = new Theme_Upgrader( $skin );
	$result   = $upgrader->install( $api->download_link );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}

	wp_send_json_success( array( 'message' => esc_html__( 'Theme installed successfully.', 'avantex' ) ) );
}

/**
 * AJAX: Update a theme.
 */
function reavantex_extras_ajax_update_theme() {

	reavantex_extras_verify_ajax( 'update_themes' );
	$slug = reavantex_extras_get_slug();

	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/theme-install.php';

	$skin     = new WP_Ajax_Upgrader_Skin();
	$upgrader = new Theme_Upgrader( $skin );
	$result   = $upgrader->upgrade( $slug );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}

	wp_send_json_success( array( 'message' => esc_html__( 'Theme updated successfully.', 'avantex' ) ) );
}

/**
 * AJAX: Activate a theme.
 */
function reavantex_extras_ajax_activate_theme() {

	reavantex_extras_verify_ajax( 'switch_themes' );
	$slug = reavantex_extras_get_slug();

	switch_theme( $slug );

	wp_send_json_success( array( 'message' => esc_html__( 'Theme activated successfully.', 'avantex' ) ) );
}
