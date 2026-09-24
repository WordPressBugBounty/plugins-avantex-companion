<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
* Plugin Name:  Avantex Companion
* Plugin URI:   https://wordpress.org/plugins/avantex-companion
* Description:  Avantex Companion plugin provides themes extra settings for theme avantex.
* Version:      0.2.7
* Author:       FARAZFRANK
* Author URI:   https://avantex.com/
* Tested up to: 7.1.2
* Requires:     4.0 or higher
* License:      GPLv3 or later
* License URI:  http://www.gnu.org/licenses/gpl-3.0.html
* Requires PHP: 7.4 tested up to 8.4
* Text Domain:  avantex-companion
* Domain Path:  /languages
*/

/*
Avantex Companion is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Avantex Companion is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Avantex Companion. If not, see http://www.gnu.org/licenses/gpl-3.0.html.
*/

if ( ! defined( 'AVANTEX_COMPANION_VERSION' ) ) {
	define( 'AVANTEX_COMPANION_VERSION', '0.2.7' );
}
define( 'AVANTEX_COMPANION_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'AVANTEX_COMPANION_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AVANTEX_COMPANION_REAVANTEX_URL', AVANTEX_COMPANION_PLUGIN_URL . 'inc/reavantex/' );
define( 'AVANTEX_COMPANION_REAVANTEX_DIR', AVANTEX_COMPANION_PLUGIN_DIR . 'inc/reavantex/' );


if ( ! function_exists( 'avantex_companion_init' ) ) {
	/** Initialize Companion Plugin */
	function avantex_companion_init() {
		$activate_theme_data = wp_get_theme(); // getting current theme data.
		$activate_theme      = $activate_theme_data->get( 'Name' );

		// Parent Avantex and legacy child themes.
		if ( ( 'Avantex' === $activate_theme ) || ( 'Avantex Construction' === $activate_theme ) || ( 'Avantex Automobile' === $activate_theme ) || ( 'Avantex Education' === $activate_theme ) || ( 'Avantex Medical' === $activate_theme ) || ( 'Avantex Yoga' === $activate_theme ) ) {
			require 'inc/avantex/avantex.php';
		}

		// ReAvantex modern child theme.
		if ( 'ReAvantex' === $activate_theme || 'reavantex' === strtolower( $activate_theme ) || ( function_exists( 'get_stylesheet' ) && 'reavantex' === get_stylesheet() ) ) {
			require AVANTEX_COMPANION_PLUGIN_DIR . 'inc/reavantex/reavantex.php';
		}
	}
	add_action( 'init', 'avantex_companion_init', 5 );
}


/** Plugin activation. */
function avantex_companion_activate() {
	$activate_theme_data = wp_get_theme();
	$activate_theme      = $activate_theme_data->get( 'Name' );

	// ReAvantex handles its own activation setup in inc/reavantex/reavantex.php.
	if ( 'ReAvantex' === $activate_theme || 'reavantex' === strtolower( $activate_theme ) ) {
		return;
	}

	require_once plugin_dir_path( __FILE__ ) . 'inc/avantex-companion-activator.php';
	Avantex_Companion_Activator::activate();
}
register_activation_hook( __FILE__, 'avantex_companion_activate' );
