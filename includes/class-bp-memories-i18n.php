<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link        https://sanket09.wordpress.com/
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / includes
 */
class BP_Memories_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bp-memories',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
