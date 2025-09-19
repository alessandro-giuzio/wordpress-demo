<?php
/*
Plugin Name: Schedule Plugin
Description: A plugin to manage schedules.
Version: 1.0
Author: Alessandro Giuzio
*/

// Add a message at the end of every post
function ag_schedule_message($content)
{
  if (is_singular('post')) {
    $content .= '<p><strong>📅 Schedule: New updates coming soon!</strong></p>';
  }
  return $content;
}
add_filter('the_content', 'ag_schedule_message');

// Activation / Deactivation
function ag_schedule_activate()
{
  error_log('✅ Schedule Plugin Activated');
}
function ag_schedule_deactivate()
{
  error_log('🛑 Schedule Plugin Deactivated');
}
register_activation_hook(__FILE__, 'ag_schedule_activate');
register_deactivation_hook(__FILE__, 'ag_schedule_deactivate');
