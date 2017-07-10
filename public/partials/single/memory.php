<?php

/**
 * Provide a public-facing view for the plugin.
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @since       1.1.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / public / partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly.
}
?>
<div class="bpm-activity-avatar">
	<a href="<?php echo esc_attr( $user_link ); ?>"><?php bpm_activity_avatar( $activity ); ?></a>
</div>
<div class="bpm-activity-content">
	<div class="bpm-activity-header">
		<p>
			<?php
			bpm_activity_action( $activity );

			$date_recorded      = bp_core_time_since( $activity->date_recorded );
			$activity_permalink = bp_activity_get_permalink( $activity->id );
			?>
			<a href="<?php echo esc_attr( $activity_permalink ); ?>" class="view bpm-activity-time-since" title="<?php esc_attr_e( 'View Discussion', 'bp-memories' ); ?>">
				<span class="time-since"><?php echo esc_html( $date_recorded ); ?></span>
			</a>
		</p>
	</div>
	<?php if ( ! empty( $activity->content ) ) : ?>

		<div class="bpm-activity-inner">
			<p><?php bpm_activity_content( $activity ); ?></p>
		</div>

	<?php endif; ?>
</div>
