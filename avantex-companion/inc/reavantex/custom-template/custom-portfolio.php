<?php
/**
 * Section for Portfolio Template settings.
 *
 * @package avantex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'avantex-template-portfolio-section',
	array(
		'title'       => __( 'Portfolio template settings', 'reavantex' ),
		'panel'       => 'avantex-templates-panel',
		'description' => __( 'Settings for Avantex Portfolio page template.', 'reavantex' ),
	)
);

// ==========================================
// --- GENERAL SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-portfolio-general-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-portfolio-general-notice-control',
		array(
			'label'    => __( '--- General Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-portfolio-general-notice',
			'section'  => 'avantex-template-portfolio-section',
			'priority' => 10,
		)
	)
);

// Container size.
$wp_customize->add_setting(
	'avantex-template-portfolio-container',
	array(
		'default'           => 'container',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Text_Radio_Button_Custom_Control(
		$wp_customize,
		'avantex-template-portfolio-container-control',
		array(
			'label'       => __( 'Portfolio Container size', 'reavantex' ),
			'description' => esc_html__( 'Choose size of Container.', 'reavantex' ),
			'section'     => 'avantex-template-portfolio-section',
			'settings'    => 'avantex-template-portfolio-container',
			'choices'     => array(
				'container'           => __( 'Container', 'reavantex' ),
				'container-full'      => __( 'Full Container', 'reavantex' ),
				'container-fluid p-0' => __( 'fluid', 'reavantex' ),
			),
			'priority'    => 20,
		)
	)
);

// Toggle Page Content Area.
$wp_customize->add_setting(
	'avantex-portfoliopage-show-content',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-portfoliopage-show-content-control',
		array(
			'label'    => esc_html__( 'Show Page Content Area', 'reavantex' ),
			'section'  => 'avantex-template-portfolio-section',
			'settings' => 'avantex-portfoliopage-show-content',
			'priority' => 30,
		)
	)
);


// ==========================================
// --- HERO INTRO SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-portfolio-hero-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-portfolio-hero-notice-control',
		array(
			'label'    => __( '--- Hero Intro Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-portfolio-hero-notice',
			'section'  => 'avantex-template-portfolio-section',
			'priority' => 40,
		)
	)
);

// Toggle Hero Section.
$wp_customize->add_setting(
	'avantex-portfoliopage-show-hero',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-portfoliopage-show-hero-control',
		array(
			'label'    => esc_html__( 'Show Hero Intro Section', 'reavantex' ),
			'section'  => 'avantex-template-portfolio-section',
			'settings' => 'avantex-portfoliopage-show-hero',
			'priority' => 50,
		)
	)
);


// Hero Design Layout Style (SVG Choice Radio Control).
$wp_customize->add_setting(
	'avantex-portfoliopage-hero-layout',
	array(
		'default'           => 'layout_light',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Image_Radio_Button_Custom_Control(
		$wp_customize,
		'avantex-portfoliopage-hero-layout-control',
		array(
			'label'           => __( 'Hero Design Layout Style', 'reavantex' ),
			// 'description' => esc_html__( 'Choose between Layout 1 (Creative Light Collage) and Layout 2 (Premium Dark Glass Hero).', 'avantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-hero-layout',
			'priority'        => 55,
			'choices'         => array(
				'layout_light' => array(
					'image' => trailingslashit( get_stylesheet_directory_uri() ) . 'customizer-custom-controls-master/images/hero-light-layout.svg',
					'name'  => __( 'Creative Light Collage', 'reavantex' ),
				),
				'layout_dark'  => array(
					'image' => trailingslashit( get_stylesheet_directory_uri() ) . 'customizer-custom-controls-master/images/hero-dark-layout.svg',
					'name'  => __( 'Premium Dark Glass', 'reavantex' ),
				),
			),
			'active_callback' => function ( $control ) {
				return 1 === (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
			},
		)
	)
);

// Hero Main Image.
$wp_customize->add_setting(
	'avantex-portfoliopage-hero-image',
	array(
		'default'           => ( function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'portfolio/project-1.webp' ) : get_stylesheet_directory_uri() . '/assets/images/portfolio/project-1.webp' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'avantex-portfoliopage-hero-image-control',
		array(
			'label'           => __( 'Hero Main Image (Collage 1)', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-hero-image',
			'priority'        => 60,
			'active_callback' => function ( $control ) {
				$show_hero   = (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
				$hero_layout = $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' ) ? $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' )->value() : 'layout_light';
				return ( 1 === $show_hero && 'layout_light' === $hero_layout );
			},
		)
	)
);

// Hero Image 2.
$wp_customize->add_setting(
	'avantex-portfoliopage-hero-image-2',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'avantex-portfoliopage-hero-image-2-control',
		array(
			'label'           => __( 'Collage Image 2 (Top Right)', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-hero-image-2',
			'priority'        => 62,
			'active_callback' => function ( $control ) {
				$show_hero   = (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
				$hero_layout = $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' ) ? $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' )->value() : 'layout_light';
				return ( 1 === $show_hero && 'layout_light' === $hero_layout );
			},
		)
	)
);

// Hero Image 3.
$wp_customize->add_setting(
	'avantex-portfoliopage-hero-image-3',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'avantex-portfoliopage-hero-image-3-control',
		array(
			'label'           => __( 'Collage Image 3 (Bottom Left)', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-hero-image-3',
			'priority'        => 64,
			'active_callback' => function ( $control ) {
				$show_hero   = (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
				$hero_layout = $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' ) ? $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' )->value() : 'layout_light';
				return ( 1 === $show_hero && 'layout_light' === $hero_layout );
			},
		)
	)
);

// Hero Subtitle.
$wp_customize->add_setting(
	'avantex-portfoliopage-hero-subtitle',
	array(
		'default'           => __( 'Portfolio', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-hero-subtitle-control',
		array(
			'label'           => __( 'Hero Subtitle', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-hero-subtitle',
			'type'            => 'text',
			'priority'        => 70,
			'active_callback' => function ( $control ) {
				return 1 === (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
			},
		)
	)
);

// Hero Title.
$wp_customize->add_setting(
	'avantex-portfoliopage-hero-title',
	array(
		'default'           => __( 'Innovative Projects Built with Excellence', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-hero-title-control',
		array(
			'label'           => __( 'Hero Title', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-hero-title',
			'type'            => 'text',
			'priority'        => 80,
			'active_callback' => function ( $control ) {
				return 1 === (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
			},
		)
	)
);

// Hero Description.
$wp_customize->add_setting(
	'avantex-portfoliopage-hero-desc',
	array(
		'default'           => __( 'Explore our collection of successful projects and digital products. We work closely with our clients to transform ideas into robust solutions.', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-hero-desc-control',
		array(
			'label'           => __( 'Hero Description', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-hero-desc',
			'type'            => 'textarea',
			'priority'        => 90,
			'active_callback' => function ( $control ) {
				return 1 === (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
			},
		)
	)
);

// --- Dark Hero Stat Badges Notice ---
$wp_customize->add_setting(
	'avantex-template-portfolio-dark-hero-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-portfolio-dark-hero-notice-control',
		array(
			'label'           => __( '--- Dark Hero Stat Badges ---', 'reavantex' ),
			'settings'        => 'avantex-template-portfolio-dark-hero-notice',
			'section'         => 'avantex-template-portfolio-section',
			'priority'        => 92,
			'active_callback' => function ( $control ) {
				$show_hero   = (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
				$hero_layout = $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' ) ? $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' )->value() : 'layout_light';
				return ( 1 === $show_hero && 'layout_dark' === $hero_layout );
			},
		)
	)
);

// Show Dark Hero Stats Bar.
$wp_customize->add_setting(
	'avantex-portfoliopage-dark-hero-show-stats',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-portfoliopage-dark-hero-show-stats-control',
		array(
			'label'           => esc_html__( 'Show Dark Hero Stats Bar', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-dark-hero-show-stats',
			'priority'        => 93,
			'active_callback' => function ( $control ) {
				$show_hero   = (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
				$hero_layout = $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' ) ? $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' )->value() : 'layout_light';
				return ( 1 === $show_hero && 'layout_dark' === $hero_layout );
			},
		)
	)
);

// Manage Dark Hero Stat Badges Repeater.
$wp_customize->add_setting(
	'avantex-portfoliopage-dark-hero-stats-repeater',
	array(
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_PORTFOLIO_DARK_HERO_STATS_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_DARK_HERO_STATS_DEFAULTS : '[]',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-portfoliopage-dark-hero-stats-repeater-control',
		array(
			'label'                                => esc_html__( 'Manage Dark Hero Stat Badges', 'reavantex' ),
			'section'                              => 'avantex-template-portfolio-section',
			'settings'                             => 'avantex-portfoliopage-dark-hero-stats-repeater',
			'priority'                             => 95,
			'item_limit'                             => 16,
			'customizer_repeater_title_control'    => true,
			'customizer_repeater_subtitle_control' => true,
			'active_callback'                      => function ( $control ) {
				$show_hero   = (int) $control->manager->get_setting( 'avantex-portfoliopage-show-hero' )->value();
				$hero_layout = $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' ) ? $control->manager->get_setting( 'avantex-portfoliopage-hero-layout' )->value() : 'layout_light';
				return ( 1 === $show_hero && 'layout_dark' === $hero_layout );
			},
		)
	)
);

// Register selective refresh partial for Dark Hero Stats Repeater
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'avantex-portfolio-dark-hero-stats-partial',
		array(
			'selector'        => '.portfolio-hero-dark-layout .hero-stats-bar',
			'settings'        => array( 'avantex-portfoliopage-dark-hero-stats-repeater' ),
			'render_callback' => function () {
				$dark_stats_json   = get_theme_mod( 'avantex-portfoliopage-dark-hero-stats-repeater', ( defined( 'REAVANTEX_PORTFOLIO_DARK_HERO_STATS_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_DARK_HERO_STATS_DEFAULTS : '[]' ) );
				$decoded_dark_stats = ! empty( $dark_stats_json ) ? json_decode( $dark_stats_json ) : array();
				if ( empty( $decoded_dark_stats ) ) {
					return;
				}
				$total_stats = count( $decoded_dark_stats );
				foreach ( $decoded_dark_stats as $index => $stat ) {
					$stat_val = ! empty( $stat->title ) ? $stat->title : '';
					$stat_lbl = ! empty( $stat->subtitle ) ? $stat->subtitle : '';
					$border_class = ( $index < $total_stats - 1 ) ? 'border-right' : '';
					if ( empty( $stat_val ) && empty( $stat_lbl ) ) {
						continue;
					}
					echo '<div class="col-4 col-sm-3 ' . esc_attr( $border_class ) . '">';
					echo '<h3 class="font-weight-bold mb-0">' . esc_html( $stat_val ) . '</h3>';
					echo '<span>' . esc_html( $stat_lbl ) . '</span>';
					echo '</div>';
				}
			},
		)
	);
}


// ==========================================
// --- PORTFOLIO GRID SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-portfolio-grid-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-portfolio-grid-notice-control',
		array(
			'label'    => __( '--- Portfolio Grid Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-portfolio-grid-notice',
			'section'  => 'avantex-template-portfolio-section',
			'priority' => 100,
		)
	)
);

// Toggle Grid Section.
$wp_customize->add_setting(
	'avantex-portfoliopage-show-grid',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-portfoliopage-show-grid-control',
		array(
			'label'    => esc_html__( 'Show Portfolio Grid', 'reavantex' ),
			'section'  => 'avantex-template-portfolio-section',
			'settings' => 'avantex-portfoliopage-show-grid',
			'priority' => 110,
		)
	)
);

// Active callbacks for grid controls
if ( ! function_exists( 'reavantex_if_portfoliopage_grid_enabled' ) ) {
	function reavantex_if_portfoliopage_grid_enabled( $control ) {
		return 1 === (int) $control->manager->get_setting( 'avantex-portfoliopage-show-grid' )->value();
	}
}

// Grid Subtitle.
$wp_customize->add_setting(
	'avantex-portfoliopage-subtitle',
	array(
		'default'           => __( 'Featured Works', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-subtitle-control',
		array(
			'label'           => __( 'Grid Section Subtitle', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-subtitle',
			'type'            => 'text',
			'priority'        => 120,
			'active_callback' => 'reavantex_if_portfoliopage_grid_enabled',
		)
	)
);

// Grid Title.
$wp_customize->add_setting(
	'avantex-portfoliopage-title',
	array(
		'default'           => __( 'Our Featured Projects', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-title-control',
		array(
			'label'           => __( 'Grid Section Title', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-title',
			'type'            => 'text',
			'priority'        => 130,
			'active_callback' => 'reavantex_if_portfoliopage_grid_enabled',
		)
	)
);

// Grid Columns.
$wp_customize->add_setting(
	'avantex-portfoliopage-grid',
	array(
		'default'           => 'col-lg-6',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Image_Radio_Button_Custom_Control(
		$wp_customize,
		'avantex-portfoliopage-grid-control',
		array(
			'label'           => __( 'Grid Columns layout', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-grid',
			'priority'        => 150,
			'choices'         => array(
				'col-lg-6' => array(
					'image' => trailingslashit( get_stylesheet_directory_uri() ) . 'customizer-custom-controls-master/images/column-2.png',
					'name'  => __( '2 Columns', 'reavantex' ),
				),
				'col-lg-4' => array(
					'image' => trailingslashit( get_stylesheet_directory_uri() ) . 'customizer-custom-controls-master/images/column-3.png',
					'name'  => __( '3 Columns', 'reavantex' ),
				),
				'col-lg-3' => array(
					'image' => trailingslashit( get_stylesheet_directory_uri() ) . 'customizer-custom-controls-master/images/column-4.png',
					'name'  => __( '4 Columns', 'reavantex' ),
				),
			),
			'active_callback' => 'reavantex_if_portfoliopage_grid_enabled',
		)
	)
);

// Repeater 1: Manage Portfolio items.
$wp_customize->add_setting(
	'avantex-portfoliopage-repeater',
	array(
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_PORTFOLIO_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_DEFAULTS : '[]',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-portfoliopage-repeater-control',
		array(
			'label'                                 => esc_html__( 'Manage Portfolio items', 'reavantex' ),
			'settings'                              => 'avantex-portfoliopage-repeater',
			'section'                               => 'avantex-template-portfolio-section',
			'add_field_label'                       => esc_html__( 'Add Project', 'reavantex' ),
			'item_name'                             => esc_html__( 'Project', 'reavantex' ),
			'box_title_preference'                  => 'subtitle',
			'priority'                              => 160,
			'item_limit'                             => 16,
			'customizer_repeater_image_control'     => true,
			'customizer_repeater_icon_control'      => false,
			'customizer_repeater_title_control'     => true,
			'customizer_repeater_btntitle_control'  => true,
			'customizer_repeater_subtitle_control'  => true,
			'customizer_repeater_text_control'      => true,
			'customizer_repeater_text2_control'     => false,
			'customizer_repeater_link_control'      => true,
			'customizer_repeater_link2_control'     => true,
			'customizer_repeater_shortcode_control' => false,
			'customizer_repeater_repeater_control'  => false,
			'customizer_repeater_color_control'     => false,
			'customizer_repeater_color2_control'    => false,
			'active_callback'                       => 'reavantex_if_portfoliopage_grid_enabled',
		)
	)
);

// Custom Control Class for Dynamic Project Breakdown Editing
if ( class_exists( 'Skyrocket_Custom_Control' ) && ! class_exists( 'Skyrocket_Project_Breakdown_Custom_Control' ) ) {
	class Skyrocket_Project_Breakdown_Custom_Control extends Skyrocket_Custom_Control {
		public $type = 'project_breakdown';

		public function render_content() {
			$raw_value    = $this->value();
			$repeater_mod = get_theme_mod( 'avantex-portfoliopage-repeater', ( defined( 'REAVANTEX_PORTFOLIO_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_DEFAULTS : '[]' ) );
			$items        = json_decode( $repeater_mod, true );
			if ( empty( $items ) || ! is_array( $items ) ) {
				$items = json_decode( ( defined( 'REAVANTEX_PORTFOLIO_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_DEFAULTS : '[]' ), true );
			}
			?>
			<div class="skyrocket-project-breakdown-box">
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>

				<!-- Dynamic Dropdown Project Selector -->
				<div class="avantex-breakdown-selector-wrapper">
					<label class="breakdown-selector-label" for="avantex-breakdown-select-<?php echo esc_attr( $this->id ); ?>">
						<span class="dashicons dashicons-portfolio"></span> <?php esc_html_e( 'Select Project to Edit Breakdown:', 'reavantex' ); ?>
					</label>
					<select id="avantex-breakdown-select-<?php echo esc_attr( $this->id ); ?>" class="avantex-breakdown-project-select">
						<?php
						foreach ( $items as $idx => $item ) :
							$item_title  = ! empty( $item['subtitle'] ) ? $item['subtitle'] : ( ! empty( $item['title'] ) ? $item['title'] : 'Project #' . ( $idx + 1 ) );
							$client_name = ! empty( $item['btntitle'] ) ? $item['btntitle'] : ( ! empty( $item['button_title'] ) ? $item['button_title'] : '' );
							$label_text  = 'Project #' . ( $idx + 1 ) . ': ' . $item_title . ( $client_name ? ' (' . $client_name . ')' : '' );
							?>
							<option value="<?php echo esc_attr( $idx ); ?>"><?php echo esc_html( $label_text ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<!-- Breakdown Editable Fields Form -->
				<div class="avantex-breakdown-fields-form">
					<div class="breakdown-form-group">
						<label class="breakdown-field-label"><?php esc_html_e( 'Detailed Project Description:', 'reavantex' ); ?></label>
						<textarea class="breakdown-field-detailed-desc" rows="3" placeholder="<?php esc_attr_e( 'Enter full detailed project description...', 'reavantex' ); ?>"></textarea>
					</div>

					<div class="breakdown-form-group">
						<label class="breakdown-field-label"><?php esc_html_e( 'The Challenge Narrative:', 'reavantex' ); ?></label>
						<textarea class="breakdown-field-challenge" rows="3" placeholder="<?php esc_attr_e( 'Describe project challenge...', 'reavantex' ); ?>"></textarea>
					</div>

					<div class="breakdown-form-group">
						<label class="breakdown-field-label"><?php esc_html_e( 'Our Approach & Solution:', 'reavantex' ); ?></label>
						<textarea class="breakdown-field-solution" rows="3" placeholder="<?php esc_attr_e( 'Describe solution...', 'reavantex' ); ?>"></textarea>
					</div>

					<div class="breakdown-form-group">
						<label class="breakdown-field-label"><?php esc_html_e( 'Key Deliverables (Comma-separated):', 'reavantex' ); ?></label>
						<input type="text" class="breakdown-field-deliverables" placeholder="<?php esc_attr_e( 'Design System, API Pipeline, Micro-interactions', 'reavantex' ); ?>" />
					</div>

					<div class="breakdown-form-row">
						<div class="breakdown-col">
							<label class="breakdown-field-label"><?php esc_html_e( 'Primary Metric Value:', 'reavantex' ); ?></label>
							<input type="text" class="breakdown-field-metric1" placeholder="<?php esc_attr_e( '+40% Efficiency', 'reavantex' ); ?>" />
						</div>
						<div class="breakdown-col">
							<label class="breakdown-field-label"><?php esc_html_e( 'Primary Metric Label:', 'reavantex' ); ?></label>
							<input type="text" class="breakdown-field-metric1-label" placeholder="<?php esc_attr_e( 'Primary Performance Metric', 'reavantex' ); ?>" />
						</div>
					</div>

					<div class="breakdown-form-row">
						<div class="breakdown-col">
							<label class="breakdown-field-label"><?php esc_html_e( 'Secondary Metric Value:', 'reavantex' ); ?></label>
							<input type="text" class="breakdown-field-metric2" placeholder="<?php esc_attr_e( '-55% Task Friction', 'reavantex' ); ?>" />
						</div>
						<div class="breakdown-col">
							<label class="breakdown-field-label"><?php esc_html_e( 'Secondary Metric Label:', 'reavantex' ); ?></label>
							<input type="text" class="breakdown-field-metric2-label" placeholder="<?php esc_attr_e( 'Task Friction Reduction', 'reavantex' ); ?>" />
						</div>
					</div>

					<div class="breakdown-form-group">
						<label class="breakdown-field-label"><?php esc_html_e( 'Client Testimonial Quote & Author:', 'reavantex' ); ?></label>
						<textarea class="breakdown-field-quote" rows="2" placeholder="<?php esc_attr_e( '"Quote text..." — Author Name', 'reavantex' ); ?>"></textarea>
					</div>

					<div class="breakdown-section-divider">
						<span class="dashicons dashicons-admin-settings"></span>
						<span><?php esc_html_e( 'Project Overview Sidebar Items', 'reavantex' ); ?></span>
					</div>

					<div class="breakdown-form-group">
						<label class="breakdown-field-label"><?php esc_html_e( 'Timeline:', 'reavantex' ); ?></label>
						<input type="text" class="breakdown-field-timeline" placeholder="<?php esc_attr_e( '3 Months (2026)', 'reavantex' ); ?>" />
					</div>

					<div class="breakdown-form-group">
						<label class="breakdown-field-label"><?php esc_html_e( 'Role / Services:', 'reavantex' ); ?></label>
						<input type="text" class="breakdown-field-role" placeholder="<?php esc_attr_e( 'Lead UI/UX & Full-stack', 'reavantex' ); ?>" />
					</div>

					<div class="breakdown-form-group">
						<label class="breakdown-field-label"><?php esc_html_e( 'Project Status:', 'reavantex' ); ?></label>
						<input type="text" class="breakdown-field-status" placeholder="<?php esc_attr_e( 'Completed & Live', 'reavantex' ); ?>" />
					</div>
				</div>

				<!-- Hidden input bound to WordPress Customizer setting -->
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); ?> value="<?php echo esc_attr( $raw_value ); ?>" class="avantex-breakdown-hidden-setting" />
			</div>

			<!-- Inline Control JS Logic -->
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var $wrapper = $('#customize-control-<?php echo esc_js( $this->id ); ?>');
					var $select  = $wrapper.find('.avantex-breakdown-project-select');
					var $hidden  = $wrapper.find('.avantex-breakdown-hidden-setting');

					function reavantex_getDetailsObj() {
						try {
							var val = $hidden.val();
							return val ? JSON.parse(val) : {};
						} catch(e) {
							return {};
						}
					}

					function reavantex_loadSelectedProjectFields() {
						var idx = $select.val();
						var data = reavantex_getDetailsObj();
						var current = data[idx] || {};

						$wrapper.find('.breakdown-field-detailed-desc').val(current.detailed_desc || current.description || current.text2 || '');
						$wrapper.find('.breakdown-field-challenge').val(current.challenge || '');
						$wrapper.find('.breakdown-field-solution').val(current.solution || '');
						$wrapper.find('.breakdown-field-deliverables').val(current.deliverables || '');
						$wrapper.find('.breakdown-field-metric1').val(current.metric_1 || '');
						$wrapper.find('.breakdown-field-metric1-label').val(current.metric_1_label || 'Primary Performance Metric');
						$wrapper.find('.breakdown-field-metric2').val(current.metric_2 || '');
						$wrapper.find('.breakdown-field-metric2-label').val(current.metric_2_label || 'Task Friction Reduction');
						$wrapper.find('.breakdown-field-quote').val(current.quote || '');
						$wrapper.find('.breakdown-field-timeline').val(current.timeline || '3 Months (2026)');
						$wrapper.find('.breakdown-field-role').val(current.role || 'Lead UI/UX & Full-stack');
						$wrapper.find('.breakdown-field-status').val(current.status || 'Completed & Live');
					}

					function reavantex_saveSelectedProjectFields() {
						var idx = $select.val();
						var data = reavantex_getDetailsObj();

						if (!data[idx]) data[idx] = {};

						data[idx].detailed_desc  = $wrapper.find('.breakdown-field-detailed-desc').val();
						data[idx].challenge      = $wrapper.find('.breakdown-field-challenge').val();
						data[idx].solution       = $wrapper.find('.breakdown-field-solution').val();
						data[idx].deliverables   = $wrapper.find('.breakdown-field-deliverables').val();
						data[idx].metric_1       = $wrapper.find('.breakdown-field-metric1').val();
						data[idx].metric_1_label = $wrapper.find('.breakdown-field-metric1-label').val();
						data[idx].metric_2       = $wrapper.find('.breakdown-field-metric2').val();
						data[idx].metric_2_label = $wrapper.find('.breakdown-field-metric2-label').val();
						data[idx].quote          = $wrapper.find('.breakdown-field-quote').val();
						data[idx].timeline       = $wrapper.find('.breakdown-field-timeline').val();
						data[idx].role           = $wrapper.find('.breakdown-field-role').val();
						data[idx].status         = $wrapper.find('.breakdown-field-status').val();

						var jsonStr = JSON.stringify(data);
						$hidden.val(jsonStr).trigger('change');
					}

					function reavantex_rebuildProjectDropdown(repeaterVal) {
						var items = [];
						try {
							items = typeof repeaterVal === 'string' ? JSON.parse(repeaterVal) : repeaterVal;
						} catch(e) {
							items = [];
						}

						var currentSelectedIdx = $select.val();
						$select.empty();

						if (items && items.length) {
							$.each(items, function(idx, item) {
								var itemTitle  = item.subtitle || item.title || ('Project #' + (idx + 1));
								var clientName = item.btntitle || item.button_title || '';
								var labelText  = 'Project #' + (idx + 1) + ': ' + itemTitle + (clientName ? ' (' + clientName + ')' : '');

								$select.append($('<option>', {
									value: idx,
									text: labelText
								}));
							});
						} else {
							$select.append($('<option>', {
								value: 0,
								text: 'Project #1 (Default)'
							}));
						}

						if (currentSelectedIdx !== null && $select.find('option[value="' + currentSelectedIdx + '"]').length) {
							$select.val(currentSelectedIdx);
						} else {
							$select.val(0);
						}

						reavantex_loadSelectedProjectFields();
					}

					$select.on('change', function() {
						reavantex_loadSelectedProjectFields();
					});

					$wrapper.find('.avantex-breakdown-fields-form').on('keyup change', 'input, textarea', function() {
						reavantex_saveSelectedProjectFields();
					});

					// Bind to WordPress Customizer repeater setting & DOM collector events for instant, refreshless updates
					if (typeof wp !== 'undefined' && wp.customize) {
						wp.customize('avantex-portfoliopage-repeater', function(setting) {
							setting.bind(function(newVal) {
								reavantex_rebuildProjectDropdown(newVal);
							});
						});
					}

					$(document).on('change input', '#customize-control-avantex-portfoliopage-repeater-control .customizer-repeater-colector', function() {
						reavantex_rebuildProjectDropdown($(this).val());
					});

					$(document).on('click', '#customize-control-avantex-portfoliopage-repeater-control .social-repeater-add-control-field, #customize-control-avantex-portfoliopage-repeater-control .customizer-repeater-remove-field, #customize-control-avantex-portfoliopage-repeater-control .customizer-repeater-reorder-control', function() {
						setTimeout(function() {
							var val = $('#customize-control-avantex-portfoliopage-repeater-control .customizer-repeater-colector').val();
							reavantex_rebuildProjectDropdown(val);
						}, 250);
					});

					$(document).on('keyup change', '#customize-control-avantex-portfoliopage-repeater-control input, #customize-control-avantex-portfoliopage-repeater-control textarea', function() {
						setTimeout(function() {
							var val = $('#customize-control-avantex-portfoliopage-repeater-control .customizer-repeater-colector').val();
							reavantex_rebuildProjectDropdown(val);
						}, 150);
					});

					reavantex_loadSelectedProjectFields();
				});
			</script>
			<?php
		}
	}
}

// In-Depth Project Breakdown Writeup Settings
$wp_customize->add_setting(
	'avantex-template-portfolio-breakdown-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-portfolio-breakdown-notice-control',
		array(
			'label'           => __( '--- In-Depth Project Breakdown Writeups ---', 'reavantex' ),
			'settings'        => 'avantex-template-portfolio-breakdown-notice',
			'section'         => 'avantex-template-portfolio-section',
			'priority'        => 170,
			'active_callback' => 'reavantex_if_portfoliopage_grid_enabled',
		)
	)
);

// Viewer Section Header Title, Subtitle & Description
$wp_customize->add_setting(
	'avantex-portfolio-viewer-subtitle',
	array(
		'default'           => __( 'Interactive Viewer', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfolio-viewer-subtitle-control',
		array(
			'label'           => __( 'Viewer Section Subtitle', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfolio-viewer-subtitle',
			'priority'        => 171,
			'active_callback' => 'reavantex_if_portfoliopage_grid_enabled',
		)
	)
);

$wp_customize->add_setting(
	'avantex-portfolio-viewer-title',
	array(
		'default'           => __( 'In-Depth Project Breakdown', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfolio-viewer-title-control',
		array(
			'label'           => __( 'Viewer Section Title', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfolio-viewer-title',
			'priority'        => 172,
			'active_callback' => 'reavantex_if_portfoliopage_grid_enabled',
		)
	)
);

$wp_customize->add_setting(
	'avantex-portfolio-viewer-desc',
	array(
		'default'           => __( 'Viewing full details for selected project', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfolio-viewer-desc-control',
		array(
			'label'           => __( 'Viewer Section Description', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfolio-viewer-desc',
			'priority'        => 173,
			'active_callback' => 'reavantex_if_portfoliopage_grid_enabled',
		)
	)
);

$wp_customize->add_setting(
	'avantex-portfolio-project-details',
	array(
		'default'           => defined( 'REAVANTEX_PORTFOLIO_PROJECT_DETAILS_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_PROJECT_DETAILS_DEFAULTS : '[]',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'customizer_repeater_sanitize',
	)
);
$wp_customize->add_control(
	new Skyrocket_Project_Breakdown_Custom_Control(
		$wp_customize,
		'avantex-portfolio-project-details-control',
		array(
			'label'           => __( 'Manage In-Depth Project Writeups', 'reavantex' ),
			'description'     => __( 'Select any project from the dropdown to edit its detailed challenge, solution, deliverables, impact metrics, and client quote in the interactive breakdown viewer.', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfolio-project-details',
			'priority'        => 175,
			'active_callback' => 'reavantex_if_portfoliopage_grid_enabled',
		)
	)
);







// ==========================================
// --- CALL TO ACTION SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-portfolio-cta-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-portfolio-cta-notice-control',
		array(
			'label'    => __( '--- Call to Action Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-portfolio-cta-notice',
			'section'  => 'avantex-template-portfolio-section',
			'priority' => 570,
		)
	)
);

// Toggle CTA Section.
$wp_customize->add_setting(
	'avantex-portfoliopage-show-cta',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-portfoliopage-show-cta-control',
		array(
			'label'    => esc_html__( 'Show Call to Action Section', 'reavantex' ),
			'section'  => 'avantex-template-portfolio-section',
			'settings' => 'avantex-portfoliopage-show-cta',
			'priority' => 580,
		)
	)
);

// Active callback for CTA.
if ( ! function_exists( 'reavantex_if_portfoliopage_cta_enabled' ) ) {
	function reavantex_if_portfoliopage_cta_enabled( $control ) {
		return 1 === (int) $control->manager->get_setting( 'avantex-portfoliopage-show-cta' )->value();
	}
}

// CTA Title.
$wp_customize->add_setting(
	'avantex-portfoliopage-cta-title',
	array(
		'default'           => __( 'Ready to start your project?', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-cta-title-control',
		array(
			'label'           => __( 'CTA Main Title', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-cta-title',
			'type'            => 'text',
			'priority'        => 590,
			'active_callback' => 'reavantex_if_portfoliopage_cta_enabled',
		)
	)
);

// CTA Description.
$wp_customize->add_setting(
	'avantex-portfoliopage-cta-desc',
	array(
		'default'           => __( 'Whether you want to build a web application, design an e-commerce platform, or create a brand identity, we are here to help.', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-cta-desc-control',
		array(
			'label'           => __( 'CTA Description Text', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-cta-desc',
			'type'            => 'textarea',
			'priority'        => 600,
			'active_callback' => 'reavantex_if_portfoliopage_cta_enabled',
		)
	)
);

// CTA Button Text.
$wp_customize->add_setting(
	'avantex-portfoliopage-cta-btn-text',
	array(
		'default'           => __( "Let's Talk", 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-cta-btn-text-control',
		array(
			'label'           => __( 'CTA Button Text', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-cta-btn-text',
			'type'            => 'text',
			'priority'        => 610,
			'active_callback' => 'reavantex_if_portfoliopage_cta_enabled',
		)
	)
);

// CTA Button Link.
$wp_customize->add_setting(
	'avantex-portfoliopage-cta-btn-link',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-cta-btn-link-control',
		array(
			'label'           => __( 'CTA Button Link', 'reavantex' ),
			'description'     => __( 'Leave empty to link automatically to your Contact page.', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-cta-btn-link',
			'type'            => 'text',
			'priority'        => 620,
			'active_callback' => 'reavantex_if_portfoliopage_cta_enabled',
		)
	)
);





// ==========================================
// --- STATS SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-portfolio-stats-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-portfolio-stats-notice-control',
		array(
			'label'    => __( '--- Portfolio Statistics Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-portfolio-stats-notice',
			'section'  => 'avantex-template-portfolio-section',
			'priority' => 400,
		)
	)
);

// Toggle Stats.
$wp_customize->add_setting(
	'avantex-portfoliopage-show-stats',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-portfoliopage-show-stats-control',
		array(
			'label'    => esc_html__( 'Show Statistics Section', 'reavantex' ),
			'section'  => 'avantex-template-portfolio-section',
			'settings' => 'avantex-portfoliopage-show-stats',
			'priority' => 410,
		)
	)
);

// Active callback helper.
if ( ! function_exists( 'reavantex_if_portfoliopage_stats_enabled' ) ) {
	function reavantex_if_portfoliopage_stats_enabled( $control ) {
		return 1 === (int) $control->manager->get_setting( 'avantex-portfoliopage-show-stats' )->value();
	}
}

// Stats Subtitle.
$wp_customize->add_setting(
	'avantex-portfoliopage-stats-subtitle',
	array(
		'default'           => __( 'Our Metrics', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-stats-subtitle-control',
		array(
			'label'           => __( 'Section Subtitle', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-stats-subtitle',
			'type'            => 'text',
			'priority'        => 420,
			'active_callback' => 'reavantex_if_portfoliopage_stats_enabled',
		)
	)
);

// Stats Title.
$wp_customize->add_setting(
	'avantex-portfoliopage-stats-title',
	array(
		'default'           => __( 'Numbers That Represent Our Success', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-portfoliopage-stats-title-control',
		array(
			'label'           => __( 'Section Title', 'reavantex' ),
			'section'         => 'avantex-template-portfolio-section',
			'settings'        => 'avantex-portfoliopage-stats-title',
			'type'            => 'text',
			'priority'        => 430,
			'active_callback' => 'reavantex_if_portfoliopage_stats_enabled',
		)
	)
);

// Stats Repeater.
$wp_customize->add_setting(
	'avantex-portfoliopage-stats-repeater',
	array(
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_PORTFOLIO_STATS_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_STATS_DEFAULTS : '[]',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-portfoliopage-stats-repeater-control',
		array(
			'label'                                 => esc_html__( 'Manage Counters', 'reavantex' ),
			'settings'                              => 'avantex-portfoliopage-stats-repeater',
			'section'                               => 'avantex-template-portfolio-section',
			'add_field_label'                       => esc_html__( 'Add Counter', 'reavantex' ),
			'item_name'                             => esc_html__( 'Counter Card', 'reavantex' ),
			'priority'                              => 440,
			'item_limit'                             => 16,
			'customizer_repeater_image_control'     => false,
			'customizer_repeater_icon_control'      => true,
			'customizer_repeater_title_control'     => true, // Holds count number, e.g. "150"
			'customizer_repeater_btntitle_control'  => false,
			'customizer_repeater_subtitle_control'  => true, // Holds description, e.g. "Projects Completed"
			'customizer_repeater_text_control'      => true, // Holds suffix, e.g. "+"
			'customizer_repeater_text2_control'     => false,
			'customizer_repeater_link_control'      => false,
			'customizer_repeater_link2_control'     => false,
			'customizer_repeater_shortcode_control' => false,
			'customizer_repeater_repeater_control'  => false,
			'customizer_repeater_color_control'     => false,
			'customizer_repeater_color2_control'    => false,
			'active_callback'                       => 'reavantex_if_portfoliopage_stats_enabled',
		)
	)
);


// ==========================================
// --- EMBEDS SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-portfolio-embeds-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-portfolio-embeds-notice-control',
		array(
			'label'       => __( '--- Testimonial & Sponsor Embeds ---', 'reavantex' ),
			'description' => __( 'Testimonial reviews and Sponsor logos embedded here are shared with their respective Homepage sections. You can customize them in <strong>Homepage Section Settings &gt; Testimonials Section</strong> and <strong>Sponsors Section</strong>, or click the blue pencil shortcut icons directly on the live preview.', 'reavantex' ),
			'settings'    => 'avantex-template-portfolio-embeds-notice',
			'section'     => 'avantex-template-portfolio-section',
			'priority'    => 470,
		)
	)
);

// Toggle Testimonials.
$wp_customize->add_setting(
	'avantex-portfoliopage-show-testimonials',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-portfoliopage-show-testimonials-control',
		array(
			'label'    => esc_html__( 'Embed Testimonials Carousel', 'reavantex' ),
			'section'  => 'avantex-template-portfolio-section',
			'settings' => 'avantex-portfoliopage-show-testimonials',
			'priority' => 480,
		)
	)
);

// Toggle Sponsors.
$wp_customize->add_setting(
	'avantex-portfoliopage-show-sponsors',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-portfoliopage-show-sponsors-control',
		array(
			'label'    => esc_html__( 'Embed Clients/Sponsors Logo Strip', 'reavantex' ),
			'section'  => 'avantex-template-portfolio-section',
			'settings' => 'avantex-portfoliopage-show-sponsors',
			'priority' => 490,
		)
	)
);


// Selective Refresh Partials
if ( isset( $wp_customize->selective_refresh ) ) {
	// Granular selective refresh for Hero Section
	$wp_customize->selective_refresh->add_partial(
		'avantex-portfolio-hero-partial',
		array(
			'selector'            => '.portfolio-hero-embed-wrapper',
			'container_inclusive' => true,
			'settings'            => array(
				'avantex-template-portfolio-container',
				'avantex-portfoliopage-show-hero',
				'avantex-portfoliopage-hero-layout',
				'avantex-portfoliopage-hero-image',
				'avantex-portfoliopage-hero-image-2',
				'avantex-portfoliopage-hero-image-3',
				'avantex-portfoliopage-dark-hero-show-stats',
				'avantex-portfoliopage-dark-hero-stats-repeater',
			),
			'render_callback'     => function () {
				get_template_part( 'template-parts/portfolio', 'hero' );
			},
		)
	);

	// Granular selective refresh for Portfolio Grid Section
	$wp_customize->selective_refresh->add_partial(
		'avantex-portfolio-grid-partial',
		array(
			'selector'            => '.portfolio-gallery-section',
			'container_inclusive' => true,
			'settings'            => array(
				'avantex-portfoliopage-show-grid',
				'avantex-portfoliopage-grid',
				'avantex-portfoliopage-subtitle',
				'avantex-portfoliopage-title',
			),
			'render_callback'     => function () {
				$show_grid = get_theme_mod( 'avantex-portfoliopage-show-grid', 1 );
				if ( 1 !== intval( $show_grid ) ) {
					return;
				}
				$portfolio_container_class = get_theme_mod( 'avantex-template-portfolio-container', 'container' );
				$portfolio_grid_class      = get_theme_mod( 'avantex-portfoliopage-grid', 'col-lg-6' );
				$grid_subtitle             = get_theme_mod( 'avantex-portfoliopage-subtitle', __( 'Featured Works', 'reavantex' ) );
				$grid_title                = get_theme_mod( 'avantex-portfoliopage-title', __( 'Our Featured Projects', 'reavantex' ) );
				$cards_data                = get_theme_mod( 'avantex-portfoliopage-repeater', ( defined( 'REAVANTEX_PORTFOLIO_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_DEFAULTS : '[]' ) );
				$decoded_cards         = ! empty( $cards_data ) ? json_decode( $cards_data ) : array();
				$breakdown_details_raw = get_theme_mod( 'avantex-portfolio-project-details', ( defined( 'REAVANTEX_PORTFOLIO_PROJECT_DETAILS_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_PROJECT_DETAILS_DEFAULTS : '[]' ) );
				$breakdown_details     = ! empty( $breakdown_details_raw ) ? json_decode( $breakdown_details_raw, true ) : array();
				if ( empty( $breakdown_details ) || ! is_array( $breakdown_details ) ) {
					$breakdown_details = json_decode( ( defined( 'REAVANTEX_PORTFOLIO_PROJECT_DETAILS_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_PROJECT_DETAILS_DEFAULTS : '[]' ), true );
				}
				$projects_dataset = array();
				if ( is_array( $decoded_cards ) && count( $decoded_cards ) > 0 ) {
					foreach ( $decoded_cards as $idx => $card ) {
						$title         = ! empty( $card->subtitle ) ? $card->subtitle : ( ! empty( $card->title ) ? $card->title : ( 'Project #' . ( $idx + 1 ) ) );
						$tag           = ! empty( $card->title ) ? $card->title : __( 'Portfolio', 'reavantex' );
						$client        = ! empty( $card->btntitle ) ? $card->btntitle : ( ! empty( $card->button_title ) ? $card->button_title : ( 'Client for ' . $title ) );
						$img           = ! empty( $card->image_url ) ? $card->image_url : ( function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'portfolio/project-1.webp' ) : get_stylesheet_directory_uri() . '/assets/images/portfolio/project-1.webp' );
						$excerpt       = ! empty( $card->text ) ? wp_trim_words( $card->text, 22, '...' ) : ( 'Streamlined user workflows for ' . $title . '.' );
						$link          = ! empty( $card->link ) && $card->link !== '#' ? $card->link : home_url();
						$read_btn_text = ! empty( $card->link2 ) && $card->link2 !== '#' ? $card->link2 : __( 'Read Project', 'reavantex' );
						$bd            = isset( $breakdown_details[ $idx ] ) ? $breakdown_details[ $idx ] : ( isset( $breakdown_details[ (string) $idx ] ) ? $breakdown_details[ (string) $idx ] : array() );
						$metric_1      = ! empty( $bd['metric_1'] ) ? $bd['metric_1'] : ( ! empty( $card->shortcode ) ? $card->shortcode : '+40% Efficiency Boost' );
						$projects_dataset[] = array(
							'index'         => $idx,
							'title'         => $title,
							'tag'           => $tag,
							'client'        => $client,
							'img'           => $img,
							'excerpt'       => $excerpt,
							'metric_1'      => $metric_1,
							'read_btn_text' => $read_btn_text,
							'link'          => $link,
						);
					}
				}
				$categories = array();
				foreach ( $projects_dataset as $p_item ) {
					if ( ! empty( $p_item['tag'] ) ) {
						$categories[] = trim( $p_item['tag'] );
					}
				}
				$categories = array_unique( $categories );
				?>
				<section class="portfolio-gallery-section py-5 my-4 wow fadeInUp animated" data-wow-delay="100ms">
					<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
						<div class="section-header text-center mb-5">
							<p class="section-subtitle small d-block mb-1"><?php echo esc_html( $grid_subtitle ); ?></p>
							<h2 class="section-title"><b><?php echo esc_html( $grid_title ); ?></b></h2>
							<div class="divider-line mx-auto my-3"></div>
						</div>
						<?php if ( count( $categories ) > 0 ) : ?>
							<div class="portfolio-filter-wrapper text-center mb-5">
								<div class="portfolio-filter-buttons" role="group">
									<button type="button" class="portfolio-filter-btn active" data-filter="all">All Projects</button>
									<?php foreach ( $categories as $cat ) : ?>
										<button type="button" class="portfolio-filter-btn" data-filter="<?php echo esc_attr( sanitize_title( $cat ) ); ?>"><?php echo esc_html( $cat ); ?></button>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						<div class="row portfolio-grid-wrapper">
							<?php
							foreach ( $projects_dataset as $p_item ) :
								$cat_slug = sanitize_title( $p_item['tag'] );
								?>
								<div class="<?php echo esc_attr( $portfolio_grid_class ); ?> col-md-6 col-sm-12 mb-4 portfolio-filter-item cat-<?php echo esc_attr( $cat_slug ); ?>">
									<div class="project-card-item h-100 border overflow-hidden shadow-sm transition-all d-flex flex-column" data-project-index="<?php echo esc_attr( $p_item['index'] ); ?>">
										<div class="project-card-img-wrapper position-relative overflow-hidden">
											<img src="<?php echo esc_url( $p_item['img'] ); ?>" alt="<?php echo esc_attr( $p_item['title'] ); ?>" class="project-card-img w-100 transition-scale">
											<div class="project-card-tag-overlay position-absolute top-0 left-0 m-3">
												<span class="badge badge-portfolio-tag px-3 py-2 text-uppercase font-weight-bold shadow-sm"><?php echo esc_html( $p_item['tag'] ); ?></span>
											</div>
										</div>
										<div class="project-card-content p-4 d-flex flex-column flex-grow-1 justify-content-between">
											<div>
												<span class="text-uppercase font-weight-bold small d-block mb-1 tracking-wider project-card-client"><?php echo esc_html( $p_item['client'] ); ?></span>
												<h4 class="project-card-title font-weight-bold mb-2"><b><?php echo esc_html( $p_item['title'] ); ?></b></h4>
												<p class="project-card-desc small mb-3 text-clamp-2"><?php echo esc_html( $p_item['excerpt'] ); ?></p>
											</div>
											<div class="project-card-footer pt-3 border-top d-flex justify-content-between align-items-center mt-auto">
												<button type="button" class="px-3 read-project-trigger">
													<?php echo esc_html( $p_item['read_btn_text'] ); ?>
												</button>
												<?php if ( ! empty( $p_item['metric_1'] ) ) : ?>
													<span class="project-card-metric px-2"><i class="fas fa-chart-line mr-1"></i> <?php echo esc_html( $p_item['metric_1'] ); ?></span>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</section>
				<?php
			},
		)
	);

	// Granular selective refresh for Portfolio Stats Section
	$wp_customize->selective_refresh->add_partial(
		'avantex-portfolio-stats-partial',
		array(
			'selector'            => '.portfolio-stats-section',
			'container_inclusive' => true,
			'settings'            => array(
				'avantex-portfoliopage-show-stats',
				'avantex-portfoliopage-stats-repeater',
			),
			'render_callback'     => function () {
				$show_stats = get_theme_mod( 'avantex-portfoliopage-show-stats', 1 );
				if ( 1 !== intval( $show_stats ) ) {
					return;
				}
				$portfolio_container_class = get_theme_mod( 'avantex-template-portfolio-container', 'container' );
				$stats_subtitle             = get_theme_mod( 'avantex-portfoliopage-stats-subtitle', __( 'Our Metrics', 'reavantex' ) );
				$stats_title                = get_theme_mod( 'avantex-portfoliopage-stats-title', __( 'Numbers That Represent Our Success', 'reavantex' ) );
				$stats_repeater             = get_theme_mod( 'avantex-portfoliopage-stats-repeater', ( defined( 'REAVANTEX_PORTFOLIO_STATS_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_STATS_DEFAULTS : '[]' ) );
				$decoded_stats              = ! empty( $stats_repeater ) ? json_decode( $stats_repeater ) : array();
				if ( empty( $decoded_stats ) ) {
					return;
				}
				?>
				<section class="portfolio-stats-section py-5 border-top border-bottom">
					<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
						<div class="section-header text-center mb-5">
							<p class="section-subtitle small d-block mb-1"><?php echo esc_html( $stats_subtitle ); ?></p>
							<h2 class="section-title"><b><?php echo esc_html( $stats_title ); ?></b></h2>
							<div class="divider-line mx-auto my-3"></div>
						</div>
						<div class="row text-center">
							<?php
							foreach ( $decoded_stats as $stat ) :
								$icon   = ! empty( $stat->icon_value ) ? $stat->icon_value : 'fas fa-rocket';
								$number = ! empty( $stat->title ) ? $stat->title : '100';
								$label  = ! empty( $stat->subtitle ) ? $stat->subtitle : 'Metric';
								$suffix = ! empty( $stat->text ) ? $stat->text : '+';
								?>
								<div class="col-lg-3 col-md-6 col-sm-6 mb-4 stat-card-item">
									<div class="stat-card p-4 border shadow-sm h-100 transition-all">
										<div class="stat-icon mb-3 display-4 counter-icon">
											<i class="<?php echo esc_attr( $icon ); ?>"></i>
										</div>
										<h2 class="stat-number font-weight-bold mb-1">
											<span class="counter-number"><?php echo esc_html( $number ); ?></span><span class="counter-suffix"><?php echo esc_html( $suffix ); ?></span>
										</h2>
										<p class="stat-label small mb-0 counter-label"><?php echo esc_html( $label ); ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</section>
				<?php
			},
		)
	);

	// Granular selective refresh for Testimonials & Sponsors Embeds
	$wp_customize->selective_refresh->add_partial(
		'avantex-portfolio-embeds-partial',
		array(
			'selector'            => '.portfolio-embeds-wrapper',
			'container_inclusive' => true,
			'settings'            => array(
				'avantex-portfoliopage-show-testimonials',
				'avantex-portfoliopage-show-sponsors',
			),
			'render_callback'     => function () {
				$show_testimonials = get_theme_mod( 'avantex-portfoliopage-show-testimonials', 1 );
				$show_sponsors     = get_theme_mod( 'avantex-portfoliopage-show-sponsors', 1 );
				echo '<div class="portfolio-embeds-wrapper">';
				if ( 1 === intval( $show_testimonials ) && file_exists( get_stylesheet_directory() . '/templates/avantex-testimonial.php' ) ) {
					echo '<div class="portfolio-testimonials-embed py-4">';
					include get_stylesheet_directory() . '/templates/avantex-testimonial.php';
					echo '</div>';
				}
				if ( 1 === intval( $show_sponsors ) && file_exists( get_stylesheet_directory() . '/templates/avantex-sponsors.php' ) ) {
					echo '<div class="portfolio-sponsors-embed py-4">';
					include get_stylesheet_directory() . '/templates/avantex-sponsors.php';
					echo '</div>';
				}
				echo '</div>';
			},
		)
	);

	// Granular selective refresh for Call to Action Section
	$wp_customize->selective_refresh->add_partial(
		'avantex-portfolio-cta-partial',
		array(
			'selector'            => '.portfolio-cta-section',
			'container_inclusive' => true,
			'settings'            => array(
				'avantex-portfoliopage-show-cta',
			),
			'render_callback'     => function () {
				$show_cta = get_theme_mod( 'avantex-portfoliopage-show-cta', 1 );
				if ( 1 !== intval( $show_cta ) ) {
					return;
				}
				$portfolio_container_class = get_theme_mod( 'avantex-template-portfolio-container', 'container' );
				$cta_title                 = get_theme_mod( 'avantex-portfoliopage-cta-title', __( 'Have a Project in Mind? Let’s Build Something Amazing Together', 'reavantex' ) );
				$cta_desc                  = get_theme_mod( 'avantex-portfoliopage-cta-desc', __( 'Partner with our expert design and engineering team to bring your digital vision to life.', 'reavantex' ) );
				$cta_btn_text              = get_theme_mod( 'avantex-portfoliopage-cta-btn-text', __( 'Start a Project Inquiry', 'reavantex' ) );
				$cta_btn_link              = get_theme_mod( 'avantex-portfoliopage-cta-btn-link', '#' );
				?>
				<section class="portfolio-cta-section py-5 my-4">
					<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
						<div class="cta-inner-card p-5 border shadow-lg text-center position-relative overflow-hidden">
							<h2 class="cta-title font-weight-bold mb-3"><b><?php echo esc_html( $cta_title ); ?></b></h2>
							<p class="cta-desc max-w-700 mx-auto mb-4 lead-text"><?php echo esc_html( $cta_desc ); ?></p>
							<div class="cta-btn-wrapper">
								<a href="<?php echo esc_url( $cta_btn_link ); ?>" class="thm-btn portfolio-cta-btn">
									<?php echo esc_html( $cta_btn_text ); ?> <i class="fas fa-arrow-right ml-2 small"></i>
								</a>
							</div>
						</div>
					</div>
				</section>
				<?php
			},
		)
	);
}
