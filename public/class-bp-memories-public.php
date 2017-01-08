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

	public function bpm_display_memories() {

		$date = getdate();

		// Checking if BP_Activity_Activity class exists.
		if ( is_user_logged_in() && class_exists( 'BP_Activity_Activity' ) ) {
			$old_single_activity = array();

			// Checking for an older activity.
			for ( $i = ( $date['year'] - 1 ); $i >= 2009; $i-- ) {
				$args = array(
					'per_page' => 1,
					'date_query' => array(
						array(
							'year'  => $i,
							'month' => $date['mon'],
							'day'   => $date['mday'],
						),
					),
				);

				// Get single activity.
				$single_activity = bp_activity_get( $args );

				// If found single activity then break.
				if ( ! empty( $single_activity['activities'] ) ) {
					$old_single_activity = $single_activity['activities'];

					break;
				}
			}

			// Display single old activity if exists.
			if ( ! empty( $old_single_activity ) ) {
				$user_id   	  = bp_loggedin_user_id();
				$user_link 	  = bp_core_get_user_domain( $user_id, $old_single_activity[0]->user_nicename, $old_single_activity[0]->user_login );
				$bp 		  = buddypress();
				$object  	  = apply_filters( 'bp_get_activity_avatar_object_' . $old_single_activity[0]->component, 'user' );
				$type_default = bp_is_single_activity() ? 'full' : 'thumb';
				$email 		  = false;

				// Activity user display name.
				$dn_default  = isset( $old_single_activity[0]->display_name ) ? $old_single_activity[0]->display_name : '';

				// Prepend some descriptive text to alt.
				$alt_default = ! empty( $dn_default ) ? sprintf( __( 'Profile picture of %s', 'bp-memories' ), $dn_default ) : __( 'Profile picture', 'bp-memories' );

				// Avatar width.
				if ( isset( $bp->avatar->full->width ) || isset( $bp->avatar->thumb->width ) ) {
					$width = ( 'full' === $type_default ) ? $bp->avatar->full->width : $bp->avatar->thumb->width;
				} else {
					$width = 20;
				}

				// Avatar height.
				if ( isset( $bp->avatar->full->height ) || isset( $bp->avatar->thumb->height ) ) {
					$height = ( 'full' === $type_default ) ? $bp->avatar->full->height : $bp->avatar->thumb->height;
				} else {
					$height = 20;
				}

				// If this is a user object pass the users' email address for Gravatar so we don't have to prefetch it.
				if ( 'user' === $object && empty( $user_id ) && empty( $email ) && isset( $old_single_activity[0]->user_email ) ) {
					$email = $old_single_activity[0]->user_email;
				}

				// Arguments array for fetching avatar.
				$args = array(
					'item_id' => $user_id,
					'object'  => $object,
					'type'    => $type_default,
					'alt'     => $alt_default,
					'class'   => 'avatar',
					'width'   => $width,
					'height'  => $height,
					'email'   => $email,
				);
				?>
				<div class="bp-memories-wrapper">
					<h3><?php esc_html_e( 'On This Day', 'bp-memories' ); ?></h3>
					<div class="bp-memory">
						<div class="bpm-activity-item">
							<div class="bpm-activity-avatar">
								<a href="<?php echo esc_attr( $user_link ); ?>">
									<?php
									$allowed_tag = array(
										'img' => array(
											'src' => array(),
											'class' => array(),
											'width' => array(),
											'height' => array(),
											'alt' => array(),
										),
									);

									// Fetch avatar of user.
									echo wp_kses( bp_core_fetch_avatar( $args ), $allowed_tag ); ?>
								</a>
							</div>
							<div class="bpm-activity-content">
								<div class="bpm-activity-header">
									<p>
										<?php
										$date_recorded 		= bp_core_time_since( $old_single_activity[0]->date_recorded );
										$activity_permalink = bp_activity_get_permalink( $old_single_activity[0]->id );

										$allowed_tag = array(
											'a' => array(
												'href' => array(),
												'class' => array(),
												'title' => array(),
											),
										);

										echo wp_kses( $old_single_activity[0]->action, $allowed_tag );
										?>
										<a href="<?php echo esc_attr( $activity_permalink ); ?>" class="view bpm-activity-time-since" title="<?php esc_attr_e( 'View Discussion', 'bp-memories' ); ?>">
											<span class="time-since"><?php echo esc_html( $date_recorded ); ?></span>
										</a>
									</p>
								</div>
								<?php
								if ( ! empty( $old_single_activity[0]->content ) ) {
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
								}
								?>
							</div>
						</div>
					</div>
					<?php
					$bp_pages = bp_get_option( 'bp-pages' );
					$memory_page = '';

					if ( ! empty( $bp_pages['memories'] ) ) {
						$memory_page = get_permalink( $bp_pages['memories'] );
					} else {
						$memory_page = get_option( 'bpm_memory_page' );
					}

					if ( ! empty( $memory_page ) ) {
						?>
						<a class="button bp-more-memories" href="<?php echo esc_url( $memory_page ); ?>"><?php esc_html_e( 'See More Memories', 'bp-memories' ); ?></a>
						<?php
					}
					?>
				</div>
				<?php
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

}
