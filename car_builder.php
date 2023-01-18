<?php
session_start();

require_once('functions.php');


/**
 * Plugin Name:  Car Builder
 * Plugin URI:   https://github.com/Great0s/Car_builder
 * Description:  Car builder will help you creating a multistep form using data from csv file provided by you.
 * Version:      1.0
 * License:      GPL-2.0-or-later
 * Requires at least: 5.0
 * Requires PHP: 5.2
 * Author:       GreatOS
 * Author URI:   https://github.com/Great0s/
 */

/*
Car Builder is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Car Builder is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Car Builder.
*/


// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'CAR_BUILDER_VERSION', '1.0' );
define( 'CAR_BUILDER__MINIMUM_WP_VERSION', '5.0' );
define( 'CAR_BUILDER__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CAR_BUILDER_DELETE_LIMIT', 10000 );

register_activation_hook( __FILE__, 'plugin_activate' );
register_activation_hook( __FILE__, 'plugin_deactivate' );

require('view/layout.php');

?>

