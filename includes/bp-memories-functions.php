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
 * Custom kses filtering array for activity.
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

/**
 * Locate memories template.
 *
 * @since   1.0.0
 *
 * @param   string  $template   Template name.
 * @param   bool    $url        check if return from url or path.
 *
 * @return  string  Located template path/url.
 */
function bpm_locate_template( $template, $url = false ) {

	// Template name.
	$template_name = $template . '.php';

	// Path for template in plugin.
	$path = 'public/partials/';

	// Path for template in theme.
	$theme_path = 'bp-memories/';

	// Stylesheet path.
	$stylesheet_path = trailingslashit( STYLESHEETPATH );

	// Stylesheet URI.
	$stylesheet_uri = trailingslashit( get_stylesheet_directory_uri() );

	// Template path.
	$template_path = trailingslashit( TEMPLATEPATH );

	// Template URI.
	$template_uri = trailingslashit( get_template_directory_uri() );

	// Checking for file exist in stylesheet, template.
	if ( file_exists( $stylesheet_path . $theme_path . $template_name ) ) {
		if ( $url ) {
			$located = $stylesheet_uri . $theme_path . $template_name;
		} else {
			$located = $stylesheet_path . $theme_path . $template_name;
		}
	} elseif ( file_exists( $template_path . $theme_path . $template_name ) ) {
		if ( $url ) {
			$located = $template_uri . $theme_path . $template_name;
		} else {
			$located = $template_path . $theme_path . $template_name;
		}
	} else {
		if ( $url ) {
			$plugin_url = plugin_dir_url( dirname( __FILE__ ) );
			$located = trailingslashit( $plugin_url ) . $path . $template_name;
		} else {
			$plugin_path = plugin_dir_path( dirname( __FILE__ ) );
			$located = trailingslashit( $plugin_path ) . $path . $template_name;
		}
	}

	return $located;

}

/**
 * Get args array for avatar.
 *
 * @since   1.0.0
 *
 * @param   object  $activity   Activity object.
 *
 * @return  array   Args array for avatar.
 */
function bpm_get_avatar_args( $activity ) {

	$user_id   	  = bp_loggedin_user_id();
	$bp 		  = buddypress();
	$object  	  = apply_filters( 'bp_get_activity_avatar_object_' . $activity->component, 'user' );
	$type_default = bp_is_single_activity() ? 'full' : 'thumb';
	$email 		  = false;

	// Activity user display name.
	$dn_default  = isset( $activity->display_name ) ? $activity->display_name : '';

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
	if ( 'user' === $object && empty( $user_id ) && empty( $email ) && isset( $activity->user_email ) ) {
		$email = $activity->user_email;
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

	return $args;

}

/**
 * Custom kses filtering array for activity action.
 *
 * @since   1.0.0
 *
 * @return  array   Allowed tags for wp_kses function.
 */
function bpm_activity_action_kses_tags() {

	$allowed_tag = array(
		'a' => array(
			'href'  => array(),
			'class' => array(),
			'title' => array(),
		),
	);

	return $allowed_tag;

}

/**
 * Custom kses filtering array for activity avatar.
 *
 * @since   1.0.0
 *
 * @return  array   Allowed tags for wp_kses function.
 */
function bpm_activity_avatar_kses_tags() {

	$allowed_tag = array(
		'img' => array(
			'src'    => array(),
			'class'  => array(),
			'width'  => array(),
			'height' => array(),
			'alt'    => array(),
		),
	);

	return $allowed_tag;

}

/**
 * Get args for old activities.
 *
 * @since   1.0.0
 *
 * @param   int         $year       Year
 * @param   array       $date       Date array
 * @param   bool/int    $per_page   Activities per page
 *
 * @return  array       Args array to get activities
 */
function bpm_activity_args( $year, $date, $per_page = false ) {

	$args = array(
		'per_page'   => $per_page,
		'date_query' => array(
			array(
				'year'  => $year,
				'month' => $date['mon'],
				'day'   => $date['mday'],
			),
		),
		'filter'     => array(
			'user_id' => bp_loggedin_user_id(),
		),
	);

	return $args;

}


/**
 * Returns activity memories.
 *
 * @since   1.1.0
 *
 * @param bool/int $per_page Activities per page
 *
 * @return array Activities array.
 */
function bpm_memories( $per_page = false ) {

	$memories = array();
	$date     = getdate();

	// checking for an older activity
	for ( $year = ( $date['year'] - 1 ); $year >= 2009; $year-- ) {

		// setting arguments to get BuddyPress activities
		$args = bpm_activity_args( $year, $date, $per_page );

		// get activities
		$activities = bp_activity_get( $args );

		// setting up memory array
		$memory = array(
			'year' => $year,
			'time' => sprintf( _n( '%d Year Ago Today', '%d Years Ago Today', ( $date['year'] - $year ), 'bp-memories' ), ( $date['year'] - $year ) ),
			'date' => date( 'D, M d, ' . $year, strtotime( $date['mday'] . '-' . $date['mon'] . '-' . $year ) ),
		);

		// checking if activities exists for today's date
		if ( ! empty( $activities['activities'] ) ) {

			$memory['memories'] = $activities['activities'];

			$memories[] = $memory;

			// break the loop if single memory being shown on activity page
			if ( 1 === $per_page ) {

				break;
			}
		} else {

			// get friendship created activity based on user ids, i.e., current logged in user id or friend's user id
			$all_friends = bpm_get_friendship_ids_for_user_by_date( $year, $per_page );

			if ( ! empty( $all_friends ) ) {

				// get activities
				$activities = bp_activity_get( array(
					'filter' => array(
						'action'     => 'friendship_created',
						'primary_id' => $all_friends[0]->id,
					),
				) );

				$memory['memories'] = $activities['activities'];

				$memories[] = $memory;

				// break the loop if single memory being shown on activity page
				if ( 1 === $per_page ) {

					break;
				}
			}
		}
	}

	return $memories;
}

/**
 * Get old activities.
 *
 * @since   1.0.0
 *
 * @param   bool/int    $per_page   Activities per page
 *
 * @return  array       Activities array.
 */
function bpm_activities( $per_page = false ) {

	$old_activities = array();
	$date       = getdate();

	// Checking for an older activity.
	for ( $i = ( $date['year'] - 1 ); $i >= 2009; $i-- ) {
		$args = bpm_activity_args( $i, $date, $per_page );

		// Get activities.
		$activities = bp_activity_get( $args );

		if ( ! empty( $activities['activities'] ) ) {
			$time_ago = sprintf( _n( '%d Year Ago Today', '%d Years Ago Today', ( $date['year'] - $i ), 'bp-memories' ), ( $date['year'] - $i ) );

			array_push( $old_activities, array(
				'year'       => $i,
				'time'       => $time_ago,
				'date'       => date( 'D, M d, ' . $i, strtotime( $date['mday'] . '-' . $date['mon'] . '-' . $i ) ),
				'activities' => $activities['activities'],
			) );

			if ( 1 === $per_page ) {
				break;
			}
		}
	}

	return $old_activities;

}

/**
 * Check if BuddyPress plugin is active.
 *
 * @since   1.0.0
 *
 * @return  bool    BuddyPress plugin flag.
 */
function is_buddypress_active() {

	// Detect plugin. For use on Front End only.
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	// check for plugin using plugin name
	if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) {
		return true;
	} else {
		return false;
	}

}


