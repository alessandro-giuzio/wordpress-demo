<?php
// Enqueue parent theme stylesheet in child theme
function twenty_child_enqueue_parent_style()
{
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'twenty_child_enqueue_parent_style');


// Register REST API route for testimonials
add_action('rest_api_init', function () {
  register_rest_route('myplugin/v1', '/testimonials/', array(
    'methods'  => 'GET',
    'callback' => 'myplugin_get_testimonials',
  ));
});
// Callback function to get testimonials
function myplugin_get_testimonials(WP_REST_Request $request)
{
  $args = array(
    'post_type'      => 'testimonial',
    'posts_per_page' => 10,
    'post_status'    => 'publish',
  );
  $query = new WP_Query($args);
  $data = array();

  foreach ($query->posts as $post) {
    $data[] = array(
      'id'      => $post->ID,
      'title'   => get_the_title($post->ID),
      'content' => apply_filters('the_content', $post->post_content),
      'name'    => get_post_meta($post->ID, '_name', true),
      'company' => get_post_meta($post->ID, '_company', true),
      'job'     => get_post_meta($post->ID, '_job', true),
    );
  }
  return $data;
}
