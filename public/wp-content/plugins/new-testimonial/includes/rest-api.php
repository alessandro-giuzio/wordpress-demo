<?php

add_action('rest_api_init', function () {
  register_rest_route('myplugin/v1', '/testimonials/', array(
    'methods' => 'GET',
    'callback' => 'myplugin_get_testimonials',
  ));
  register_rest_route('myplugin/v1', '/testimonials/(?P<id>\\d+)', array(
    'methods' => 'GET',
    'callback' => 'myplugin_get_single_testimonial',
  ));
});
// Callback function to get testimonials
function myplugin_get_testimonials(WP_REST_Request $request)
{
  $args = array(
    'post_type' => 'testimonial',
    'posts_per_page' => -1,
    'post_status' => 'publish',
  );
  $query = new WP_Query($args);
  $data = array();

  foreach ($query->posts as $post) {
    $data[] = array(
      'id' => $post->ID,
      'title' => get_the_title($post->ID),
      'content' => apply_filters('the_content', $post->post_content),
      'name' => get_post_meta($post->ID, '_name', true),
      'company' => get_post_meta($post->ID, '_company', true),
      'job' => get_post_meta($post->ID, '_job', true),
    );
  }
  return $data;
}
// Callback function to get a single testimonial by ID
function myplugin_get_single_testimonial(WP_REST_Request $request)
{
  $post_id = $request['id'];
  $post = get_post($post_id);
  if (!$post || $post->post_type !== 'testimonial' || $post->post_status !== 'publish') {
    return new WP_Error('not_found', 'Testimonial not found', array('status' => 404));
  }
  return array(
    'id' => $post->ID,
    'title' => get_the_title($post->ID),
    'content' => apply_filters('the_content', $post->post_content),
    'name' => get_post_meta($post->ID, '_name', true),
    'company' => get_post_meta($post->ID, '_company', true),
    'job' => get_post_meta($post->ID, '_job', true),
    'rating' => get_post_meta($post->ID, '_rating', true),
  );
}
