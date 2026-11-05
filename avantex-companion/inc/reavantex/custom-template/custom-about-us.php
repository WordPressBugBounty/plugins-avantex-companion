<?php
/**
 * Section for About Us Template settings.
 *
 * @package avantex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'avantex-template-aboutus-section',
	array(
		'title'       => __( 'About-Us template settings', 'reavantex' ),
		'panel'       => 'avantex-templates-panel',
		'description' => __( 'Settings for Avantex About Us page template.', 'reavantex' ),
	)
);

// ==========================================
// --- GENERAL SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-aboutus-general-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-aboutus-general-notice-control',
		array(
			'label'    => __( '--- General Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-aboutus-general-notice',
			'section'  => 'avantex-template-aboutus-section',
			'priority' => 10,
		)
	)
);

// Container size.
$wp_customize->add_setting(
	'avantex-template-aboutus-container',
	array(
		'default'           => 'container',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Text_Radio_Button_Custom_Control(
		$wp_customize,
		'avantex-template-aboutus-container-control',
		array(
			'label'       => __( 'About US Container size', 'reavantex' ),
			'description' => esc_html__( 'Choose size of Container.', 'reavantex' ),
			'section'     => 'avantex-template-aboutus-section',
			'settings'    => 'avantex-template-aboutus-container',
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
	'avantex-aboutpage-show-content',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-aboutpage-show-content-control',
		array(
			'label'    => esc_html__( 'Show Page Content Area', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-show-content',
			'priority' => 30,
		)
	)
);


// ==========================================
// --- MAIN INTRO SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-aboutus-main-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-aboutus-main-notice-control',
		array(
			'label'    => __( '--- Main Intro Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-aboutus-main-notice',
			'section'  => 'avantex-template-aboutus-section',
			'priority' => 40,
		)
	)
);

// Toggle Main Section.
$wp_customize->add_setting(
	'avantex-aboutpage-show-main',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-aboutpage-show-main-control',
		array(
			'label'    => esc_html__( 'Show Main Intro Section', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-show-main',
			'priority' => 50,
		)
	)
);

// About Page Image.
$wp_customize->add_setting(
	'avantex-aboutpage-image',
	array(
		'default'           => ( function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'about.webp' ) : get_stylesheet_directory_uri() . '/assets/images/about.webp' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'avantex-aboutpage-image-control',
		array(
			'label'    => __( 'About Image', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-image',
			'priority' => 60,
		)
	)
);

// About Page Subtitle.
$wp_customize->add_setting(
	'avantex-aboutpage-subtitle',
	array(
		'default'           => __( 'About Our Agency', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-subtitle-control',
		array(
			'label'    => __( 'Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-subtitle',
			'type'     => 'text',
			'priority' => 70,
		)
	)
);

// About Page Title.
$wp_customize->add_setting(
	'avantex-aboutpage-title',
	array(
		'default'           => __( 'We are passionate developers creating outstanding digital experiences', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-title-control',
		array(
			'label'    => __( 'Title', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-title',
			'type'     => 'text',
			'priority' => 80,
		)
	)
);

// About Page Info text.
$wp_customize->add_setting(
	'avantex-aboutpage-info',
	array(
		'default'           => __( '<p>We specialize in crafting professional, speed-optimized, and beautiful themes and plugins. Our dedication is to provide top-tier web design solutions that help enterprises grow, scaling your brand and expanding your global footprint. We write clean code, adhere to standard web architectures, and design cohesive digital systems.</p>', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-info-control',
		array(
			'label'    => __( 'Intro Info Text', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-info',
			'type'     => 'textarea',
			'priority' => 90,
		)
	)
);

// Toggle Social Icons.
$wp_customize->add_setting(
	'avantex-aboutpage-show-social',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-aboutpage-show-social-control',
		array(
			'label'       => esc_html__( 'Enable Social Icons in Intro', 'reavantex' ),
			'description' => esc_html__( 'Icons and links are shared from Topbar Social Links (Header Settings > Topbar Section > Social Links).', 'reavantex' ),
			'section'     => 'avantex-template-aboutus-section',
			'settings'    => 'avantex-aboutpage-show-social',
			'priority'    => 100,
		)
	)
);
// Features List Notice Control.
$wp_customize->add_setting(
	'avantex-template-aboutus-features-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-aboutus-features-notice-control',
		array(
			'label'    => __( '--- Features List Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-aboutus-features-notice',
			'section'  => 'avantex-template-aboutus-section',
			'priority' => 105,
		)
	)
);

// Features Repeater
$wp_customize->add_setting(
	'avantex-aboutpage-features-repeater',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_TEMPLATE_ABOUTUS_FEATURES_DEFAULTS' ) ? REAVANTEX_TEMPLATE_ABOUTUS_FEATURES_DEFAULTS : '[]',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-aboutpage-features-repeater-control',
		array(
			'label'                                 => esc_html__( 'Manage Features list', 'reavantex' ),
			'settings'                              => 'avantex-aboutpage-features-repeater',
			'section'                               => 'avantex-template-aboutus-section',
			'add_field_label'                       => esc_html__( 'Add Feature Card', 'reavantex' ),
			'item_name'                             => esc_html__( 'Feature Card', 'reavantex' ),
			'priority'                              => 110,
			'item_limit'                             => 16,
			'customizer_repeater_image_control'     => false,
			'customizer_repeater_icon_control'      => true,
			'customizer_repeater_title_control'     => true,
			'customizer_repeater_btntitle_control'  => false,
			'customizer_repeater_subtitle_control'  => false,
			'customizer_repeater_text_control'      => true,
			'customizer_repeater_text2_control'     => false,
			'customizer_repeater_link_control'      => false,
			'customizer_repeater_link2_control'     => false,
			'customizer_repeater_shortcode_control' => false,
			'customizer_repeater_repeater_control'  => false,
			'customizer_repeater_color_control'     => false,
			'customizer_repeater_color2_control'    => false,
		)
	)
);


// ==========================================
// --- INTERACTIVE TABS SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-aboutus-tabs-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-aboutus-tabs-notice-control',
		array(
			'label'    => __( '--- Interactive Tabs Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-aboutus-tabs-notice',
			'section'  => 'avantex-template-aboutus-section',
			'priority' => 120,
		)
	)
);

// Toggle Tabs Section.
$wp_customize->add_setting(
	'avantex-aboutpage-show-tabs',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-aboutpage-show-tabs-control',
		array(
			'label'    => esc_html__( 'Show Interactive Tabs Section', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-show-tabs',
			'priority' => 130,
		)
	)
);

// Tabs Container size.
$wp_customize->add_setting(
	'avantex-aboutpage-tabs-container',
	array(
		'default'           => 'container',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Text_Radio_Button_Custom_Control(
		$wp_customize,
		'avantex-aboutpage-tabs-container-control',
		array(
			'label'       => __( 'Tabs Container size', 'reavantex' ),
			'description' => esc_html__( 'Choose size of Container for Tabs section.', 'reavantex' ),
			'section'     => 'avantex-template-aboutus-section',
			'settings'    => 'avantex-aboutpage-tabs-container',
			'choices'     => array(
				'container'           => __( 'Container', 'reavantex' ),
				'container-full'      => __( 'Full Container', 'reavantex' ),
				'container-fluid p-0' => __( 'fluid', 'reavantex' ),
			),
			'priority'    => 135,
		)
	)
);

// Tabs Repeater
$wp_customize->add_setting(
	'avantex-aboutpage-tabs-repeater',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_TEMPLATE_ABOUTUS_TABS_DEFAULTS' ) ? REAVANTEX_TEMPLATE_ABOUTUS_TABS_DEFAULTS : '[]',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-aboutpage-tabs-repeater-control',
		array(
			'label'                                 => esc_html__( 'Manage Interactive Tabs', 'reavantex' ),
			'settings'                              => 'avantex-aboutpage-tabs-repeater',
			'section'                               => 'avantex-template-aboutus-section',
			'add_field_label'                       => esc_html__( 'Add Tab Item', 'reavantex' ),
			'item_name'                             => esc_html__( 'Tab Item', 'reavantex' ),
			'priority'                              => 140,
			'item_limit'                             => 16,
			'customizer_repeater_image_control'     => false,
			'customizer_repeater_icon_control'      => true,
			'customizer_repeater_title_control'     => true, // used for Tab Title (e.g. Our Mission)
			'customizer_repeater_btntitle_control'  => false,
			'customizer_repeater_subtitle_control'  => true, // used for Tab Heading/Subtitle (e.g. Empowering Growth)
			'customizer_repeater_text_control'      => true, // used for Tab Description Text
			'customizer_repeater_text2_control'     => false,
			'customizer_repeater_link_control'      => false,
			'customizer_repeater_link2_control'     => false,
			'customizer_repeater_shortcode_control' => false,
			'customizer_repeater_repeater_control'  => false,
			'customizer_repeater_color_control'     => false,
			'customizer_repeater_color2_control'    => false,
		)
	)
);


// ==========================================
// --- CORE VALUES SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-aboutus-values-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-aboutus-values-notice-control',
		array(
			'label'    => __( '--- Core Values Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-aboutus-values-notice',
			'section'  => 'avantex-template-aboutus-section',
			'priority' => 150,
		)
	)
);

// Toggle Values Section.
$wp_customize->add_setting(
	'avantex-aboutpage-show-values',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-aboutpage-show-values-control',
		array(
			'label'    => esc_html__( 'Show Core Values Section', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-show-values',
			'priority' => 160,
		)
	)
);

// Values Section Subtitle
$wp_customize->add_setting(
	'avantex-aboutpage-values-subtitle',
	array(
		'default'           => __( 'Why Choose Us', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-values-subtitle-control',
		array(
			'label'    => __( 'Values Section Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-values-subtitle',
			'type'     => 'text',
			'priority' => 170,
		)
	)
);

// Values Section Title
$wp_customize->add_setting(
	'avantex-aboutpage-values-title',
	array(
		'default'           => __( 'Values That Define Our Journey', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-values-title-control',
		array(
			'label'    => __( 'Values Section Title', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-values-title',
			'type'     => 'text',
			'priority' => 180,
		)
	)
);

// Core Values Repeater
$wp_customize->add_setting(
	'avantex-aboutpage-values-repeater',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_TEMPLATE_ABOUTUS_VALUES_DEFAULTS' ) ? REAVANTEX_TEMPLATE_ABOUTUS_VALUES_DEFAULTS : '[]',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-aboutpage-values-repeater-control',
		array(
			'label'                                 => esc_html__( 'Manage Core Values Cards', 'reavantex' ),
			'settings'                              => 'avantex-aboutpage-values-repeater',
			'section'                               => 'avantex-template-aboutus-section',
			'add_field_label'                       => esc_html__( 'Add Value Card', 'reavantex' ),
			'item_name'                             => esc_html__( 'Value Card', 'reavantex' ),
			'priority'                              => 190,
			'item_limit'                             => 16,
			'customizer_repeater_image_control'     => false,
			'customizer_repeater_icon_control'      => true,
			'customizer_repeater_title_control'     => true,
			'customizer_repeater_btntitle_control'  => false,
			'customizer_repeater_subtitle_control'  => false,
			'customizer_repeater_text_control'      => true,
			'customizer_repeater_text2_control'     => false,
			'customizer_repeater_link_control'      => false,
			'customizer_repeater_link2_control'     => false,
			'customizer_repeater_shortcode_control' => false,
			'customizer_repeater_repeater_control'  => false,
			'customizer_repeater_color_control'     => false,
			'customizer_repeater_color2_control'    => false,
		)
	)
);


// ==========================================
// --- JOURNEY TIMELINE SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-aboutus-timeline-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-aboutus-timeline-notice-control',
		array(
			'label'    => __( '--- Timeline Journey Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-aboutus-timeline-notice',
			'section'  => 'avantex-template-aboutus-section',
			'priority' => 200,
		)
	)
);

// Toggle Timeline Section.
$wp_customize->add_setting(
	'avantex-aboutpage-show-timeline',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-aboutpage-show-timeline-control',
		array(
			'label'    => esc_html__( 'Show Journey Timeline Section', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-show-timeline',
			'priority' => 210,
		)
	)
);

// Timeline Section Subtitle
$wp_customize->add_setting(
	'avantex-aboutpage-timeline-subtitle',
	array(
		'default'           => __( 'Our Journey', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-timeline-subtitle-control',
		array(
			'label'    => __( 'Timeline Section Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-timeline-subtitle',
			'type'     => 'text',
			'priority' => 220,
		)
	)
);

// Timeline Section Title
$wp_customize->add_setting(
	'avantex-aboutpage-timeline-title',
	array(
		'default'           => __( 'Our Growth Timeline', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-timeline-title-control',
		array(
			'label'    => __( 'Timeline Section Title', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-timeline-title',
			'type'     => 'text',
			'priority' => 230,
		)
	)
);

// Timeline Repeater
$wp_customize->add_setting(
	'avantex-aboutpage-timeline-repeater',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_TEMPLATE_ABOUTUS_TIMELINE_DEFAULTS' ) ? REAVANTEX_TEMPLATE_ABOUTUS_TIMELINE_DEFAULTS : '[]',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-aboutpage-timeline-repeater-control',
		array(
			'label'                                 => esc_html__( 'Manage Timeline Milestones', 'reavantex' ),
			'settings'                              => 'avantex-aboutpage-timeline-repeater',
			'section'                               => 'avantex-template-aboutus-section',
			'add_field_label'                       => esc_html__( 'Add Milestone', 'reavantex' ),
			'item_name'                             => esc_html__( 'Milestone', 'reavantex' ),
			'priority'                              => 240,
			'item_limit'                             => 16,
			'customizer_repeater_image_control'     => false,
			'customizer_repeater_icon_control'      => false,
			'customizer_repeater_title_control'     => true,
			'customizer_repeater_btntitle_control'  => false,
			'customizer_repeater_subtitle_control'  => true, // Subtitle is used for Year/Date
			'customizer_repeater_text_control'      => true,
			'customizer_repeater_text2_control'     => false,
			'customizer_repeater_link_control'      => false,
			'customizer_repeater_link2_control'     => false,
			'customizer_repeater_shortcode_control' => false,
			'customizer_repeater_repeater_control'  => false,
			'customizer_repeater_color_control'     => false,
			'customizer_repeater_color2_control'    => false,
		)
	)
);


// ==========================================
// --- MEET OUR TEAM SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-aboutus-team-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-aboutus-team-notice-control',
		array(
			'label'       => __( '--- Meet Our Team ---', 'reavantex' ),
			'description' => __( 'Team members, layouts, and styling are shared with the Homepage Team Section. You can customize them in <strong>Homepage Section Settings &gt; Team Section</strong>, or click the blue pencil shortcut icon directly on the live preview.', 'reavantex' ),
			'settings'    => 'avantex-template-aboutus-team-notice',
			'section'  => 'avantex-template-aboutus-section',
			'priority' => 241,
		)
	)
);

// Toggle Team Section.
$wp_customize->add_setting(
	'avantex-aboutpage-show-team',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-aboutpage-show-team-control',
		array(
			'label'    => esc_html__( 'Show Team Section', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-show-team',
			'priority' => 242,
		)
	)
);

// Team Section Subtitle.
$wp_customize->add_setting(
	'avantex-aboutpage-team-subtitle',
	array(
		'default'           => __( 'Our Team', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-team-subtitle-control',
		array(
			'label'    => __( 'Team Section Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-team-subtitle',
			'type'     => 'text',
			'priority' => 243,
		)
	)
);

// Team Section Title.
$wp_customize->add_setting(
	'avantex-aboutpage-team-title',
	array(
		'default'           => __( 'Meet The People Behind The Brand', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-team-title-control',
		array(
			'label'    => __( 'Team Section Title', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-team-title',
			'type'     => 'text',
			'priority' => 244,
		)
	)
);


// ==========================================
// --- CLIENT TESTIMONIALS SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-aboutus-testimonials-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-aboutus-testimonials-notice-control',
		array(
			'label'       => __( '--- Client Testimonials ---', 'reavantex' ),
			'description' => __( 'Testimonial cards, layouts, and reviews are shared with the Homepage Testimonials Section. You can customize them in <strong>Homepage Section Settings &gt; Testimonials Section</strong>, or click the blue pencil shortcut icon directly on the live preview.', 'reavantex' ),
			'settings'    => 'avantex-template-aboutus-testimonials-notice',
			'section'  => 'avantex-template-aboutus-section',
			'priority' => 245,
		)
	)
);

// Toggle Testimonials Section.
$wp_customize->add_setting(
	'avantex-aboutpage-show-testimonials',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-aboutpage-show-testimonials-control',
		array(
			'label'    => esc_html__( 'Show Testimonials Section', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-show-testimonials',
			'priority' => 246,
		)
	)
);

// Testimonials Section Subtitle.
$wp_customize->add_setting(
	'avantex-aboutpage-testimonials-subtitle',
	array(
		'default'           => __( 'What Clients Say', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-testimonials-subtitle-control',
		array(
			'label'    => __( 'Testimonials Section Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-testimonials-subtitle',
			'type'     => 'text',
			'priority' => 247,
		)
	)
);

// Testimonials Section Title.
$wp_customize->add_setting(
	'avantex-aboutpage-testimonials-title',
	array(
		'default'           => __( 'Trusted By Businesses Worldwide', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-testimonials-title-control',
		array(
			'label'    => __( 'Testimonials Section Title', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-testimonials-title',
			'type'     => 'text',
			'priority' => 248,
		)
	)
);


// ==========================================
// --- CALL TO ACTION SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-aboutus-cta-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-aboutus-cta-notice-control',
		array(
			'label'    => __( '--- Call to Action Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-aboutus-cta-notice',
			'section'  => 'avantex-template-aboutus-section',
			'priority' => 250,
		)
	)
);

// Toggle CTA Section.
$wp_customize->add_setting(
	'avantex-aboutpage-show-cta',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-aboutpage-show-cta-control',
		array(
			'label'    => esc_html__( 'Show Call to Action Section', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-show-cta',
			'priority' => 260,
		)
	)
);

// CTA Tagline
$wp_customize->add_setting(
	'avantex-aboutpage-cta-tagline',
	array(
		'default'           => __( 'Start Your Project', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-cta-tagline-control',
		array(
			'label'    => __( 'CTA Tagline', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-cta-tagline',
			'type'     => 'text',
			'priority' => 270,
		)
	)
);

// CTA Title
$wp_customize->add_setting(
	'avantex-aboutpage-cta-title',
	array(
		'default'           => __( 'Ready to collaborate on something magical?', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-cta-title-control',
		array(
			'label'    => __( 'CTA Main Title', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-cta-title',
			'type'     => 'text',
			'priority' => 280,
		)
	)
);

// CTA Description
$wp_customize->add_setting(
	'avantex-aboutpage-cta-desc',
	array(
		'default'           => __( 'Whether you are launching a new startup, rebuilding an online shopping store, or upgrading your corporate presence, we have the expertise to make your digital presence thrive.', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-cta-desc-control',
		array(
			'label'    => __( 'CTA Description Text', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-cta-desc',
			'type'     => 'textarea',
			'priority' => 290,
		)
	)
);

// CTA Button Text
$wp_customize->add_setting(
	'avantex-aboutpage-cta-btn-text',
	array(
		'default'           => __( 'Get In Touch', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-cta-btn-text-control',
		array(
			'label'    => __( 'CTA Button Text', 'reavantex' ),
			'section'  => 'avantex-template-aboutus-section',
			'settings' => 'avantex-aboutpage-cta-btn-text',
			'type'     => 'text',
			'priority' => 300,
		)
	)
);

// CTA Button Link
$wp_customize->add_setting(
	'avantex-aboutpage-cta-btn-link',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-aboutpage-cta-btn-link-control',
		array(
			'label'       => __( 'CTA Button Link', 'reavantex' ),
			'description' => __( 'Leave empty to link automatically to your Contact page.', 'reavantex' ),
			'section'     => 'avantex-template-aboutus-section',
			'settings'    => 'avantex-aboutpage-cta-btn-link',
			'type'        => 'text',
			'priority'    => 310,
		)
	)
);

// Register Selective Refresh Partials for About Us to provide pencil icons.
// We register exactly one partial per notice control (sub-section header) and map it
// to the section's HTML container. This provides a single pencil icon per section in the
// preview that opens the section's sidebar controls without triggering selective refreshes.
if ( isset( $wp_customize->selective_refresh ) ) {
	$partials_config = array(
		'avantex-template-aboutus-general-notice'      => '.about-template-wrapper',
		'avantex-template-aboutus-main-notice'         => '.tmpl-about-module',
		'avantex-template-aboutus-features-notice'     => '.about-modern-features',
		'avantex-template-aboutus-tabs-notice'         => '.about-tabs-section',
		'avantex-template-aboutus-values-notice'       => '.about-values-section',
		'avantex-template-aboutus-timeline-notice'     => '.about-timeline-section',
		'avantex-template-aboutus-team-notice'         => '.about-team-section',
		'avantex-template-aboutus-testimonials-notice' => '.about-testimonials-section',
		'avantex-template-aboutus-cta-notice'          => '.about-cta-section',
	);

	foreach ( $partials_config as $notice_setting_id => $selector ) {
		$wp_customize->selective_refresh->add_partial(
			$notice_setting_id,
			array(
				'selector'            => $selector,
				'container_inclusive' => false,
				'settings'            => array( $notice_setting_id ),
				'primary_setting'     => $notice_setting_id,
			)
		);
	}
}
