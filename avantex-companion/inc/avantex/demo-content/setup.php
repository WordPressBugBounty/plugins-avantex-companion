<?php
/**
 * @package avantex Starter Sites
 * @since 1.0
 */


/**
 * Set import files
 */
if ( ! function_exists( 'avantex_starter_sites_import_files' ) ) {

	function avantex_starter_sites_import_files() {

		// Demos url.
		$demo_url = AVANTEX_COMPANION_PLUGIN_URL;

		// Check if a specific child theme is activated.
		$activated_child_themes = array(
			'Avantex Business',
			'Avantex Market',
			'Avantex Automobile',
			'Avantex Yoga',
			'Avantex Metaverse',
			'Avantex Construction',
			'Avantex Medical',
			'Avantex Education',
		);

		$demos_array = array(
			array(
				'import_file_name'           => esc_html__( 'Avantex Business', 'avantex' ),
				'categories'                 => array( 'Free Demos' ),
				'import_file_url'            => $demo_url . 'inc/avantex/demo-content/avantex-business/avantex-business.xml',
				'import_widget_file_url'     => $demo_url . 'inc/avantex/demo-content/avantex-business/avantex-business.wie',
				'import_customizer_file_url' => $demo_url . 'inc/avantex/demo-content/avantex-business/avantex-business.dat',
				'preview_url'                => 'https://wpfrank.com/demo/avantex-business',
				'import_preview_image_url'   => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/avantex-business.webp',
			),
			array(
				'import_file_name'           => esc_html__( 'Avantex Market', 'avantex' ),
				'categories'                 => array( 'Free Demos' ),
				'import_file_url'            => $demo_url . 'inc/avantex/demo-content/avantex-market/avantex-market.xml',
				'import_widget_file_url'     => $demo_url . 'inc/avantex/demo-content/avantex-market/avantex-market.wie',
				'import_customizer_file_url' => $demo_url . 'inc/avantex/demo-content/avantex-market/avantex-market.dat',
				'preview_url'                => 'https://wpfrank.com/demo/avantex-market-pro/',
				'import_preview_image_url'   => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/avantex-market.webp',
			),
			array(
				'import_file_name'         => esc_html__( 'Avantex Pro', 'avantex' ),
				'categories'               => array( 'Pro Demos' ),
				'preview_url'              => 'https://wpfrank.com/demo/avantex-pro',
				'import_preview_image_url' => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/avantex-pro.webp',
			),
			array(
				'import_file_name'         => esc_html__( 'Avantex Automobile', 'avantex' ),
				'categories'               => array( 'Pro Demos' ),
				'preview_url'              => 'https://wpfrank.com/demo/avantex-automobile-pro/',
				'import_preview_image_url' => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/avantex-automobile.webp',
			),
			array(
				'import_file_name'         => esc_html__( 'Avantex Yoga', 'avantex' ),
				'categories'               => array( 'Pro Demos' ),
				'preview_url'              => 'https://wpfrank.com/demo/avantex-yoga-pro/',
				'import_preview_image_url' => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/avantex-yoga.webp',
			),
			array(
				'import_file_name'         => esc_html__( 'Avantex Metaverse', 'avantex' ),
				'categories'               => array( 'Pro Demos' ),
				'preview_url'              => 'https://wpfrank.com/demo/avantex-metaverse-pro/',
				'import_preview_image_url' => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/avantex-metaverse.webp',
			),
			array(
				'import_file_name'         => esc_html__( 'Avantex Medical', 'avantex' ),
				'categories'               => array( 'Pro Demos' ),
				'preview_url'              => 'https://wpfrank.com/demo/avantex-medical-pro/',
				'import_preview_image_url' => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/avantex-medical.webp',
			),
			array(
				'import_file_name'         => esc_html__( 'Avantex Construction', 'avantex' ),
				'categories'               => array( 'Pro Demos' ),
				'preview_url'              => 'https://wpfrank.com/demo/avantex-construction-pro/',
				'import_preview_image_url' => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/avantex-construction.webp',
			),
			array(
				'import_file_name'         => esc_html__( 'Avantex Education', 'avantex' ),
				'categories'               => array( 'Pro Demos' ),
				'preview_url'              => 'https://wpfrank.com/demo/avantex-education-pro/',
				'import_preview_image_url' => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/avantex-education.webp',
			),
		);

		// Check if child theme is activated and its name is in the activated_child_themes array
		if ( is_child_theme() && in_array( wp_get_theme()->get( 'Name' ), $activated_child_themes ) ) {
			// Create a new demo array for the activated child theme
			$activated_child_theme_demo = array(
				'import_file_name'           => esc_html__( wp_get_theme()->get( 'Name' ), 'avantex' ),
				'categories'                 => array( 'Free Demos' ),
				'import_file_url'            => $demo_url . 'inc/avantex/demo-content/' . sanitize_title( wp_get_theme()->get( 'Name' ) ) . '/' . sanitize_title( wp_get_theme()->get( 'Name' ) ) . '.xml',
				'import_widget_file_url'     => $demo_url . 'inc/avantex/demo-content/' . sanitize_title( wp_get_theme()->get( 'Name' ) ) . '/' . sanitize_title( wp_get_theme()->get( 'Name' ) ) . '.wie',
				'import_customizer_file_url' => $demo_url . 'inc/avantex/demo-content/' . sanitize_title( wp_get_theme()->get( 'Name' ) ) . '/' . sanitize_title( wp_get_theme()->get( 'Name' ) ) . '.dat',
				'preview_url'                => 'https://wpfrank.com/demo/' . sanitize_title( wp_get_theme()->get( 'Name' ) ) . '-pro/',
				'import_preview_image_url'   => AVANTEX_COMPANION_PLUGIN_URL . '/inc/avantex/img/demo-screenshots/' . sanitize_title( wp_get_theme()->get( 'Name' ) ) . '.webp',
			);

			// Remove the activated child theme demo from the array (if exists)
			$demos_array = array_filter(
				$demos_array,
				function ( $demo ) {
					return $demo['import_file_name'] !== esc_html__( wp_get_theme()->get( 'Name' ), 'avantex' );
				}
			);

			// Add the activated child theme demo to the beginning of the array
			array_unshift( $demos_array, $activated_child_theme_demo );
		}
		// Change the category of the third element to "Pro Demos"
		if ( isset( $demos_array[2] ) ) {
			$demos_array[2]['categories'] = array( 'Pro Demos' );
		}
		return $demos_array;
	}
}
add_filter( 'ocdi/import_files', 'avantex_starter_sites_import_files' );


