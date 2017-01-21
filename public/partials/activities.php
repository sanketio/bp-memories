<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link        https://sanket09.wordpress.com/
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / public / partials
 */

// Checking if BuddyPress plugin is active.
if ( is_user_logged_in() && is_buddypress_active() ) {
	// Get pld activities.
	$old_activities = bpm_activities();

	if ( ! empty( $old_activities ) ) {
		foreach ( $old_activities as $key => $activities ) {
			?>
			<div id="bp-memories-<?php echo esc_attr( $activities['year'] ); ?>" class="bp-memories-main">
				<div class="bp-memories-time">
					<span class="year"><?php echo esc_html( $activities['time'] ); ?></span>
					<span class="date"><?php echo esc_html( $activities['date'] ); ?></span>
				</div>
				<ul class="bpm-activity-list">
					<?php
					foreach ( $activities['activities'] as $act_key => $activity ) {
						$user_id   = bp_loggedin_user_id();
						$user_link = bp_core_get_user_domain( $user_id, $activity->user_nicename, $activity->user_login );
						$args 	   = bpm_get_avatar_args( $activity );
						?>
						<li class="bpm-activity-item" id="activity-<?php echo esc_attr( $activity->id ); ?>">
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

										echo wp_kses( $activity->action, $allowed_tag );

										$date_recorded 		= bp_core_time_since( $activity->date_recorded );
										$activity_permalink = bp_activity_get_permalink( $activity->id );
										?>
										<a href="<?php echo esc_attr( $activity_permalink ); ?>" class="view bpm-activity-time-since" title="<?php esc_attr_e( 'View Discussion', 'bp-memories' ); ?>">
											<span class="time-since"><?php echo esc_html( $date_recorded ); ?></span>
										</a>
									</p>
								</div>
								<?php
								if ( ! empty( $activity->content ) ) {
									?>
									<div class="bpm-activity-inner">
										<p>
											<?php
											$allowed_tags = bpm_activity_filter_kses();

											echo wp_kses( $activity->content, $allowed_tags );
											?>
										</p>
									</div>
									<?php
								}
								?>
							</div>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
			<?php
		}
	} else {
		?>
		<div class="no-bp-memories">
			<?php
			$message = __( 'No memories found.!', 'bp-memories' );
			$message = apply_filters( 'bpm_no_memories_found', $message );

			echo esc_html( $message );
			?>
		</div>
		<?php
	}
}
