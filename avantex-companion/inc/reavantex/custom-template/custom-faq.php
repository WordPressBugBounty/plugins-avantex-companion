<?php
/**
 * Section for FAQ Template settings.
 *
 * @package avantex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wp_customize->add_section(
	'avantex-template-faq-section',
	array(
		'title'       => __( 'FAQ template settings', 'reavantex' ),
		'panel'       => 'avantex-templates-panel',
		'description' => __( 'Settings for Avantex FAQ page template.', 'reavantex' ),
	)
);

// ==========================================
// --- GENERAL SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-faq-general-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-faq-general-notice-control',
		array(
			'label'    => __( '--- General Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-faq-general-notice',
			'section'  => 'avantex-template-faq-section',
			'priority' => 10,
		)
	)
);

// Container size.
$wp_customize->add_setting(
	'avantex-template-faq-container',
	array(
		'default'           => 'container',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Text_Radio_Button_Custom_Control(
		$wp_customize,
		'avantex-template-faq-container-control',
		array(
			'label'       => __( 'FAQ Container size', 'reavantex' ),
			'description' => esc_html__( 'Choose size of Container.', 'reavantex' ),
			'section'     => 'avantex-template-faq-section',
			'settings'    => 'avantex-template-faq-container',
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
	'avantex-faqpage-show-content',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-faqpage-show-content-control',
		array(
			'label'    => esc_html__( 'Show Page Content Area', 'reavantex' ),
			'section'  => 'avantex-template-faq-section',
			'settings' => 'avantex-faqpage-show-content',
			'priority' => 30,
		)
	)
);


// ==========================================
// --- HEADER SETTINGS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-faq-header-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-faq-header-notice-control',
		array(
			'label'    => __( '--- Header Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-faq-header-notice',
			'section'  => 'avantex-template-faq-section',
			'priority' => 40,
		)
	)
);

// FAQ Subtitle
$wp_customize->add_setting(
	'avantex-faqpage-subtitle',
	array(
		'default'           => __( 'FAQ', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-faqpage-subtitle-control',
		array(
			'label'    => __( 'FAQ Subtitle', 'reavantex' ),
			'section'  => 'avantex-template-faq-section',
			'settings' => 'avantex-faqpage-subtitle',
			'type'     => 'text',
			'priority' => 50,
		)
	)
);

// FAQ Title
$wp_customize->add_setting(
	'avantex-faqpage-title',
	array(
		'default'           => __( 'Frequently Asked Questions', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-faqpage-title-control',
		array(
			'label'    => __( 'FAQ Title', 'reavantex' ),
			'section'  => 'avantex-template-faq-section',
			'settings' => 'avantex-faqpage-title',
			'type'     => 'text',
			'priority' => 60,
		)
	)
);

// FAQ Description
$wp_customize->add_setting(
	'avantex-faqpage-desc',
	array(
		'default'           => __( 'Find answers to the most commonly asked questions below. If you cannot find what you are looking for, feel free to contact us.', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-faqpage-desc-control',
		array(
			'label'    => __( 'FAQ Description', 'reavantex' ),
			'section'  => 'avantex-template-faq-section',
			'settings' => 'avantex-faqpage-desc',
			'type'     => 'textarea',
			'priority' => 70,
		)
	)
);


// ==========================================
// --- QUESTIONS ---
// ==========================================
$wp_customize->add_setting(
	'avantex-template-faq-questions-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-faq-questions-notice-control',
		array(
			'label'    => __( '--- Questions ---', 'reavantex' ),
			'settings' => 'avantex-template-faq-questions-notice',
			'section'  => 'avantex-template-faq-section',
			'priority' => 80,
		)
	)
);

// FAQ Repeater
$wp_customize->add_setting(
	'avantex-faqpage-repeater',
	array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'customizer_repeater_sanitize',
		'default'           => defined( 'REAVANTEX_TEMPLATE_FAQ_DEFAULTS' ) ? REAVANTEX_TEMPLATE_FAQ_DEFAULTS : '[]',
	)
);
$wp_customize->add_control(
	new Customizer_Repeater(
		$wp_customize,
		'avantex-faqpage-repeater-control',
		array(
			'label'                                 => esc_html__( 'Manage FAQ Items', 'reavantex' ),
			'settings'                              => 'avantex-faqpage-repeater',
			'section'                               => 'avantex-template-faq-section',
			'add_field_label'                       => esc_html__( 'Add Question', 'reavantex' ),
			'item_name'                             => esc_html__( 'FAQ Item', 'reavantex' ),
			'priority'                              => 90,
			'item_limit'                             => 16,
			'customizer_repeater_image_control'     => false,
			'customizer_repeater_icon_control'      => false,
			'customizer_repeater_title_control'     => true, // Question
			'customizer_repeater_btntitle_control'  => false,
			'customizer_repeater_subtitle_control'  => true, // Category / Tag
			'customizer_repeater_text_control'      => true, // Answer
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
	'avantex-template-faq-cta-notice',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_text_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Simple_Notice_Custom_control(
		$wp_customize,
		'avantex-template-faq-cta-notice-control',
		array(
			'label'    => __( '--- CTA Settings ---', 'reavantex' ),
			'settings' => 'avantex-template-faq-cta-notice',
			'section'  => 'avantex-template-faq-section',
			'priority' => 100,
		)
	)
);

// Toggle CTA Section.
$wp_customize->add_setting(
	'avantex-faqpage-show-cta',
	array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'skyrocket_switch_sanitization',
	)
);
$wp_customize->add_control(
	new Skyrocket_Toggle_Switch_Custom_control(
		$wp_customize,
		'avantex-faqpage-show-cta-control',
		array(
			'label'    => esc_html__( 'Show CTA Section', 'reavantex' ),
			'section'  => 'avantex-template-faq-section',
			'settings' => 'avantex-faqpage-show-cta',
			'priority' => 110,
		)
	)
);

// CTA Title
$wp_customize->add_setting(
	'avantex-faqpage-cta-title',
	array(
		'default'           => __( 'Still have questions?', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-faqpage-cta-title-control',
		array(
			'label'    => __( 'CTA Title', 'reavantex' ),
			'section'  => 'avantex-template-faq-section',
			'settings' => 'avantex-faqpage-cta-title',
			'type'     => 'text',
			'priority' => 120,
		)
	)
);

// CTA Description
$wp_customize->add_setting(
	'avantex-faqpage-cta-desc',
	array(
		'default'           => __( 'We are here to help. Reach out to our team for personalized assistance.', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-faqpage-cta-desc-control',
		array(
			'label'    => __( 'CTA Description', 'reavantex' ),
			'section'  => 'avantex-template-faq-section',
			'settings' => 'avantex-faqpage-cta-desc',
			'type'     => 'textarea',
			'priority' => 130,
		)
	)
);

// CTA Button Text
$wp_customize->add_setting(
	'avantex-faqpage-cta-btn-text',
	array(
		'default'           => __( 'Contact Us', 'reavantex' ),
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-faqpage-cta-btn-text-control',
		array(
			'label'    => __( 'CTA Button Text', 'reavantex' ),
			'section'  => 'avantex-template-faq-section',
			'settings' => 'avantex-faqpage-cta-btn-text',
			'type'     => 'text',
			'priority' => 140,
		)
	)
);

// CTA Button Link
$wp_customize->add_setting(
	'avantex-faqpage-cta-btn-link',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'avantex-faqpage-cta-btn-link-control',
		array(
			'label'    => __( 'CTA Button Link', 'reavantex' ),
			'section'  => 'avantex-template-faq-section',
			'settings' => 'avantex-faqpage-cta-btn-link',
			'type'     => 'text',
			'priority' => 150,
		)
	)
);


// Selective Refresh Partials
if ( isset( $wp_customize->selective_refresh ) ) {
	$partials_config = array(
		'avantex-template-faq-general-notice'   => '.faq-template-wrapper',
		'avantex-template-faq-header-notice'    => '.faq-header-section',
		'avantex-template-faq-questions-notice' => '.faq-accordion-section',
		'avantex-template-faq-cta-notice'       => '.faq-cta-section',
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
