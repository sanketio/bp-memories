<?php

/**
 * Register all core functions for the plugin.
 *
 * @link        https://sanket09.wordpress.com/
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / includes
 */

/**
 * Register all core functions for the plugin.
 *
 * @since       1.0.0
 *
 * @package     BP_Memories
 * @subpackage  BP_Memories / includes
 */

/**
 * Checking if SCRIPT_DEBUG constant is defined or not and based on that returning suffix for JS/CSS
 *
 * @since   1.0.0
 *
 * @return  string
 */
function bpm_memories_check_script_debug() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && ( true === constant( 'SCRIPT_DEBUG' ) ) ) ? '' : '.min';

	return $suffix;

}

/**
 * Custom kses filtering array.
 *
 * @since   1.0.0
 *
 * @return  string  $content    Filtered array.
 */
function bpm_activity_filter_kses() {

	global $allowedtags;

	$activity_allowedtags = $allowedtags;
	$activity_allowedtags['a']['class'] = array();
	$activity_allowedtags['a']['id']    = array();
	$activity_allowedtags['a']['rel']   = array();
	$activity_allowedtags['a']['title'] = array();

	$activity_allowedtags['b']    = array();
	$activity_allowedtags['code'] = array();
	$activity_allowedtags['i']    = array();

	$activity_allowedtags['img']           = array();
	$activity_allowedtags['img']['src']    = array();
	$activity_allowedtags['img']['alt']    = array();
	$activity_allowedtags['img']['width']  = array();
	$activity_allowedtags['img']['height'] = array();
	$activity_allowedtags['img']['class']  = array();
	$activity_allowedtags['img']['id']     = array();
	$activity_allowedtags['img']['title']  = array();

	$activity_allowedtags['span']                   = array();
	$activity_allowedtags['span']['class']          = array();
	$activity_allowedtags['span']['data-livestamp'] = array();

	$activity_allowedtags = apply_filters( 'bp_activity_allowed_tags', $activity_allowedtags );

	return $activity_allowedtags;

}
