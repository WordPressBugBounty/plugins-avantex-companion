<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Fired during plugin activation
 *
 * @package    avantex-companion
 */

/**
 * This avantex_companion_plugin_activator Class defines that all code are necessary to run during the avantex companion plugins activation.
 */
class Avantex_Companion_Activator {

	/** Activation Sequence. */
	public static function activate() {

		$fresh_website_activate = get_option( 'fresh_website_activate' );
		if ( (bool) $fresh_website_activate === false ) {
			// Default pages when set as static posts.
			$pages = array( esc_html__( 'Home', 'avantex-companion' ), esc_html__( 'Blog', 'avantex-companion' ) );
			foreach ( $pages as $page ) {
				$post_data = array(
					'post_author' => 1,
					'post_name'   => $page,
					'post_status' => 'publish',
					'post_title'  => $page,
					'post_type'   => 'page',
				);
				if ( $page == 'Home' ) :
					$page_option = 'page_on_front';
					$template    = 'page-templates/frontpage.php';
				else :
					$page_option = 'page_for_posts';
					$template    = 'page.php';
				endif;
				$post_id = wp_insert_post( $post_data, false );
				if ( $post_id && ! is_wp_error( $post_id ) ) {
					update_post_meta( $post_id, '_wp_page_template', $template );
					update_option( 'show_on_front', 'page' );
					update_option( $page_option, $post_id );
				}
			}
			update_option( 'fresh_website_activate', true );
		}
	} // end of activate function

}//end class
