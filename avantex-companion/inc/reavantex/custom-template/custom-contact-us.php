<?php
/** Section for Contact Us". */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
	$wp_customize->add_section(
		'avantex-template-contactus-section',
		array(
			'title'       => __( 'Contact-us Template Settings', 'reavantex' ),
			'panel'       => 'avantex-templates-panel',
			'description' => __( 'Settings for Avantex Contact Us template.', 'reavantex' ),
		)
	);

	// heading control.
	$wp_customize->add_setting(
		'avantex-template-contactus-notice',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'skyrocket_text_sanitization',
		)
	);
	$wp_customize->add_control(
		new Skyrocket_Simple_Notice_Custom_control(
			$wp_customize,
			'avantex-template-contactus-notice-control',
			array(
				'label'    => __( 'Template Contact Us settings ', 'reavantex' ),
				'settings' => 'avantex-template-contactus-notice',
				'section'  => 'avantex-template-contactus-section',
				'priority' => 1,
			)
		)
	);
	// Contact US Container Size.
	$wp_customize->add_setting(
		'avantex-template-contactus-container',
		array(
			'default'           => 'container',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'skyrocket_text_sanitization',
		)
	);
	$wp_customize->add_control(
		new Skyrocket_Text_Radio_Button_Custom_Control(
			$wp_customize,
			'avantex-template-contactus-container-control',
			array(
				'label'       => __( 'Contact US Container size', 'reavantex' ),
				'description' => esc_html__( 'Choose size of Container.', 'reavantex' ),
				'section'     => 'avantex-template-contactus-section',
				'settings'    => 'avantex-template-contactus-container',
				'priority'    => 2,
				'choices'     => array(
					'container'           => __( 'Container', 'reavantex' ), // Required. Setting for this particular radio button choice and the text to display.
					'container-full'      => __( 'Full Container', 'reavantex' ), // Required. Setting for this particular radio button choice and the text to display.
					'container-fluid p-0' => __( 'fluid', 'reavantex' ), // Required. Setting for this particular radio button choice and the text to display.
				),
			)
		)
	);
	$wp_customize->add_setting(
		'avantex-template-contactus-title-tag',
		array(
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Contact Now!', 'reavantex' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-template-contactus-title-tag-control',
			array(
				'label'    => __( 'Contact Page Tag / Subtitle', 'reavantex' ),
				'section'  => 'avantex-template-contactus-section',
				'settings' => 'avantex-template-contactus-title-tag',
				'type'     => 'text',
				'priority' => 3,
			)
		)
	);

	$wp_customize->add_setting(
		'avantex-template-contactus-title',
		array(
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Get in touch with us today', 'reavantex' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-template-contactus-title-control',
			array(
				'label'    => __( 'Contact Page Title', 'reavantex' ),
				'section'  => 'avantex-template-contactus-section',
				'settings' => 'avantex-template-contactus-title',
				'type'     => 'text',
				'priority' => 4,
			)
		)
	);

	// Contact Form Notice Control.
	$wp_customize->add_setting(
		'avantex-template-contactus-form-notice',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'skyrocket_text_sanitization',
		)
	);
	$wp_customize->add_control(
		new Skyrocket_Simple_Notice_Custom_control(
			$wp_customize,
			'avantex-template-contactus-form-notice-control',
			array(
				'label'    => __( '--- Contact Form Settings ---', 'reavantex' ),
				'settings' => 'avantex-template-contactus-form-notice',
				'section'  => 'avantex-template-contactus-section',
				'priority' => 4,
			)
		)
	);

	$wp_customize->add_setting(
		'avantex-template-contactus-form-tag',
		array(
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Write To Us', 'reavantex' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-template-contactus-form-tag-control',
			array(
				'label'    => __( 'Contact Form Subtitle / Tag', 'reavantex' ),
				'section'  => 'avantex-template-contactus-section',
				'settings' => 'avantex-template-contactus-form-tag',
				'type'     => 'text',
				'priority' => 5,
			)
		)
	);

	$wp_customize->add_setting(
		'avantex-template-contactus-form-title',
		array(
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Send a Message', 'reavantex' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-template-contactus-form-title-control',
			array(
				'label'    => __( 'Contact Form Title', 'reavantex' ),
				'section'  => 'avantex-template-contactus-section',
				'settings' => 'avantex-template-contactus-form-title',
				'type'     => 'text',
				'priority' => 6,
			)
		)
	);

	$wp_customize->add_setting(
		'avantex-template-contactus-form',
		array(
			'transport'         => 'postMessage',
			'default'           => "[WLFG id='1']",
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-template-contactus-form-control',
			array(
				'label'       => __( 'Contact Us Form Shortcode', 'reavantex' ),
				'description' => __( 'Put Contact Form plugin Shortcode Here.', 'reavantex' ),
				'section'     => 'avantex-template-contactus-section',
				'settings'    => 'avantex-template-contactus-form',
				'type'        => 'textarea',
				'priority'    => 7,
			)
		)
	);

	// Map Section Notice Control.
	$wp_customize->add_setting(
		'avantex-template-contactus-map-notice',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'skyrocket_text_sanitization',
		)
	);
	$wp_customize->add_control(
		new Skyrocket_Simple_Notice_Custom_control(
			$wp_customize,
			'avantex-template-contactus-map-notice-control',
			array(
				'label'    => __( '--- Google Map Settings ---', 'reavantex' ),
				'settings' => 'avantex-template-contactus-map-notice',
				'section'  => 'avantex-template-contactus-section',
				'priority' => 7,
			)
		)
	);

	$wp_customize->add_setting(
		'avantex-template-contactus-map-title',
		array(
			'transport'         => 'postMessage',
			'default'           => 'Where We Are Located',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-template-contactus-map-title-control',
			array(
				'label'    => esc_html__( 'Map Section Title', 'reavantex' ),
				'section'  => 'avantex-template-contactus-section',
				'settings' => 'avantex-template-contactus-map-title',
				'type'     => 'text',
				'priority' => 8,
			)
		)
	);

	$wp_customize->add_setting(
		'avantex-template-contactus-map-subtitle',
		array(
			'transport'         => 'postMessage',
			'default'           => 'Want to visit where actually we are doing it !',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-template-contactus-map-subtitle-control',
			array(
				'label'    => esc_html__( 'Map Section Subtitle', 'reavantex' ),
				'section'  => 'avantex-template-contactus-section',
				'settings' => 'avantex-template-contactus-map-subtitle',
				'type'     => 'text',
				'priority' => 9,
			)
		)
	);

	$wp_customize->add_setting(
		'avantex-template-contactus-map',
		array(
			'transport'         => 'postMessage',
			'default'           => 'https://maps.app.goo.gl/WXk5rQcjxQFSiyKm9',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'avantex-template-contactus-map-control',
			array(
				'type'        => 'textarea',
				'section'     => 'avantex-template-contactus-section',
				'settings'    => 'avantex-template-contactus-map',
				'label'       => __( 'Map Location / Shortcode', 'reavantex' ),
				'description' => __( 'Put Google Maps iframe code, map shortcode, a Google Maps share link, a raw address, or exact coordinates here.', 'reavantex' ),
				'priority'    => 10,
			)
		)
	);

	// Social Section Notice Control.
	$wp_customize->add_setting(
		'avantex-template-contactus-social-notice',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'skyrocket_text_sanitization',
		)
	);
	$wp_customize->add_control(
		new Skyrocket_Simple_Notice_Custom_control(
			$wp_customize,
			'avantex-template-contactus-social-notice-control',
			array(
				'label'       => __( '--- Social Media Settings ---', 'reavantex' ),
				'description' => __( 'Social media links and icons are shared from the Topbar/Header settings. You can configure them under <strong>Header Settings &gt; Topbar Section &gt; Social Links</strong>, or click the blue pencil shortcut icon directly on the live preview.', 'reavantex' ),
				'settings'    => 'avantex-template-contactus-social-notice',
				'section'     => 'avantex-template-contactus-section',
				'priority'    => 10,
			)
		)
	);

	// Toggle Contact page Socials.
	$wp_customize->add_setting(
		'avantex-contactpage-show-social',
		array(
			'default'           => 1,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'skyrocket_switch_sanitization',
		)
	);
	$wp_customize->add_control(
		new Skyrocket_Toggle_Switch_Custom_control(
			$wp_customize,
			'avantex-contactpage-show-social-control',
			array(
				'label'    => esc_html__( 'Enable Social Icons', 'reavantex' ),
				'section'  => 'avantex-template-contactus-section',
				'settings' => 'avantex-contactpage-show-social',
				'priority' => 11,
			)
		)
	);

	// Social Alignment option.
	$wp_customize->add_setting(
		'avantex-contactpage-social-align',
		array(
			'default'           => 'center',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'skyrocket_text_sanitization',
		)
	);
	$wp_customize->add_control(
		new Skyrocket_Text_Radio_Button_Custom_Control(
			$wp_customize,
			'avantex-contactpage-social-align-control',
			array(
				'label'           => __( 'Social Icons Alignment', 'reavantex' ),
				'description'     => esc_html__( 'Choose alignment of socials.', 'reavantex' ),
				'section'         => 'avantex-template-contactus-section',
				'settings'        => 'avantex-contactpage-social-align',
				'choices'         => array(
					'left'   => __( 'Left', 'reavantex' ),
					'center' => __( 'Center', 'reavantex' ),
					'right'  => __( 'Right', 'reavantex' ),
				),
				'priority'        => 12,
				'active_callback' => function () {
					return intval( get_theme_mod( 'avantex-contactpage-show-social', 1 ) ) === 1;
				},
			)
		)
	);

	// Addresses Section Notice Control.
	$wp_customize->add_setting(
		'avantex-template-contactus-repeater-notice',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'skyrocket_text_sanitization',
		)
	);
	$wp_customize->add_control(
		new Skyrocket_Simple_Notice_Custom_control(
			$wp_customize,
			'avantex-template-contactus-repeater-notice-control',
			array(
				'label'    => __( '--- Manage Addresses ---', 'reavantex' ),
				'settings' => 'avantex-template-contactus-repeater-notice',
				'section'  => 'avantex-template-contactus-section',
				'priority' => 12.5,
			)
		)
	);

	$wp_customize->add_setting(
		'avantex-template-contactus-repeater',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'customizer_repeater_sanitize',
			'default'           => defined( 'REAVANTEX_TEMPLATE_CONTACTUS_DEFAULTS' ) ? REAVANTEX_TEMPLATE_CONTACTUS_DEFAULTS : '[]',
		)
	);
	$wp_customize->add_control(
		new Customizer_Repeater(
			$wp_customize,
			'avantex-template-contactus-repeater-control',
			array(
				'label'                                 => esc_html__( 'Manage Addresses', 'reavantex' ),
				'settings'                              => 'avantex-template-contactus-repeater',
				'section'                               => 'avantex-template-contactus-section',
				'add_field_label'                       => esc_html__( 'Add Address', 'reavantex' ),
				'item_name'                             => esc_html__( 'Contacts', 'reavantex' ),
				'priority'                              => 13,
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


	// Register Selective Refresh Partials for Contact Us to provide pencil icons.
	// We register exactly one partial per notice control (sub-section header) and map it
	// to the section's HTML container. This provides a single pencil icon per section in the
	// preview that opens the section's sidebar controls without triggering selective refreshes.
	if ( isset( $wp_customize->selective_refresh ) ) {
		$partials_config = array(
			'avantex-template-contactus-notice'          => '.contact-template-wrapper',
			'avantex-template-contactus-form-notice'     => '.contact-form-wrapper-inner',
			'avantex-template-contactus-map-notice'      => '.contact-map-section',
			'avantex-template-contactus-social-notice'   => '.contact-social-icons-container',
			'avantex-template-contactus-repeater-notice' => '.contact-cards-section',
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
