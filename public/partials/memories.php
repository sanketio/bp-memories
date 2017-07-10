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

do_action( 'bp_before_directory_memories' );
?>
<div id="buddypress">

	<?php do_action( 'bp_before_directory_memories_list' ); ?>

	<div class="bp-memories" aria-live="polite" aria-atomic="true" aria-relevant="all">

		<?php
		if( bpm_is_memory_page_allowed() ) :

			// Get memories.
			$memory_data = bpm_memories();

			if ( ! empty( $memory_data ) ) :

				foreach ( $memory_data as $memories ) :

					include( bpm_locate_template( 'memories/header' ) );

					foreach ( $memories['memories'] as $activity ) :

						$user_link = bp_core_get_user_domain( bp_loggedin_user_id(), $activity->user_nicename, $activity->user_login );

						?>

						<li class="bpm-activity-item" id="activity-<?php echo esc_attr( $activity->id ); ?>">

							<?php include( bpm_locate_template( 'single/memory' ) ); ?>

						</li>

						<?php

					endforeach;

					include( bpm_locate_template( 'memories/footer' ) );

				endforeach;

			endif;

		endif;

		?>

	</div>

	<?php do_action( 'bp_after_directory_memories_list' ); ?>

</div>
<?php
do_action( 'bp_after_directory_memories' );
