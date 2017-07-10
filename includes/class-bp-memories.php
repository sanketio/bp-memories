<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site.
 *
 * @link        https://sanket09.wordpress.com/
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, and public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / includes
 */
class BP_Memories {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since   1.0.0
	 *
	 * @access  protected
	 *
	 * @var     BP_Memories_Loader  $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since   1.0.0
	 *
	 * @access  protected
	 *
	 * @var     string      $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since   1.0.0
	 *
	 * @access  protected
	 *
	 * @var     string      $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the public-facing
	 * side of the site.
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'bp-memories';
		$this->version     = '1.1.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - BP_Memories_Loader.    Orchestrates the hooks of the plugin.
	 * - BP_Memories_i18n.      Defines internationalization functionality.
	 * - BP_Memories_Admin.     Defines all hooks for the admin area.
	 * - BP_Memories_Public.    Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since   1.0.0
	 *
	 * @access  private
	 */
	private function load_dependencies() {

		/**
		 * The core functions file.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/bp-memories-functions.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bp-memories-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bp-memories-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bp-memories-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bp-memories-public.php';

		$this->loader = new BP_Memories_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the BP_Memories_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since   1.0.0
	 *
	 * @access  private
	 */
	private function set_locale() {

		$plugin_i18n = new BP_Memories_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since   1.0.0
	 *
	 * @access  private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new BP_Memories_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_admin, 'bpm_create_memory_page' );

		$this->loader->add_filter( 'bp_directory_pages', $plugin_admin, 'bpm_directory_pages' );
		$this->loader->add_filter( 'bp_core_get_directory_page_ids', $plugin_admin, 'bpm_get_directory_page_ids' );

		// Add link to settings page.
		$this->loader->add_filter( 'plugin_action_links', $plugin_admin, 'bpm_plugin_action_links', 11, 2 );
		$this->loader->add_filter( 'network_admin_plugin_action_links', $plugin_admin, 'bpm_plugin_action_links', 11, 2 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since   1.0.0
	 *
	 * @access  private
	 */
	private function define_public_hooks() {

		$plugin_public = new BP_Memories_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'bpm_enqueue_style' );

		$post_array = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

		if ( ( empty( $post_array ) || ( ! empty( $post_array ) && ! empty( $post_array['action'] ) && 'activity_get_older_updates' === $post_array['action'] && empty( $post_array['page'] ) ) ) ) {
			$this->loader->add_action( 'bp_before_activity_loop', $plugin_public, 'bpm_display_memories' );
		}

		$this->loader->add_filter( 'the_content', $plugin_public, 'bpm_memory_template' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 */
	public function run() {

		$this->loader->run();

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 *
	 * @return  string  The name of the plugin.
	 */
	public function get_plugin_name() {

		return $this->plugin_name;

	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 *
	 * @return  BP_Memories_Loader  Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {

		return $this->loader;

	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since   1.0.0
	 *
	 * @access  public
	 *
	 * @return  string  The version number of the plugin.
	 */
	public function get_version() {

		return $this->version;

	}

}
