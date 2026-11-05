<?php
/**
 * Section for Privacy Policy Page Template settings.
 *
 * @package avantex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'avantex-template-privacy-policy-section',
	array(
		'title'       => __( 'Privacy Policy template settings', 'reavantex' ),
		'panel'       => 'avantex-templates-panel',
		'description' => __( 'Settings for Avantex Privacy Policy page template.', 'reavantex' ),
	)
);

// ==========================================
// --- GENERAL SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-privacy-policy-general-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-privacy-policy-general-notice-control',
		array(
			'label'    => __( '--- General Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-privacy-policy-general-notice',
			'section'  => 'avantex-template-privacy-policy-section',
			'priority' => 10,
		)
	)
);

// Container size.
$wp_customize->add_setting(
	'avantex-template-privacy-policy-container',
	array(
		'default'           => 'container',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Text_Radio_Button_Custom_Control(
		$wp_customize,
		'avantex-template-privacy-policy-container-control',
		array(
			'label'       => __( 'Privacy Policy Container size', 'reavantex' ),
			'description' => esc_html__( 'Choose size of Container.', 'reavantex' ),
			'section'     => 'avantex-template-privacy-policy-section',
			'settings'    => 'avantex-template-privacy-policy-container',
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
	'avantex-template-privacy-policy-header-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-privacy-policy-header-notice-control',
		array(
			'label'    => __( '--- Header Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-privacy-policy-header-notice',
			'section'  => 'avantex-template-privacy-policy-section',
			'priority' => 30,
		)
	)
);

// Subtitle
$wp_customize->add_setting(
	'avantex-privacy-policy-subtitle',
	array(
		'default'           => __( 'Legal', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-privacy-policy-subtitle-control',
		array(
			'label'    => __( 'Header Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-privacy-policy-section',
			'settings' => 'avantex-privacy-policy-subtitle',
			'type'     => 'text',
			'priority' => 40,
		)
	)
);

// Title
$wp_customize->add_setting(
	'avantex-privacy-policy-title',
	array(
		'default'           => __( 'Privacy Policy', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-privacy-policy-title-control',
		array(
			'label'    => __( 'Header Title', 'reavantex' ),
			'section'  => 'avantex-template-privacy-policy-section',
			'settings' => 'avantex-privacy-policy-title',
			'type'     => 'text',
			'priority' => 50,
		)
	)
);

// Last Updated Date
$wp_customize->add_setting(
	'avantex-privacy-policy-date',
	array(
		'default'           => __( 'July 17, 2026', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-privacy-policy-date-control',
		array(
			'label'       => __( 'Last Updated Date', 'reavantex' ),
			'description' => __( 'Leave empty to automatically use the page modified date.', 'reavantex' ),
			'section'     => 'avantex-template-privacy-policy-section',
			'settings'    => 'avantex-privacy-policy-date',
			'type'        => 'text',
			'priority'    => 55,
		)
	)
);


// ==========================================
// --- CONTENT SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-privacy-policy-content-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-privacy-policy-content-notice-control',
		array(
			'label'    => __( '--- Content Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-privacy-policy-content-notice',
			'section'  => 'avantex-template-privacy-policy-section',
			'priority' => 60,
		)
	)
);

// Toggle TOC Sidebar
$wp_customize->add_setting(
	'avantex-privacy-policy-show-toc',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-privacy-policy-show-toc-control',
		array(
			'label'    => esc_html__( 'Show Table of Contents Sidebar', 'reavantex' ),
			'section'  => 'avantex-template-privacy-policy-section',
			'settings' => 'avantex-privacy-policy-show-toc',
			'priority' => 70,
		)
	)
);

// Policy Content
$wp_customize->add_setting(
	'avantex-privacy-policy-content',
	array(
		'default'           => '<h2>1. Information Collection</h2><p>We collect information you provide directly to us when you register, make a purchase, or contact us. This includes your name, email address, phone number, and billing information.</p><h2>2. How We Use Information</h2><p>We use the collected information to operate, maintain, and improve our services, process transactions, send transaction confirmations, and communicate with you about updates and offers.</p><h2>3. Data Security</h2><p>We implement industry-standard security measures to safeguard your personal data from unauthorized access, disclosure, or alteration.</p><h2>4. Third-Party Sharing</h2><p>We do not share your personal information with third parties except as necessary to provide our services (e.g., payment processing) or when required by law.</p><h2>5. Cookie Policy</h2><p>We use cookies to analyze web traffic, personalize content, and provide social media features. You can disable cookies in your browser settings if you prefer.</p>',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
if ( class_exists( 'Customizer_Page_Editor' ) ) {
	$wp_customize->add_control(
		new Customizer_Page_Editor(
			$wp_customize,
			'avantex-privacy-policy-content',
			array(
				'label'       => __( 'Privacy Policy Content', 'reavantex' ),
				'description' => __( 'Edit the Privacy Policy layout and headings. Headings will populate the Table of Contents automatically.', 'reavantex' ),
				'section'     => 'avantex-template-privacy-policy-section',
				'priority'    => 75,
			)
		)
	);
} else {
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-privacy-policy-content-control',
			array(
				'label'       => __( 'Privacy Policy Content (HTML)', 'reavantex' ),
				'description' => __( 'Edit the Privacy Policy HTML directly. Headings will populate the Table of Contents automatically.', 'reavantex' ),
				'section'     => 'avantex-template-privacy-policy-section',
				'settings'    => 'avantex-privacy-policy-content',
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
	'avantex-template-privacy-policy-cta-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-privacy-policy-cta-notice-control',
		array(
			'label'    => __( '--- CTA Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-privacy-policy-cta-notice',
			'section'  => 'avantex-template-privacy-policy-section',
			'priority' => 80,
		)
	)
);

// Toggle CTA
$wp_customize->add_setting(
	'avantex-privacy-policy-show-cta',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-privacy-policy-show-cta-control',
		array(
			'label'    => esc_html__( 'Show CTA Section', 'reavantex' ),
			'section'  => 'avantex-template-privacy-policy-section',
			'settings' => 'avantex-privacy-policy-show-cta',
			'priority' => 90,
		)
	)
);

// CTA Title
$wp_customize->add_setting(
	'avantex-privacy-policy-cta-title',
	array(
		'default'           => __( 'Have questions about our privacy policies?', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-privacy-policy-cta-title-control',
		array(
			'label'    => __( 'CTA Title', 'reavantex' ),
			'section'  => 'avantex-template-privacy-policy-section',
			'settings' => 'avantex-privacy-policy-cta-title',
			'type'     => 'text',
			'priority' => 100,
		)
	)
);

// CTA Description
$wp_customize->add_setting(
	'avantex-privacy-policy-cta-desc',
	array(
		'default'           => __( 'If you have any questions or concerns about our privacy policy, please do not hesitate to contact us.', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-privacy-policy-cta-desc-control',
		array(
			'label'    => __( 'CTA Description', 'reavantex' ),
			'section'  => 'avantex-template-privacy-policy-section',
			'settings' => 'avantex-privacy-policy-cta-desc',
			'type'     => 'textarea',
			'priority' => 110,
		)
	)
);

// CTA Button Text
$wp_customize->add_setting(
	'avantex-privacy-policy-cta-btn-text',
	array(
		'default'           => __( 'Contact Us', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-privacy-policy-cta-btn-text-control',
		array(
			'label'    => __( 'CTA Button Text', 'reavantex' ),
			'section'  => 'avantex-template-privacy-policy-section',
			'settings' => 'avantex-privacy-policy-cta-btn-text',
			'type'     => 'text',
			'priority' => 120,
		)
	)
);

// CTA Button Link
$wp_customize->add_setting(
	'avantex-privacy-policy-cta-btn-link',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-privacy-policy-cta-btn-link-control',
		array(
			'label'       => __( 'CTA Button Link', 'reavantex' ),
			'description' => __( 'Leave empty to link automatically to your Contact page.', 'reavantex' ),
			'section'     => 'avantex-template-privacy-policy-section',
			'settings'    => 'avantex-privacy-policy-cta-btn-link',
			'type'        => 'text',
			'priority'    => 130,
		)
	)
);


// Selective Refresh Partials
if ( isset( $wp_customize->selective_refresh ) ) {
	$partials_config = array(
		'avantex-template-privacy-policy-general-notice' => '.privacy-policy-template-wrapper',
		'avantex-template-privacy-policy-header-notice'  => '.privacy-policy-header-section',
		'avantex-template-privacy-policy-content-notice' => '.privacy-policy-content-section',
		'avantex-template-privacy-policy-cta-notice'     => '.privacy-policy-cta-section',
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
