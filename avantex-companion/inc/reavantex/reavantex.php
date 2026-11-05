<?php
/**
 * ReAvantex Theme Companion Support
 *
 * Provides automated default content setup, reading settings configuration,
 * primary menu assignment, starter posts, and OCDI demo support for ReAvantex.
 *
 * @package avantex-companion
 * @since   0.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'AVANTEX_COMPANION_VERSION' ) ) {
	define( 'AVANTEX_COMPANION_VERSION', '0.2.8' );
}
if ( ! defined( 'AVANTEX_COMPANION_REAVANTEX_DIR' ) ) {
	define( 'AVANTEX_COMPANION_REAVANTEX_DIR', AVANTEX_COMPANION_PLUGIN_DIR . 'inc/reavantex/' );
}
if ( ! defined( 'AVANTEX_COMPANION_REAVANTEX_URL' ) ) {
	define( 'AVANTEX_COMPANION_REAVANTEX_URL', AVANTEX_COMPANION_PLUGIN_URL . 'inc/reavantex/' );
}

if ( ! function_exists( 'reavantex_get_asset_url' ) ) {
	/**
	 * Companion asset URL resolver helper.
	 *
	 * @param string $path_or_url Relative path or URL.
	 * @return string
	 */
	function reavantex_get_asset_url( $path_or_url = '' ) {
		if ( empty( $path_or_url ) ) {
			return AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/';
		}
		if ( 0 === strpos( $path_or_url, 'http://' ) || 0 === strpos( $path_or_url, 'https://' ) || 0 === strpos( $path_or_url, '//' ) || 0 === strpos( $path_or_url, '/' ) ) {
			if ( preg_match( '#assets/images/(.+)$#', $path_or_url, $matches ) ) {
				return AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/' . ltrim( $matches[1], '/' );
			}
			return $path_or_url;
		}
		return AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/' . ltrim( $path_or_url, '/' );
	}
}

/**
 * Load automated default content creation.
 */
require_once AVANTEX_COMPANION_REAVANTEX_DIR . 'default-content.php';


/**
 * Load ReAvantex Extras admin page.
 */
if ( file_exists( AVANTEX_COMPANION_REAVANTEX_DIR . 'custom-extras/extras-page.php' ) ) {
	require_once AVANTEX_COMPANION_REAVANTEX_DIR . 'custom-extras/extras-page.php';
}

/**
 * Load ReAvantex Standalone Custom Demo Importer and Exporter.
 */
if ( file_exists( AVANTEX_COMPANION_REAVANTEX_DIR . 'custom-importer/class-avantex-demo-importer.php' ) ) {
	require_once AVANTEX_COMPANION_REAVANTEX_DIR . 'custom-importer/class-avantex-theme-reset.php';
	require_once AVANTEX_COMPANION_REAVANTEX_DIR . 'custom-importer/class-avantex-demo-importer.php';
}

if ( file_exists( AVANTEX_COMPANION_REAVANTEX_DIR . 'custom-importer/class-avantex-demo-exporter.php' ) ) {
	require_once AVANTEX_COMPANION_REAVANTEX_DIR . 'custom-importer/class-avantex-demo-exporter.php';
}



/**
 * Render ReAvantex frontpage sections when hooked via reavantex_frontpage.
 */
