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
		<?php load_template( bpm_locate_template( 'activities' ) ); ?>
	</div>
	<?php do_action( 'bp_after_directory_memories_list' ); ?>
</div>
<?php
do_action( 'bp_after_directory_memories' );
