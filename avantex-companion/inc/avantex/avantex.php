<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Fetch theme parts.
 *
 * @package avantex-companion.
 */

// Frontpage Sections.
if ( ! function_exists( 'avantex_avantex_frontpage_sections' ) ) :
	/** Fetch Frontpage sections. */
	function avantex_avantex_frontpage_sections() {
		// Diffrent Themes.
		$activate_theme_data = wp_get_theme(); // getting current theme data.
		$activate_theme      = $activate_theme_data->name;

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-carousel.php';

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-about.php';

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-service.php';

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-portfolio.php';

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-callout.php';

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-team.php';

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-testimonial.php';

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-funfact.php';

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-news.php';

		require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/avantex/front-page/index-sponsor.php';

	}
	add_action( 'avantex_frontpage', 'avantex_avantex_frontpage_sections' );
endif;
