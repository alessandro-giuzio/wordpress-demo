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

// Register Custom Post Type
function custom_post_type()
{
  $labels = array(
    'name'                  => _x('Testimonials', 'Post Type General Name', 'text_domain'),
    'singular_name'         => _x('Testimonial', 'Post Type Singular Name', 'text_domain'),
    'menu_name'             => __('Testimonials', 'text_domain'),
    'name_admin_bar'        => __('Testimonial', 'text_domain'),
    'archives'              => __('Testimonial Archives', 'text_domain'),
    'attributes'            => __('Testimonial Attributes', 'text_domain'),
    'parent_item_colon'     => __('Parent Testimonial:', 'text_domain'),
    'all_items'             => __('All Testimonials', 'text_domain'),
    'add_new_item'          => __('Add New Testimonial', 'text_domain'),
    'add_new'               => __('Add New', 'text_domain'),
    'new_item'              => __('New Testimonial', 'text_domain'),
    'edit_item'             => __('Edit Testimonial', 'text_domain'),
    'update_item'           => __('Update Testimonial', 'text_domain'),
    'view_item'             => __('View Testimonial', 'text_domain'),
    'view_items'            => __('View Testimonials', 'text_domain'),
    'search_items'          => __('Search Testimonials', 'text_domain'),
    'not_found'             => __('No testimonials found', 'text_domain'),
    'not_found_in_trash'    => __('No testimonials found in Trash', 'text_domain'),
    'featured_image'        => __('Featured Image', 'text_domain'),
    'set_featured_image'    => __('Set featured image', 'text_domain'),
    'remove_featured_image' => __('Remove featured image', 'text_domain'),
    'use_featured_image'    => __('Use as featured image', 'text_domain'),
    'insert_into_item'      => __('Insert into testimonial', 'text_domain'),
    'uploaded_to_this_item' => __('Uploaded to this testimonial', 'text_domain'),
    'items_list'            => __('Testimonials list', 'text_domain'),
    'items_list_navigation' => __('Testimonials list navigation', 'text_domain'),
    'filter_items_list'     => __('Filter testimonials list', 'text_domain'),
  );
  $args = array(
    'label'                 => __('Testimonial', 'text_domain'),
    'description'           => __('Post Type Description', 'text_domain'),
    'labels'                => $labels,
    'supports'              => array('title', 'editor', 'thumbnail'),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => true,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    'show_in_rest'          => true,
  );
  register_post_type('testimonial', $args);
}
add_action('init', 'custom_post_type', 0);

// One meta box for both fields
function custom_fields_add_testimonial_meta_box()
{
  add_meta_box(
    'custom_fields_testimonial_meta_box', // Unique ID
    'Testimonial Details',                // Box title
    'custom_fields_testimonial_meta_box_html', // Content callback
    'testimonial'                         // Post type
  );
}
add_action('add_meta_boxes', 'custom_fields_add_testimonial_meta_box');

// Render both fields in one meta box
function custom_fields_testimonial_meta_box_html($post)
{
  // Add security nonce
  wp_nonce_field('custom_fields_save_testimonial_meta', 'custom_fields_testimonial_nonce');

  // Get existing values
  $company = get_post_meta($post->ID, '_company', true);
  $name = get_post_meta($post->ID, '_name', true);

  // Display the fields
?>
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
<?php
}

// Save both fields when the post is saved
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
}
add_action('save_post', 'custom_fields_save_testimonial_meta');
