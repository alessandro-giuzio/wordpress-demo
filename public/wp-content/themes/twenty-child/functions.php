<?php
// Enqueue parent theme stylesheet in child theme
function twenty_child_enqueue_parent_style()
{
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'twenty_child_enqueue_parent_style');
