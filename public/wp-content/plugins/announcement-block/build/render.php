<?php
// Exit if accessed directly outside of WordPress
if (! defined('ABSPATH')) exit;

// Determine if the announcement should be shown (default: true)
$show = isset($attributes['show']) ? $attributes['show'] : true;

// Get the date/time after which the announcement should be hidden (if set)
$hide_after_date_time = isset($attributes['hideAfterDateTime']) ? $attributes['hideAfterDateTime'] : '';

// Get the date/time from which the announcement should be shown (if set)
$show_from_date_time = isset($attributes['showFromDateTime']) ? $attributes['showFromDateTime'] : '';

// Get the current time in MySQL datetime format (e.g., '2025-11-28 12:34:56')
$current_time = current_time('mysql');

// Display the announcement if:
// - $show is true
// - AND (no hide_after_date_time is set OR current time is before hide_after_date_time)
// - AND (no show_from_date_time is set OR current time is after or equal to show_from_date_time)
if (
	$show &&
	(empty($hide_after_date_time) || strtotime($current_time) < strtotime($hide_after_date_time)) &&
	(empty($show_from_date_time) || strtotime($current_time) >= strtotime($show_from_date_time))
) {
	// Output the announcement content inside a <div>, escaping it for safe HTML output
	echo sprintf(
		'<div>%s</div>',
		wp_kses_post($content)
	);
}
