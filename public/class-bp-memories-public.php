<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link        https://sanket09.wordpress.com/
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / public
 */
class BP_Memories_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since   1.0.0
	 *
	 * @access  private
	 *
	 * @var     string  $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since   1.0.0
	 *
	 * @access  private
	 *
	 * @var     string  $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The suffix for css / js files.
	 *
	 * @since   1.0.0
	 *
	 * @access  private
	 *
	 * @var     string  $suffix    The suffix for css / js files.
	 */
	private $suffix;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 *
	 * @param   string  $plugin_name    The name of the plugin.
	 * @param   string  $version        The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->suffix      = bpm_memories_check_script_debug();

	}


	/**
	 * Display single memory on activity page.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function bpm_display_memories() {

		// Checking if Memories are allowed.
		if ( bpm_is_memory_page_allowed() ) {

			// Get memories.
			$memories = bpm_memories( 1 );

			// Display single old activity if exists.
			if ( ! empty( $memories ) ) {

				// Get single activity.
				$activity  = $memories[0]['memories'][0];
				$user_link = bp_core_get_user_domain( bp_loggedin_user_id(), $activity->user_nicename, $activity->user_login );

				include( bpm_locate_template( 'single/activity/header' ) );
				include( bpm_locate_template( 'single/memory' ) );
				include( bpm_locate_template( 'single/activity/footer' ) );
			}
		}
	}

	/**
	 * Enqueueing css files
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 */
	public function bpm_enqueue_style() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bp-memories-public' . $this->suffix . '.css', '', $this->version );

	}

	/**
	 * Load memories template.
	 *
	 * @since	1.0.0
	 *
	 * @access	public
	 *
	 * @param	string	$template	Content of template.
	 *
	 * @return 	string	Content of template.
	 */
	public function bpm_memory_template( $template ) {

		global $post;

		$bp_pages = bp_get_option( 'bp-pages' );

		// Check for memories template.
		if ( ! empty( $bp_pages['memories'] ) && ( (int) $post->ID === (int) $bp_pages['memories'] ) ) {
			ob_start();
			load_template( bpm_locate_template( 'memories' ) );

			// Get memories template content.
			$template_content = ob_get_contents();

			ob_end_clean();

			return $template_content;
		}

		return $template;

	}
}