/**
 * Define actions that happen after import
 */
if ( ! function_exists( 'avantex_starter_sites_after_import_mods' ) ) {

	function avantex_starter_sites_after_import_mods( $selected_import ) {

		$menu_name        = '';
		$front_page_title = '';
		$import_file_name = $selected_import['import_file_name'];

		switch ( $import_file_name ) {
			case 'Avantex Business':
				$menu_name        = 'Avantex Business Menu';
				$front_page_title = 'Business Home';
				break;
			case 'Avantex Pro':
				$menu_name        = 'Avantex Pro Menu';
				$front_page_title = 'Avantex Home';
				break;
			case 'Avantex Automobile':
				$menu_name        = 'Avantex Auto Menu';
				$front_page_title = 'Automobile Home';
				break;
			case 'Avantex Market':
				$menu_name        = 'Avantex Market Menu';
				$front_page_title = 'Market Home';
				break;
			case 'Avantex Yoga':
				$menu_name        = 'Avantex Yoga Menu';
				$front_page_title = 'Yoga Home';
				break;
			case 'Avantex Metaverse':
				$menu_name        = 'Avantex Metaverse Menu';
				$front_page_title = 'Metaverse Home';
				break;
			case 'Avantex Construction':
				$menu_name        = 'Avantex Construction Menu';
				$front_page_title = 'Construction Home';
				break;
			case 'Avantex Education':
				$menu_name        = 'Avantex Education Menu';
				$front_page_title = 'Education Home';
				break;
			case 'Avantex Medical':
				$menu_name        = 'Avantex Medical Menu';
				$front_page_title = 'Medical Home';
				break;
		}

		// Assign the menu.
		$main_menu = get_term_by( 'name', $menu_name, 'nav_menu' );
		set_theme_mod( 'nav_menu_locations', array( 'primary' => $main_menu->term_id ) );

		// Assign the static front page and the blog page.
		$front_page = get_page_by_title( $front_page_title );
		$blog_page  = get_page_by_title( 'Blog' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page->ID );
		update_option( 'page_for_posts', $blog_page->ID );

		// Set the front page template to 'page-templates/frontpage.php'.
		$front_page_template = '/page-templates/frontpage.php';
		update_post_meta( $front_page->ID, '_wp_page_template', $front_page_template );

	}
}
add_action( 'ocdi/after_import', 'avantex_starter_sites_after_import_mods' );


// Custom CSS for OCDI plugin.
function avantex_starter_sites_ocdi_css() { ?>
	<style >
		.ocdi__gl-item:nth-child(n+3) .ocdi__gl-item-buttons .button-primary, .ocdi .ocdi__theme-about, .ocdi__intro-text {
			display: none;
		}
		.ocdi__gl-item-image-container::after {
			padding-top: 75% !important;
		}

	</style>
	<?php
}
add_action( 'admin_enqueue_scripts', 'avantex_starter_sites_ocdi_css' );

// Change the "One Click Demo Import" name from "Starter Sites" in Appearance menu.
function avantex_starter_sites_ocdi_plugin_page_setup( $default_settings ) {

	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'Avantex Demo Import', 'avantex' );
	$default_settings['menu_title']  = esc_html__( 'Avantex Starter Sites', 'avantex' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'one-click-demo-import';

	return $default_settings;

}
add_filter( 'ocdi/plugin_page_setup', 'avantex_starter_sites_ocdi_plugin_page_setup' );

// Register required plugins for the demos.
function avantex_starter_sites_register_plugins( $plugins ) {

	// List of plugins used by all theme demos.
	$theme_plugins = array(
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => true,
		),
		array(
			'name'     => 'Coming Soon Maintenance Mode',
			'slug'     => 'coming-soon-maintenance-mode',
			'required' => true,
		),
		array(
			'name'     => 'Filter Gallery',
			'slug'     => 'filter-gallery',
			'required' => true,
		),
		array(
			'name'     => 'Customizer Login Page',
			'slug'     => 'customizer-login-page',
			'required' => true,
		),
	);

	return array_merge( $plugins, $theme_plugins );

}
add_filter( 'ocdi/register_plugins', 'avantex_starter_sites_register_plugins' );


function ocdi_change_time_of_single_ajax_call() {
	return 10;
}
add_filter( 'ocdi/time_for_one_ajax_call', 'ocdi_change_time_of_single_ajax_call' );

/**
* Remove branding
*/
// add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
