<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link            https://sanket09.wordpress.com/
 *
 * @since           1.0.0
 *
 * @package         BP_Memories
 *
 * @wordpress-plugin
 * Plugin Name:     BP Memories
 * Plugin URI:      https://github.com/sanketio/bp-memories
 * Description:     This plugin is useful to see memories for BuddyPress.
 * Version:         1.1.0
 * Author:          Sanket
 * Author URI:      https://sanket09.wordpress.com/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     bp-memories
 * Domain Path:     /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class that is used to define internationalization, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bp-memories.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since   1.0.0
 */
function run_bp_memories() {

	$bp_memories = new BP_Memories();
	$bp_memories->run();

}

run_bp_memories();
