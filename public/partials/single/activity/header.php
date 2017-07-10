<?php

/**
 * Single Memory Header on activity page.
 *
 * @since       1.1.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / public / partials / single / activity
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly.
}
?>
<div class="bp-memories-wrapper">
	<h3><?php echo esc_html( apply_filters( 'bp_memories_single_activity_header', __( 'On This Day', 'bp-memories' ) ) ); ?></h3>
	<div class="bp-memory">
		<div class="bpm-activity-item">
