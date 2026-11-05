<?php
/**
 * Section for Terms of Service Page Template settings.
 *
 * @package avantex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'avantex-template-terms-of-service-section',
	array(
		'title'       => __( 'Terms of Service template settings', 'reavantex' ),
		'panel'       => 'avantex-templates-panel',
		'description' => __( 'Settings for Avantex Terms of Service page template.', 'reavantex' ),
	)
);

// ==========================================
// --- GENERAL SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-terms-of-service-general-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-terms-of-service-general-notice-control',
		array(
			'label'    => __( '--- General Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-terms-of-service-general-notice',
			'section'  => 'avantex-template-terms-of-service-section',
			'priority' => 10,
		)
	)
);

// Container size.
$wp_customize->add_setting(
	'avantex-template-terms-of-service-container',
	array(
		'default'           => 'container',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Text_Radio_Button_Custom_Control(
		$wp_customize,
		'avantex-template-terms-of-service-container-control',
		array(
			'label'       => __( 'Terms of Service Container size', 'reavantex' ),
			'description' => esc_html__( 'Choose size of Container.', 'reavantex' ),
			'section'     => 'avantex-template-terms-of-service-section',
			'settings'    => 'avantex-template-terms-of-service-container',
			'choices'     => array(
				'container'           => __( 'Container', 'reavantex' ),
				'container-full'      => __( 'Full Container', 'reavantex' ),
				'container-fluid p-0' => __( 'fluid', 'reavantex' ),
			),
			'priority'    => 20,
		)
	)
);


// ==========================================
// --- HEADER SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-terms-of-service-header-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-terms-of-service-header-notice-control',
		array(
			'label'    => __( '--- Header Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-terms-of-service-header-notice',
			'section'  => 'avantex-template-terms-of-service-section',
			'priority' => 30,
		)
	)
);

// Subtitle
$wp_customize->add_setting(
	'avantex-terms-of-service-subtitle',
	array(
		'default'           => __( 'Legal', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-terms-of-service-subtitle-control',
		array(
			'label'    => __( 'Header Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-terms-of-service-section',
			'settings' => 'avantex-terms-of-service-subtitle',
			'type'     => 'text',
			'priority' => 40,
		)
	)
);

// Title
$wp_customize->add_setting(
	'avantex-terms-of-service-title',
	array(
		'default'           => __( 'Terms of Service', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-terms-of-service-title-control',
		array(
			'label'    => __( 'Header Title', 'reavantex' ),
			'section'  => 'avantex-template-terms-of-service-section',
			'settings' => 'avantex-terms-of-service-title',
			'type'     => 'text',
			'priority' => 50,
		)
	)
);

// Last Updated Date
$wp_customize->add_setting(
	'avantex-terms-of-service-date',
	array(
		'default'           => __( 'July 17, 2026', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-terms-of-service-date-control',
		array(
			'label'       => __( 'Last Updated Date', 'reavantex' ),
			'description' => __( 'Leave empty to automatically use the page modified date.', 'reavantex' ),
			'section'     => 'avantex-template-terms-of-service-section',
			'settings'    => 'avantex-terms-of-service-date',
			'type'        => 'text',
			'priority'    => 55,
		)
	)
);


// ==========================================
// --- CONTENT SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-terms-of-service-content-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-terms-of-service-content-notice-control',
		array(
			'label'    => __( '--- Content Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-terms-of-service-content-notice',
			'section'  => 'avantex-template-terms-of-service-section',
			'priority' => 60,
		)
	)
);

// Toggle TOC Sidebar
$wp_customize->add_setting(
	'avantex-terms-of-service-show-toc',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-terms-of-service-show-toc-control',
		array(
			'label'    => esc_html__( 'Show Table of Contents Sidebar', 'reavantex' ),
			'section'  => 'avantex-template-terms-of-service-section',
			'settings' => 'avantex-terms-of-service-show-toc',
			'priority' => 70,
		)
	)
);

// Policy Content
$wp_customize->add_setting(
	'avantex-terms-of-service-content',
	array(
		'default'           => '<h2>1. Terms Acceptance</h2><p>By accessing and using this website, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our services.</p><h2>2. License to Use</h2><p>We grant you a personal, non-transferable, non-exclusive license to access and use our website strictly in accordance with these terms.</p><h2>3. Prohibited Conduct</h2><p>You agree not to use the website for any unlawful purposes, upload harmful code, or engage in activity that disrupts the website\'s performance.</p><h2>4. Intellectual Property</h2><p>All content, branding, code, and graphics on this website are the property of our company and are protected by international copyright laws.</p><h2>5. Disclaimer of Warranties</h2><p>Our website and services are provided on an "as is" and "as available" basis without warranties of any kind, either express or implied.</p>',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
if ( class_exists( 'Customizer_Page_Editor' ) ) {
	$wp_customize->add_control(
		new Customizer_Page_Editor(
			$wp_customize,
			'avantex-terms-of-service-content',
			array(
				'label'       => __( 'Terms of Service Content', 'reavantex' ),
				'description' => __( 'Edit the Terms of Service layout and headings. Headings will populate the Table of Contents automatically.', 'reavantex' ),
				'section'     => 'avantex-template-terms-of-service-section',
				'priority'    => 75,
			)
		)
	);
} else {
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-terms-of-service-content-control',
			array(
				'label'       => __( 'Terms of Service Content (HTML)', 'reavantex' ),
				'description' => __( 'Edit the Terms of Service HTML directly. Headings will populate the Table of Contents automatically.', 'reavantex' ),
				'section'     => 'avantex-template-terms-of-service-section',
				'settings'    => 'avantex-terms-of-service-content',
				'type'        => 'textarea',
				'priority'    => 75,
			)
		)
	);
}


// ==========================================
// --- CTA SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-terms-of-service-cta-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-terms-of-service-cta-notice-control',
		array(
			'label'    => __( '--- CTA Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-terms-of-service-cta-notice',
			'section'  => 'avantex-template-terms-of-service-section',
			'priority' => 80,
		)
	)
);

// Toggle CTA
$wp_customize->add_setting(
	'avantex-terms-of-service-show-cta',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-terms-of-service-show-cta-control',
		array(
			'label'    => esc_html__( 'Show CTA Section', 'reavantex' ),
			'section'  => 'avantex-template-terms-of-service-section',
			'settings' => 'avantex-terms-of-service-show-cta',
			'priority' => 90,
		)
	)
);

// CTA Title
$wp_customize->add_setting(
	'avantex-terms-of-service-cta-title',
	array(
		'default'           => __( 'Have questions about our terms?', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-terms-of-service-cta-title-control',
		array(
			'label'    => __( 'CTA Title', 'reavantex' ),
			'section'  => 'avantex-template-terms-of-service-section',
			'settings' => 'avantex-terms-of-service-cta-title',
			'type'     => 'text',
			'priority' => 100,
		)
	)
);

// CTA Description
$wp_customize->add_setting(
	'avantex-terms-of-service-cta-desc',
	array(
		'default'           => __( 'If you have any questions or concerns about our terms of service, please do not hesitate to contact us.', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-terms-of-service-cta-desc-control',
		array(
			'label'    => __( 'CTA Description', 'reavantex' ),
			'section'  => 'avantex-template-terms-of-service-section',
			'settings' => 'avantex-terms-of-service-cta-desc',
			'type'     => 'textarea',
			'priority' => 110,
		)
	)
);

// CTA Button Text
$wp_customize->add_setting(
	'avantex-terms-of-service-cta-btn-text',
	array(
		'default'           => __( 'Contact Us', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-terms-of-service-cta-btn-text-control',
		array(
			'label'    => __( 'CTA Button Text', 'reavantex' ),
			'section'  => 'avantex-template-terms-of-service-section',
			'settings' => 'avantex-terms-of-service-cta-btn-text',
			'type'     => 'text',
			'priority' => 120,
		)
	)
);

// CTA Button Link
$wp_customize->add_setting(
	'avantex-terms-of-service-cta-btn-link',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-terms-of-service-cta-btn-link-control',
		array(
			'label'       => __( 'CTA Button Link', 'reavantex' ),
			'description' => __( 'Leave empty to link automatically to your Contact page.', 'reavantex' ),
			'section'     => 'avantex-template-terms-of-service-section',
			'settings'    => 'avantex-terms-of-service-cta-btn-link',
			'type'        => 'text',
			'priority'    => 130,
		)
	)
);


// Selective Refresh Partials
if ( isset( $wp_customize->selective_refresh ) ) {
	$partials_config = array(
		'avantex-template-terms-of-service-general-notice' => '.terms-of-service-template-wrapper',
		'avantex-template-terms-of-service-header-notice'  => '.terms-of-service-header-section',
		'avantex-template-terms-of-service-content-notice' => '.terms-of-service-content-section',
		'avantex-template-terms-of-service-cta-notice'     => '.terms-of-service-cta-section',
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
