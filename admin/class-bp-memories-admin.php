<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link        https://sanket09.wordpress.com/
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version.
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / admin
 */
class BP_Memories_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 *
	 * @param   string  $plugin_name    The name of this plugin.
	 * @param   string  $version        The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Create memory page and storing in option table.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 */
	public function bpm_create_memory_page() {

		// Get memory page.
		$memory_page = get_option( 'bpm_memory_page' );

		// Checking if memory page is already created.
		if ( empty( $memory_page ) ) {
			$memory_page_id = wp_insert_post( array(
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_status'    => 'publish',
				'post_title'     => 'Memories',
				'post_type'      => 'page',
			) );

			// Updating memory page option.
			update_option( 'bpm_memory_page', $memory_page_id );
		}

	}

	/**
	 * Storing memory page in BuddPress directory pages.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 *
	 * @param   array   $directory_pages    BuddyPress directory page array
	 *
	 * @return  array   BuddyPress directory page array
	 */
	public function bpm_directory_pages( $directory_pages ) {

		$directory_pages['memories'] = esc_html__( 'Memories', 'bp-memories' );

		return $directory_pages;

	}

	/**
	 * Save memory page in bp-pages.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 *
	 * @param   array   $page_ids   BuddyPress pages array
	 *
	 * @return  array   BuddyPress pages array
	 */
	public function bpm_get_directory_page_ids( $page_ids ) {

		$memory_page = bp_get_option( 'bp-pages' );

		if ( ! empty( $memory_page['memories'] ) ) {
			$page_ids['memories'] = (int) $memory_page['memories'];
		}

		return $page_ids;

	}


	/**
	 * Add Settings link to plugins area.
	 *
	 * @since 1.1.0
	 *
	 * @param array $links Links array in which we would prepend our link.
	 * @param string $file Current plugin basename.
	 *
	 * @return array Processed links.
	 */
	public function bpm_plugin_action_links( $links, $file ) {

		// Return normal links if not BP Memories.
		if ( plugin_basename( 'bp-memories/bp-memories.php' ) !== $file ) {

			return $links;
		}

		// Add a few links to the existing links array.
		return array_merge( $links, array(
			'settings' => '<a href="' . esc_url( bp_get_admin_url( add_query_arg( array( 'page' => 'bp-page-settings' ), 'admin.php' ) ) ) . '">' . esc_html__( 'Settings', 'bp-memories' ) . '</a>',
		) );
	}
}
