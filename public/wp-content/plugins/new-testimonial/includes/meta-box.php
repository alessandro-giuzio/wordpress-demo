<?php

function custom_fields_add_testimonial_meta_box()
{
add_meta_box(
'custom_fields_testimonial_meta_box', // Unique ID
'Testimonial Details', // Box title
'custom_fields_testimonial_meta_box_html', // Content callback
'testimonial' // Post type
);
}

function custom_fields_testimonial_meta_box_html($post)
{
  // Add security nonce
  wp_nonce_field('custom_fields_save_testimonial_meta', 'custom_fields_testimonial_nonce');

  // Get existing values
  $company = get_post_meta($post->ID, '_company', true);
  $name = get_post_meta($post->ID, '_name', true);
  $job = get_post_meta($post->ID, '_job', true);
  $rating = get_post_meta($post->ID, '_rating', true);

  // Display the fields
  ?>
    <div>
      <p>
        <label for="name">User Name:</label>
        <input type="text"
          id="name"
          name="name"
          value="<?php echo esc_attr($name); ?>"
          size="50" />
      </p>
      <p>
        <label for="company">Company Name:</label>
        <input type="text"
          id="company"
          name="company"
          value="<?php echo esc_attr($company); ?>"
          size="50" />
      </p>
      <p>
        <label for="job">Job:</label>
        <input type="text"
          id="job"
          name="job"
          value="<?php echo esc_attr($job); ?>"
          size="50" />
      </p>
      <p>
        <label for="rating">Rating (1-5):</label>
        <input type="number"
          id="rating"
          name="rating"
          value="<?php echo esc_attr($rating); ?>"
          min="1"
          max="5" />
      </p>
    </div>
  <?php
}

/**
 * Save the custom field values when a testimonial is saved.
 * This function runs when you save or update a testimonial post.
 */
function custom_fields_save_testimonial_meta($post_id)
{
  // Only run for 'testimonial' post type
  if (get_post_type($post_id) !== 'testimonial') {
    return;
  }

  // Security checks
  if (
    !isset($_POST['custom_fields_testimonial_nonce']) ||
    !wp_verify_nonce($_POST['custom_fields_testimonial_nonce'], 'custom_fields_save_testimonial_meta')
  ) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  // Save the name field if present
  if (isset($_POST['name'])) {
    $name = sanitize_text_field($_POST['name']);
    update_post_meta($post_id, '_name', $name);
  }

  // Save the company field if present
  if (isset($_POST['company'])) {
    $company = sanitize_text_field($_POST['company']);
    update_post_meta($post_id, '_company', $company);
  }
  // Save the job field if present
  if (isset($_POST['job'])) {
    $job = sanitize_text_field($_POST['job']);
    update_post_meta($post_id, '_job', $job);
  }
  // Save the rating field if present
  if (isset($_POST['rating'])) {
    $rating = intval($_POST['rating']);
    update_post_meta($post_id, '_rating', $rating);
  }
}
add_action('save_post', 'custom_fields_save_testimonial_meta');

add_action('add_meta_boxes', 'custom_fields_add_testimonial_meta_box');
