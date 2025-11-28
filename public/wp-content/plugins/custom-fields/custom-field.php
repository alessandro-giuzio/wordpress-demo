<?php
/*
* Plugin Name: Custom Fields
* Description: A plugin to add custom fields to posts and pages.
* Version: 1.0

*/

// Register plugin activation hook
register_activation_hook(__FILE__, 'custom_fields_activate');


// Register REST API route for testimonials
add_action('rest_api_init', function () {
  // Route for all testimonials
  register_rest_route('myplugin/v1', '/testimonials/', array(
    'methods'  => 'GET',
    'callback' => 'myplugin_get_testimonials',
  ));
  // Route for a single testimonial by ID
  register_rest_route('myplugin/v1', '/testimonials/(?P<id>\\d+)', array(
    'methods'  => 'GET',
    'callback' => 'myplugin_get_single_testimonial',
  ));
});
// Callback function to get a single testimonial by ID
function myplugin_get_single_testimonial(WP_REST_Request $request)
{
  $post_id = $request['id'];
  $post = get_post($post_id);
  if (!$post || $post->post_type !== 'testimonial' || $post->post_status !== 'publish') {
    return new WP_Error('not_found', 'Testimonial not found', array('status' => 404));
  }
  return array(
    'id'      => $post->ID,
    'title'   => get_the_title($post->ID),
    'content' => apply_filters('the_content', $post->post_content),
    'name'    => get_post_meta($post->ID, '_name', true),
    'company' => get_post_meta($post->ID, '_company', true),
    'job'     => get_post_meta($post->ID, '_job', true),
    'rating'  => get_post_meta($post->ID, '_rating', true),
  );
}
// Callback function to get testimonials
function myplugin_get_testimonials(WP_REST_Request $request)
{
  $args = array(
    'post_type'      => 'testimonial',
    'posts_per_page' => -1,
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

function get_testimonial_custom_fields($data)
{
  $post_id = $data['id'];
  return array(
    'name'    => get_post_meta($post_id, '_name', true),
    'company' => get_post_meta($post_id, '_company', true),
    'job'     => get_post_meta($post_id, '_job', true),
    'rating'  => get_post_meta($post_id, '_rating', true),
  );
}

/**
 * Runs when plugin is activated.
 * You can use this to set up options or do other setup tasks.
 */
function custom_fields_activate()
{
  // Add a welcome message that shows once
  add_option('custom_fields_show_welcome', true);
}

/**
 * Register the 'testimonial' custom post type.
 * This makes a new post type available in WordPress admin.
 */
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

/**
 * Add a meta box for custom testimonial fields.
 * This box will appear on the testimonial edit screen.
 */
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

/**
 * Render the meta box HTML for custom fields.
 * This function outputs the form fields for name and company.
 */
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

/**
 *  Custom admin CSS for the meta box
 */
function custom_fields_admin_styles($hook)
{
  global $post;
  // Only load on testimonial post edit screen
  if ($hook === 'post.php' || $hook === 'post-new.php') {
    if (isset($post) && $post->post_type === 'testimonial') {
      wp_enqueue_style(
        'custom-fields-admin-style',
        plugin_dir_url(__FILE__) . 'admin-style.css'
      );
    }
  }
}
add_action('admin_enqueue_scripts', 'custom_fields_admin_styles');

// Shortcode to display a form to upload images
add_shortcode('custom_image_upload_form', 'custom_image_upload_form_shortcode');

// Shortcode callback function
function custom_image_upload_form_shortcode()
{
  // Start the output buffering
  ob_start();

  // Form HTML and processing logic
  echo "<form method='post' enctype='multipart/form-data'>";
  echo "<label for='custom_image'>Upload an Image:</label>";
  echo "<input type='file' name='custom_image' />";
  echo "<input type='submit' value='Upload Image' />";
  echo "</form>";
  // Return the HTML
  return ob_get_clean();
}