/**
 * Returns memory page link.
 *
 * @since 1.1.0
 *
 * @return false|mixed|string|void
 */
function bpm_get_memory_page_link() {

	$bp_pages = bp_get_option( 'bp-pages' );

	if ( ! empty( $bp_pages['memories'] ) ) {
		$memory_page = get_permalink( $bp_pages['memories'] );
	} else {
		$memory_page = get_permalink( get_option( 'bpm_memory_page' ) );
	}

	return $memory_page;
}


/**
 * Output the avatar of the user that performed the action.
 *
 * @since 1.1.0
 *
 * @param object $activity BuddyPress activity object
 */
function bpm_activity_avatar( $activity ) {

	$args        = bpm_get_avatar_args( $activity );
	$allowed_tag = bpm_activity_avatar_kses_tags();

	// output avatar of user
	echo wp_kses( bp_core_fetch_avatar( $args ), $allowed_tag );
}


/**
 * Output the action of the activity.
 *
 * @since 1.1.0
 *
 * @param object $activity BuddyPress activity object
 */
function bpm_activity_action( $activity ) {

	$allowed_tag = bpm_activity_action_kses_tags();
	$action      = $activity->action;

	// create custom action when activity is of type friendship_request
	if ( 'friendship_created' === $activity->type ) {

		$activity_user_id = $activity->user_id;
		$user_id          = bp_loggedin_user_id();

		// get $friend_id to create custom action
		if ( (int) $activity_user_id === (int) $user_id ) {

			$friend_id = $activity->secondary_item_id;

		} else {

			$friend_id = $activity_user_id;
		}

		// get friend's data
		$friend_data = get_userdata( $friend_id );

		$user_link   = bp_core_get_user_domain( $user_id );
		$friend_link = bp_core_get_user_domain( $friend_id );

		/* translators: Placeholders: %1$s - <a> tag, %2$s - </a> tag, %3$s - <a> tag */
		$action = sprintf( __( '%1$sYou%2$s and %3$s became friends', 'bp-memories' ),
			'<a href="' . $user_link . '">',
			'</a>',
			'<a href="' . $friend_link . '">' . $friend_data->display_name . '</a>' );
	}

	$action = wp_kses( $action, $allowed_tag );
	
	echo $action;
}


/**
 * Output the content of the activity.
 *
 * @since 1.1.0
 *
 * @param object $activity BuddyPress activity object
 */
function bpm_activity_content( $activity ) {

	$allowed_tags = bpm_activity_filter_kses();

	echo wp_kses( $activity->content, $allowed_tags );
}


/**
 * Get all friendship IDs for a user by year.
 *
 * @since 1.1.0
 *
 * @param int $year Year.
 *
 * @return array
 */
function bpm_get_friendship_ids_for_user_by_date( $year, $per_page = false ) {

	global $wpdb;

	$user_id = bp_loggedin_user_id();
	$bp      = buddypress();
	$sql     = "SELECT * FROM {$bp->friends->table_name} " .
			   "WHERE (initiator_user_id = %d OR friend_user_id = %d) " .
			   "AND is_confirmed = 1 " .
			   "AND YEAR(date_created) = '%s' AND MONTH(date_created) = '%s' AND DAYOFMONTH(date_created) = '%s' " .
			   "ORDER BY date_created DESC";

	if ( false !== $per_page ) {

		$sql .= " LIMIT {$per_page}";
	}

	$friendships = $wpdb->get_results( $wpdb->prepare( $sql, $user_id, $user_id, $year, date( 'm' ), date( 'd' ) ) );

	return $friendships;
}


/**
 * Check if memories are allowed on memory page.
 *
 * @since 1.1.0
 *
 * @return bool
 */
function bpm_is_memory_page_allowed() {

	// Checking if user is logged in and BuddyPress plugin is active.
	if ( is_user_logged_in() && is_buddypress_active() ) {

		return true;
	}

	return false;
}
