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


// Register Custom Post Type
function custom_post_type()
{

  $labels = array(
    'name'                  => _x('Testimonials', 'Post Type General Name', 'text_domain'),
    'singular_name'         => _x('Testimonial', 'Post Type Singular Name', 'text_domain'),
    'menu_name'             => __('Testimonials', 'text_domain'),
    'name_admin_bar'        => __('Post Type', 'text_domain'),
    'archives'              => __('Item Archives', 'text_domain'),
    'attributes'            => __('Item Attributes', 'text_domain'),
    'parent_item_colon'     => __('Parent Item:', 'text_domain'),
    'all_items'             => __('All Items', 'text_domain'),
    'add_new_item'          => __('Add New Item', 'text_domain'),
    'add_new'               => __('Add New', 'text_domain'),
    'new_item'              => __('New Item', 'text_domain'),
    'edit_item'             => __('Edit Item', 'text_domain'),
    'update_item'           => __('Update Item', 'text_domain'),
    'view_item'             => __('View Item', 'text_domain'),
    'view_items'            => __('View Items', 'text_domain'),
    'search_items'          => __('Search Item', 'text_domain'),
    'not_found'             => __('Not found', 'text_domain'),
    'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
    'featured_image'        => __('Featured Image', 'text_domain'),
    'set_featured_image'    => __('Set featured image', 'text_domain'),
    'remove_featured_image' => __('Remove featured image', 'text_domain'),
    'use_featured_image'    => __('Use as featured image', 'text_domain'),
    'insert_into_item'      => __('Insert into item', 'text_domain'),
    'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
    'items_list'            => __('Items list', 'text_domain'),
    'items_list_navigation' => __('Items list navigation', 'text_domain'),
    'filter_items_list'     => __('Filter items list', 'text_domain'),
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
// meta box for company name
function add_company_meta_box()
{
  add_meta_box(
    'company_meta_box',          // Unique ID
    'Company',                   // Box title
    'company_meta_box_html',     // Content callback, must be of type callable
    'testimonial'                // Post type
  );
}
// Add the meta box
add_action('add_meta_boxes', 'add_company_meta_box');
function company_meta_box_html($post)
{
  // Add security nonce
  wp_nonce_field('save_company_meta', 'company_nonce');

  // Get existing value
  $company = get_post_meta($post->ID, '_company', true);

  // Display the field
?>
  <p>
    <label for="company">Company Name:</label><br>
    <input type="text"
      id="company"
      name="company"
      value="<?php echo esc_attr($company); ?>"
      size="50" />
  </p>
<?php
}

// Save the company field when the post is saved
function save_company_meta($post_id)
{
  // Security checks
  if (
    !isset($_POST['company_nonce']) ||
    !wp_verify_nonce($_POST['company_nonce'], 'save_company_meta')
  ) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  // Save the company field
  if (isset($_POST['company'])) {
    $company = sanitize_text_field($_POST['company']);
    update_post_meta($post_id, '_company', $company);
  }
}
add_action('save_post', 'save_company_meta');


// meta box for name
function add_name_meta_box()
{
  add_meta_box(
    'name_meta_box',          // Unique ID
    'Name',                   // Box title
    'name_meta_box_html',     // Content callback, must be of type callable
    'testimonial'                // Post type
  );
}
// Add the meta box
add_action('add_meta_boxes', 'add_name_meta_box');

function name_meta_box_html($post)
{
  $name = get_post_meta($post->ID, '_name', true);
}
  // Display the field