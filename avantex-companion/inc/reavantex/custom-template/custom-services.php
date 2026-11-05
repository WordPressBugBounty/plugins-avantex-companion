<?php
/**
 * Section for Services Template settings.
 *
 * @package avantex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'avantex-template-services-section',
	array(
		'title'       => __( 'Services template settings', 'reavantex' ),
		'panel'       => 'avantex-templates-panel',
		'description' => __( 'Settings for Avantex Services page template.', 'reavantex' ),
	)
);

// ==========================================
// --- GENERAL SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-services-general-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-services-general-notice-control',
		array(
			'label'    => __( '--- General Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-services-general-notice',
			'section'  => 'avantex-template-services-section',
			'priority' => 10,
		)
	)
);

// Container size.
$wp_customize->add_setting(
	'avantex-template-services-container',
	array(
		'default'           => 'container',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Text_Radio_Button_Custom_Control(
		$wp_customize,
		'avantex-template-services-container-control',
		array(
			'label'       => __( 'Services Container size', 'reavantex' ),
			'description' => esc_html__( 'Choose size of Container.', 'reavantex' ),
			'section'     => 'avantex-template-services-section',
			'settings'    => 'avantex-template-services-container',
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
	'avantex-servicespage-show-content',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-servicespage-show-content-control',
		array(
			'label'    => esc_html__( 'Show Page Content Area', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-show-content',
			'priority' => 30,
		)
	)
);


// ==========================================
// --- HERO INTRO SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-services-hero-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-services-hero-notice-control',
		array(
			'label'    => __( '--- Hero Intro Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-services-hero-notice',
			'section'  => 'avantex-template-services-section',
			'priority' => 40,
		)
	)
);

// Toggle Hero Section.
$wp_customize->add_setting(
	'avantex-servicespage-show-hero',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-servicespage-show-hero-control',
		array(
			'label'    => esc_html__( 'Show Hero Intro Section', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-show-hero',
			'priority' => 50,
		)
	)
);

// Hero Image.
$wp_customize->add_setting(
	'avantex-servicespage-hero-image',
	array(
		'default'           => ( function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'service/service1.webp' ) : get_stylesheet_directory_uri() . '/assets/images/service/service1.webp' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'avantex-servicespage-hero-image-control',
		array(
			'label'    => __( 'Hero Image', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-hero-image',
			'priority' => 60,
		)
	)
);

// Hero Subtitle.
$wp_customize->add_setting(
	'avantex-servicespage-hero-subtitle',
	array(
		'default'           => __( 'What We Do', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-hero-subtitle-control',
		array(
			'label'    => __( 'Hero Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-hero-subtitle',
			'type'     => 'text',
			'priority' => 70,
		)
	)
);

// Hero Title.
$wp_customize->add_setting(
	'avantex-servicespage-hero-title',
	array(
		'default'           => __( 'Professional Services Built For Growth', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-hero-title-control',
		array(
			'label'    => __( 'Hero Title', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-hero-title',
			'type'     => 'text',
			'priority' => 80,
		)
	)
);

// Hero Description.
$wp_customize->add_setting(
	'avantex-servicespage-hero-desc',
	array(
		'default'           => __( 'We combine strategic thinking with technical expertise to deliver digital solutions that drive real business results. Our team of specialists works closely with you to understand your unique challenges and craft tailored solutions.', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-hero-desc-control',
		array(
			'label'    => __( 'Hero Description', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-hero-desc',
			'type'     => 'textarea',
			'priority' => 90,
		)
	)
);


// ==========================================
// --- SERVICES GRID SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-services-grid-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-services-grid-notice-control',
		array(
			'label'       => __( '--- Services Grid Settings ---', 'reavantex' ),
			'description' => __( 'Service cards, layouts, and items are shared with the Homepage Services Section. You can customize them in <strong>Homepage Section Settings &gt; Service Section</strong>, or click the blue pencil shortcut icon directly on the live preview.', 'reavantex' ),
			'settings'    => 'avantex-template-services-grid-notice',
			'section'     => 'avantex-template-services-section',
			'priority'    => 100,
		)
	)
);

// Toggle Grid Section.
$wp_customize->add_setting(
	'avantex-servicespage-show-grid',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-servicespage-show-grid-control',
		array(
			'label'    => esc_html__( 'Show Services Grid', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-show-grid',
			'priority' => 110,
		)
	)
);

// Grid Subtitle
$wp_customize->add_setting(
	'avantex-servicespage-grid-subtitle',
	array(
		'default'           => __( 'Our Services', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-grid-subtitle-control',
		array(
			'label'    => __( 'Grid Section Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-grid-subtitle',
			'type'     => 'text',
			'priority' => 120,
		)
	)
);

// Grid Title
$wp_customize->add_setting(
	'avantex-servicespage-grid-title',
	array(
		'default'           => __( 'What We Offer', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-grid-title-control',
		array(
			'label'    => __( 'Grid Section Title', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-grid-title',
			'type'     => 'text',
			'priority' => 130,
		)
	)
);


// ==========================================
// --- DETAILED SERVICE CARDS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-services-details-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-services-details-notice-control',
		array(
			'label'    => __( '--- Detailed Service Cards ---', 'reavantex' ),
			'settings' => 'avantex-template-services-details-notice',
			'section'  => 'avantex-template-services-section',
			'priority' => 140,
		)
	)
);

// Toggle Detail Cards.
$wp_customize->add_setting(
	'avantex-servicespage-show-details',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-servicespage-show-details-control',
		array(
			'label'    => esc_html__( 'Show Detail Cards Section', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-show-details',
			'priority' => 150,
		)
	)
);

// Details Subtitle
$wp_customize->add_setting(
	'avantex-servicespage-details-subtitle',
	array(
		'default'           => __( 'In-Depth', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-details-subtitle-control',
		array(
			'label'    => __( 'Detail Section Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-details-subtitle',
			'type'     => 'text',
			'priority' => 160,
		)
	)
);

// Details Title
$wp_customize->add_setting(
	'avantex-servicespage-details-title',
	array(
		'default'           => __( 'Services In Detail', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-details-title-control',
		array(
			'label'    => __( 'Detail Section Title', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-details-title',
			'type'     => 'text',
			'priority' => 170,
		)
	)
);

// Details Repeater
$wp_customize->add_setting(
	'avantex-servicespage-details-repeater',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_TEMPLATE_SERVICES_DETAILS_DEFAULTS' ) ? REAVANTEX_TEMPLATE_SERVICES_DETAILS_DEFAULTS : '[]',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-servicespage-details-repeater-control',
		array(
			'label'                                 => esc_html__( 'Manage Detail Cards', 'reavantex' ),
			'settings'                              => 'avantex-servicespage-details-repeater',
			'section'                               => 'avantex-template-services-section',
			'add_field_label'                       => esc_html__( 'Add Service Card', 'reavantex' ),
			'item_name'                             => esc_html__( 'Service Detail Card', 'reavantex' ),
			'priority'                              => 180,
			'item_limit'                             => 16,
			'customizer_repeater_image_control'     => true,
			'customizer_repeater_icon_control'      => false,
			'customizer_repeater_title_control'     => true,
			'customizer_repeater_btntitle_control'  => true,
			'customizer_repeater_subtitle_control'  => true, // Subtitle control for list of features
			'customizer_repeater_text_control'      => true,
			'customizer_repeater_text2_control'     => false,
			'customizer_repeater_link_control'      => true,
			'customizer_repeater_link2_control'     => false,
			'customizer_repeater_shortcode_control' => false,
			'customizer_repeater_repeater_control'  => false,
			'customizer_repeater_color_control'     => false,
			'customizer_repeater_color2_control'    => false,
		)
	)
);


// ==========================================
// --- WORK PROCESS SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-services-process-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-services-process-notice-control',
		array(
			'label'    => __( '--- Work Process Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-services-process-notice',
			'section'  => 'avantex-template-services-section',
			'priority' => 190,
		)
	)
);

// Toggle Process Section.
$wp_customize->add_setting(
	'avantex-servicespage-show-process',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-servicespage-show-process-control',
		array(
			'label'    => esc_html__( 'Show Work Process Section', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-show-process',
			'priority' => 200,
		)
	)
);

// Process Subtitle
$wp_customize->add_setting(
	'avantex-servicespage-process-subtitle',
	array(
		'default'           => __( 'How It Works', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-process-subtitle-control',
		array(
			'label'    => __( 'Process Section Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-process-subtitle',
			'type'     => 'text',
			'priority' => 210,
		)
	)
);

// Process Title
$wp_customize->add_setting(
	'avantex-servicespage-process-title',
	array(
		'default'           => __( 'Our Working Process', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-process-title-control',
		array(
			'label'    => __( 'Process Section Title', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-process-title',
			'type'     => 'text',
			'priority' => 220,
		)
	)
);

// Process Repeater
$wp_customize->add_setting(
	'avantex-servicespage-process-repeater',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_TEMPLATE_SERVICES_PROCESS_DEFAULTS' ) ? REAVANTEX_TEMPLATE_SERVICES_PROCESS_DEFAULTS : '[]',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-servicespage-process-repeater-control',
		array(
			'label'                                 => esc_html__( 'Manage Process Steps', 'reavantex' ),
			'settings'                              => 'avantex-servicespage-process-repeater',
			'section'                               => 'avantex-template-services-section',
			'add_field_label'                       => esc_html__( 'Add Step', 'reavantex' ),
			'item_name'                             => esc_html__( 'Process Step', 'reavantex' ),
			'priority'                              => 230,
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
// --- CALL TO ACTION SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-services-cta-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-services-cta-notice-control',
		array(
			'label'    => __( '--- Call to Action Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-services-cta-notice',
			'section'  => 'avantex-template-services-section',
			'priority' => 240,
		)
	)
);

// Toggle CTA Section.
$wp_customize->add_setting(
	'avantex-servicespage-show-cta',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-servicespage-show-cta-control',
		array(
			'label'    => esc_html__( 'Show Call to Action Section', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-show-cta',
			'priority' => 250,
		)
	)
);

// CTA Tagline
$wp_customize->add_setting(
	'avantex-servicespage-cta-tagline',
	array(
		'default'           => __( 'Start Your Project', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-cta-tagline-control',
		array(
			'label'    => __( 'CTA Tagline', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-cta-tagline',
			'type'     => 'text',
			'priority' => 260,
		)
	)
);

// CTA Title
$wp_customize->add_setting(
	'avantex-servicespage-cta-title',
	array(
		'default'           => __( 'Ready to get started?', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-cta-title-control',
		array(
			'label'    => __( 'CTA Main Title', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-cta-title',
			'type'     => 'text',
			'priority' => 270,
		)
	)
);

// CTA Description
$wp_customize->add_setting(
	'avantex-servicespage-cta-desc',
	array(
		'default'           => __( 'Let us help you transform your vision into reality. Our team is ready to discuss your next project.', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-cta-desc-control',
		array(
			'label'    => __( 'CTA Description Text', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-cta-desc',
			'type'     => 'textarea',
			'priority' => 280,
		)
	)
);

// CTA Button Text
$wp_customize->add_setting(
	'avantex-servicespage-cta-btn-text',
	array(
		'default'           => __( 'Contact Us', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-cta-btn-text-control',
		array(
			'label'    => __( 'CTA Button Text', 'reavantex' ),
			'section'  => 'avantex-template-services-section',
			'settings' => 'avantex-servicespage-cta-btn-text',
			'type'     => 'text',
			'priority' => 290,
		)
	)
);

// CTA Button Link
$wp_customize->add_setting(
	'avantex-servicespage-cta-btn-link',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-servicespage-cta-btn-link-control',
		array(
			'label'       => __( 'CTA Button Link', 'reavantex' ),
			'description' => __( 'Leave empty to link automatically to your Contact page.', 'reavantex' ),
			'section'     => 'avantex-template-services-section',
			'settings'    => 'avantex-servicespage-cta-btn-link',
			'type'        => 'text',
			'priority'    => 300,
		)
	)
);


// Selective Refresh Partials
if ( isset( $wp_customize->selective_refresh ) ) {
	$partials_config = array(
		'avantex-template-services-general-notice' => '.services-template-wrapper',
		'avantex-template-services-hero-notice'    => '.services-hero-section',
		'avantex-template-services-grid-notice'    => '.services-grid-embed-section',
		'avantex-template-services-details-notice' => '.services-details-section',
		'avantex-template-services-process-notice' => '.services-process-section',
		'avantex-template-services-cta-notice'     => '.services-cta-section',
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
