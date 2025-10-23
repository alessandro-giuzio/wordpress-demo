<?php
/*
* Plugin Name: Custom Fields
* Description: A plugin to add custom fields to posts and pages.
* Version: 1.0

*/

register_activation_hook(__FILE__, 'custom_fields_activate');

// Activation function
function custom_fields_activate()
{
  // Add a welcome message that shows once
  add_option('custom_fields_show_welcome', true);
}
// Deactivation function
register_deactivation_hook(
  __FILE__,
  'pluginprefix_function_to_run'
);

// Deactivation function
function pluginprefix_function_to_run()
{
  // Clean up plugin options or settings if needed
  delete_option('custom_fields_show_welcome');
}

// Deactivation function
function custom_fields_deactivate()
{
  // Remove the welcome message option
  delete_option('custom_fields_show_welcome');
}

// Register new post type
function register_testimonial_post_type()
{
  register_post_type('testimonials', array(
    'labels' => array(
      'name' => 'Testimonials',
      'singular_name' => 'Testimonial'
    ),
    'public' => true,
    'has_archive' => true,
    'supports' => array('title', 'editor', 'custom-fields')
  ));
}
