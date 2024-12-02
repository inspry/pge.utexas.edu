<?php
/**
 * Plugin Name: PGE: Event Deletion
 * Description: Creates a WP cron that will run daily and remove events where the date has already passed
 * Version: 1.0
 * Author: Inspry
 * Author URI: https://inspry.com/
 */

/**
 * Standard WP check if direct
 */
if ( ! function_exists( 'add_action' ) ) {
	exit();
}

if (!function_exists('pge_event_deletion_run')) {
	/**
	 * Function to loop through the events and remove the ones that have a date passed today.
	 */
	function pge_event_deletion_run() {
		// Get today's date.
		$date_now = strtotime( 'now' );
	
		// Get the events. Only get events in "university event" tag.
		$events = get_posts(
			array(
				'numberposts' => -1,
				'post_type'   => 'event',
				'post_status' => 'publish',
				'tax_query'   => array(
					array(
						'taxonomy' => 'event-type',
						'field'    => 'slug',
						'terms'    => array( 'university-event' ),
						'operator' => 'IN',
					),
				),
			)
		);
	
		// Make sure the events arrat is not empty.
		if ( ! empty( $events ) ) {
			// Loop through the events.
			foreach ( $events as $event ) {
				// Get the date of this event.
				$event_date = get_field( 'date', $event->ID, true );
				$event_date = strtotime( $event_date );
	
				// Check if the event has passed.
				if ( $date_now > $event_date ) {
					// Move this event to the trash.
					wp_trash_post( $event->ID );
				}
			}
		}
	}
	add_action( 'pge_event_deletion', 'pge_event_deletion_run' );
}

if (!function_exists('pge_event_deletion_schedule_cron')) {
	/**
	 * Schedule the cron to run once daily.
	 */
	function pge_event_deletion_schedule_cron() {
		if ( ! wp_next_scheduled( 'pge_event_deletion' ) ) {
			wp_schedule_event( time(), 'daily', 'pge_event_deletion' );
		}
	}
	add_action( 'wp', 'pge_event_deletion_schedule_cron' );
}

add_action('wp_footer', function() {
	echo '<!-- production plugin pge-event-deletion.php -->';
});
