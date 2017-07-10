<?php

/**
 * Memory Header on memories page.
 *
 * @since       1.1.0
 * @package     BP_Memories
 * @subpackage  BP_Memories / public / partials / memories
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly.
}
?>
<div id="bp-memories-<?php echo esc_attr( $memories['year'] ); ?>" class="bp-memories-main">

	<div class="bp-memories-time">

		<span class="year"><?php echo esc_html( $memories['time'] ); ?></span>
		<span class="date"><?php echo esc_html( $memories['date'] ); ?></span>

	</div>

	<ul class="bpm-activity-list">