if ( ! function_exists( 'reavantex_companion_frontpage_sections' ) ) :
	/**
	 * Render ReAvantex frontpage sections in configured order.
	 */
	function reavantex_companion_frontpage_sections() {
		// Always show Slider first (Fixed at top).
		get_template_part( 'avantex-index/index', 'carousel' );

		$order_default  = '{"avantex-topbar-section":10,"avantex-menubar-section":15,"avantex-slider-section":20,"avantex-about-section":25,"avantex-services-section":30,"avantex-portfolio-section":35,"avantex-callout-section":40,"avantex-team-section":45,"avantex-testimonial-section":50,"avantex-funfact-section":55,"avantex-news-section":60,"avantex-sponsors-section":65,"avantex-copyright-section":70}';
		$orders         = get_theme_mod( 'avantex_sections_order', $order_default );
		if ( empty( $orders ) || ! is_string( $orders ) ) {
			$orders = $order_default;
		}
		$orders_decoded = json_decode( $orders );
		if ( empty( $orders_decoded ) || ! is_object( $orders_decoded ) ) {
			$orders_decoded = json_decode( $order_default );
		}

		if ( $orders_decoded ) {
			foreach ( $orders_decoded as $key => $value ) {
				// Skip slider section in the loop as it is fixed at the top.
				if ( 'avantex-slider-section' === $key ) {
					continue;
				}

				switch ( $key ) {
					case 'avantex-about-section':
						get_template_part( 'avantex-index/index', 'about' );
						break;
					case 'avantex-services-section':
						get_template_part( 'avantex-index/index', 'service' );
						break;
					case 'avantex-portfolio-section':
						get_template_part( 'avantex-index/index', 'portfolio' );
						break;
					case 'avantex-callout-section':
						get_template_part( 'avantex-index/index', 'callout' );
						break;
					case 'avantex-team-section':
						get_template_part( 'avantex-index/index', 'team' );
						break;
					case 'avantex-testimonial-section':
						get_template_part( 'avantex-index/index', 'testimonial' );
						break;
					case 'avantex-funfact-section':
						get_template_part( 'avantex-index/index', 'funfact' );
						break;
					case 'avantex-news-section':
						get_template_part( 'avantex-index/index', 'news' );
						break;
					case 'avantex-sponsors-section':
						get_template_part( 'avantex-index/index', 'sponsor' );
						break;
				}
			}
		}
	}
	add_action( 'reavantex_frontpage', 'reavantex_companion_frontpage_sections' );
endif;

/**
 * Register page templates from the plugin for ReAvantex.
 *
 * @param array $templates Existing page templates.
 * @return array Modified page templates.
 */
function avantex_companion_register_reavantex_page_templates( $templates ) {
	$theme_name = wp_get_theme()->get( 'Name' );
	if ( 'ReAvantex' !== $theme_name && 'reavantex' !== strtolower( $theme_name ) ) {
		return $templates;
	}

	$plugin_templates = array(
		'reavantex-companion/page-about-us.php'         => __( 'Avantex About-US', 'avantex-companion' ),
		'reavantex-companion/page-services.php'         => __( 'Avantex Services', 'avantex-companion' ),
		'reavantex-companion/page-portfolio.php'        => __( 'Avantex Portfolio', 'avantex-companion' ),
		'reavantex-companion/page-faq.php'              => __( 'Avantex FAQ', 'avantex-companion' ),
		'reavantex-companion/page-contact-us.php'       => __( 'Avantex Contact-US', 'avantex-companion' ),
		'reavantex-companion/page-privacy-policy.php'   => __( 'Avantex Privacy Policy', 'avantex-companion' ),
		'reavantex-companion/page-terms-of-service.php' => __( 'Avantex Terms Of Service', 'avantex-companion' ),
		'reavantex-companion/page-blog-template.php'    => __( 'Avantex Blog-Template', 'avantex-companion' ),
	);

	return array_merge( $templates, $plugin_templates );
}
add_filter( 'theme_page_templates', 'avantex_companion_register_reavantex_page_templates' );

/**
 * Load page templates from the plugin directory.
 *
 * @param string $template The path to the template.
 * @return string Modified template path.
 */
