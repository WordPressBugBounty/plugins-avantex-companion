<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
* Plugin Name:  Avantex Companion
* Plugin URI:   https://wordpress.org/plugins/avantex-companion
* Description:  Avantex Companion plugin provides themes extra settings for theme avantex.
* Version:      0.2.3
* Author:       FARAZFRANK
* Author URI:   https://avantex.com/
* Tested up to: 6.2
* Requires:     4.0 or higher
* License:      GPLv3 or later
* License URI:  http://www.gnu.org/licenses/gpl-3.0.html
* Requires PHP: 4.0 tested up to 8.0.26
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

define( 'AVANTEX_COMPANION_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'AVANTEX_COMPANION_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


if ( ! function_exists( 'avantex_companion_init' ) ) {
	/** Initialize Companion Plugin */
	function avantex_companion_init() {
		$activate_theme_data = wp_get_theme(); // getting current theme data.
		$activate_theme      = $activate_theme_data->name;
		if ( ( 'Avantex' == $activate_theme ) || ( 'Avantex Construction' == $activate_theme ) || ( 'Avantex Automobile' == $activate_theme ) || ( 'Avantex Education' == $activate_theme ) || ( 'Avantex Medical' == $activate_theme ) || ( 'Avantex Yoga' == $activate_theme ) ) {
			require 'inc/avantex/avantex.php';
		}
	}
	add_action( 'init', 'avantex_companion_init' );
}

/** Plugin activation. */
function avantex_companion_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/avantex-companion-activator.php';
	Avantex_Companion_Activator::activate();
}
register_activation_hook( __FILE__, 'avantex_companion_activate' );
