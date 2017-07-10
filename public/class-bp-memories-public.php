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
	 * Display single memory on activity page
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function bpm_display_memories() {

		// Checking if BuddyPress plugin is active.
		if ( is_user_logged_in() && is_buddypress_active() ) :

			// Get old activities.
			$old_activities = bpm_activities( 1 );

			// Display single old activity if exists.
			if ( ! empty( $old_activities ) ) :

				// Get single activity.
				$old_single_activity = $old_activities[0]['activities'];
				$user_id             = bp_loggedin_user_id();
				$user_link           = bp_core_get_user_domain( $user_id, $old_single_activity[0]->user_nicename, $old_single_activity[0]->user_login );
				$args                = bpm_get_avatar_args( $old_single_activity[0] );
				?>
				<div class="bp-memories-wrapper">
					<h3><?php esc_html_e( 'On This Day', 'bp-memories' ); ?></h3>
					<div class="bp-memory">
						<div class="bpm-activity-item">
							<div class="bpm-activity-avatar">
								<a href="<?php echo esc_attr( $user_link ); ?>">
									<?php
									$allowed_tag = bpm_activity_avatar_kses_tags();

									// Fetch avatar of user.
									echo wp_kses( bp_core_fetch_avatar( $args ), $allowed_tag ); ?>
								</a>
							</div>
							<div class="bpm-activity-content">
								<div class="bpm-activity-header">
									<p>
										<?php
										$allowed_tag = bpm_activity_action_kses_tags();

										echo wp_kses( $old_single_activity[0]->action, $allowed_tag );

										$date_recorded      = bp_core_time_since( $old_single_activity[0]->date_recorded );
										$activity_permalink = bp_activity_get_permalink( $old_single_activity[0]->id );
										?>
										<a href="<?php echo esc_attr( $activity_permalink ); ?>" class="view bpm-activity-time-since" title="<?php esc_attr_e( 'View Discussion', 'bp-memories' ); ?>">
											<span class="time-since"><?php echo esc_html( $date_recorded ); ?></span>
										</a>
									</p>
								</div>
								<?php
								if ( ! empty( $old_single_activity[0]->content ) ) :

									?>
									<div class="bpm-activity-inner">
										<p>
											<?php
											$allowed_tags = bpm_activity_filter_kses();

											echo wp_kses( $old_single_activity[0]->content, $allowed_tags );
											?>
										</p>
									</div>
									<?php

								endif;
								?>
							</div>
						</div>
					</div>
					<?php
					$bp_pages = bp_get_option( 'bp-pages' );

					if ( ! empty( $bp_pages['memories'] ) ) {

						$memory_page_id = $bp_pages['memories'];

					} else {

						$memory_page_id = get_option( 'bpm_memory_page' );
					}

					$memory_page = get_permalink( $memory_page_id );

					if ( ! empty( $memory_page ) ) :

						?>
						<a class="button bp-more-memories" href="<?php echo esc_url( $memory_page ); ?>"><?php esc_html_e( 'See More Memories', 'bp-memories' ); ?></a>
						<?php

					endif;
					?>
				</div>
				<?php

			endif;

		endif;
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