function avantex_companion_load_reavantex_page_template( $template ) {
	$page_template = get_page_template_slug();

	if ( strpos( $page_template, 'reavantex-companion/' ) === 0 ) {
		$plugin_template = AVANTEX_COMPANION_REAVANTEX_DIR . 'page-templates/' . str_replace( 'reavantex-companion/', '', $page_template );
		if ( file_exists( $plugin_template ) ) {
			return $plugin_template;
		}
	}

	// Backward compatibility: handle old theme template paths.
	$old_template_map = array(
		'templates/avantex-about-us.php'         => 'page-about-us.php',
		'templates/avantex-services.php'         => 'page-services.php',
		'templates/avantex-portfolio.php'        => 'page-portfolio.php',
		'templates/avantex-faq.php'              => 'page-faq.php',
		'templates/avantex-contact-us.php'       => 'page-contact-us.php',
		'templates/avantex-privacy-policy.php'   => 'page-privacy-policy.php',
		'templates/avantex-terms-of-service.php' => 'page-terms-of-service.php',
		'templates/avantex-blog-template.php'    => 'page-blog-template.php',
	);

	if ( isset( $old_template_map[ $page_template ] ) ) {
		$plugin_template = AVANTEX_COMPANION_REAVANTEX_DIR . 'page-templates/' . $old_template_map[ $page_template ];
		if ( file_exists( $plugin_template ) ) {
			return $plugin_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'avantex_companion_load_reavantex_page_template' );

/**
 * Register ReAvantex Template Settings in Customizer via Companion Plugin.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 */
function reavantex_companion_customize_register( $wp_customize ) {
	$theme_dir = get_stylesheet_directory();

	// Safely ensure custom controls from the theme are loaded.
	if ( ! class_exists( 'Skyrocket_Custom_Control' ) && file_exists( $theme_dir . '/customizer-custom-controls-master/inc/custom-controls.php' ) ) {
		require_once $theme_dir . '/customizer-custom-controls-master/inc/custom-controls.php';
	}
	if ( ! class_exists( 'Customizer_Repeater' ) && file_exists( $theme_dir . '/customizer-controls-master/customizer-repeater/class/class-customizer-repeater.php' ) ) {
		require_once $theme_dir . '/customizer-controls-master/customizer-repeater/class/class-customizer-repeater.php';
	}
	if ( ! class_exists( 'Customizer_Page_Editor' ) && file_exists( $theme_dir . '/customizer-controls-master/customizer-page-editor/class/class-customizer-page-editor.php' ) ) {
		require_once $theme_dir . '/customizer-controls-master/customizer-page-editor/class/class-customizer-page-editor.php';
	}

	if ( ! class_exists( 'Skyrocket_Simple_Notice_Custom_control' ) ) {
		return;
	}

	// Ensure the templates panel exists.
	if ( ! $wp_customize->get_panel( 'avantex-templates-panel' ) ) {
		$wp_customize->add_panel(
			'avantex-templates-panel',
			array(
				'title'       => __( 'Avantex Templates Settings', 'avantex-companion' ),
				'priority'    => 4,
				'description' => __( 'All avantex templates related settings', 'avantex-companion' ),
			)
		);
	}

	$custom_template_dir = AVANTEX_COMPANION_REAVANTEX_DIR . 'custom-template/';
	if ( file_exists( $custom_template_dir . 'custom-about-us.php' ) ) {
		require $custom_template_dir . 'custom-about-us.php';
	}
	if ( file_exists( $custom_template_dir . 'custom-services.php' ) ) {
		require $custom_template_dir . 'custom-services.php';
	}
	if ( file_exists( $custom_template_dir . 'custom-portfolio.php' ) ) {
		require $custom_template_dir . 'custom-portfolio.php';
	}
	if ( file_exists( $custom_template_dir . 'custom-faq.php' ) ) {
		require $custom_template_dir . 'custom-faq.php';
	}
	if ( file_exists( $custom_template_dir . 'custom-contact-us.php' ) ) {
		require $custom_template_dir . 'custom-contact-us.php';
	}
	if ( file_exists( $custom_template_dir . 'custom-privacy-policy.php' ) ) {
		require $custom_template_dir . 'custom-privacy-policy.php';
	}
	if ( file_exists( $custom_template_dir . 'custom-terms-of-service.php' ) ) {
		require $custom_template_dir . 'custom-terms-of-service.php';
	}
}
add_action( 'customize_register', 'reavantex_companion_customize_register', 25 );

/**
 * Trigger default setup upon plugin activation if ReAvantex is the active theme.
 */
function reavantex_companion_activation_setup() {
	$theme_name = wp_get_theme()->get( 'Name' );
	if ( 'ReAvantex' === $theme_name || 'reavantex' === strtolower( $theme_name ) ) {
		if ( function_exists( 'reavantex_companion_setup_default_pages' ) ) {
			reavantex_companion_setup_default_pages();
		}
		if ( function_exists( 'reavantex_companion_create_default_blog_posts' ) ) {
			reavantex_companion_create_default_blog_posts();
		}
	}
}
register_activation_hook( AVANTEX_COMPANION_PLUGIN_DIR . 'avantex-companion.php', 'reavantex_companion_activation_setup' );
