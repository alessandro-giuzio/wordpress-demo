# WordPress Plugin Development Learning Guide

Welcome to WordPress plugin development! This guide will walk you through the fundamentals of creating WordPress plugins using this development environment.

## 🎯 Learning Objectives

By the end of this guide, you'll understand:
- WordPress plugin structure and organization
- Essential WordPress hooks and filters
- Plugin security best practices
- AJAX implementation in WordPress
- Database operations and options API
- Admin interface development

## 📚 Lesson 1: Understanding Plugin Structure

### Plugin Header
Every WordPress plugin starts with a header comment:

```php
<?php
/**
 * Plugin Name: Your Plugin Name
 * Description: What your plugin does
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: your-plugin-textdomain
 */
```

### Security First
Always prevent direct access:

```php
if (!defined('ABSPATH')) {
    exit;
}
```

### Plugin Constants
Define useful constants:

```php
define('YOUR_PLUGIN_URL', plugin_dir_url(__FILE__));
define('YOUR_PLUGIN_PATH', plugin_dir_path(__FILE__));
```

## 📚 Lesson 2: WordPress Hooks System

WordPress uses hooks to allow plugins to modify behavior without changing core files.

### Actions (add_action)
Actions let you add functionality at specific points:

```php
// Run code when WordPress initializes
add_action('init', 'your_init_function');

// Add CSS/JS files
add_action('wp_enqueue_scripts', 'your_enqueue_function');

// Add admin menu items
add_action('admin_menu', 'your_menu_function');
```

### Filters (add_filter)  
Filters let you modify data:

```php
// Modify post content
add_filter('the_content', 'your_content_filter');

// Modify page titles
add_filter('the_title', 'your_title_filter');
```

### Common Hook Examples

```php
// Run when plugin is activated
register_activation_hook(__FILE__, 'your_activation_function');

// Run when plugin is deactivated
register_deactivation_hook(__FILE__, 'your_deactivation_function');

// Add custom post types
add_action('init', 'register_custom_post_types');

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', 'enqueue_plugin_assets');
```

## 📚 Lesson 3: Enqueuing Assets

WordPress has a proper way to include CSS and JavaScript:

```php
function enqueue_plugin_assets() {
    // Enqueue CSS
    wp_enqueue_style(
        'your-plugin-style',           // Handle (unique identifier)
        plugin_dir_url(__FILE__) . 'assets/style.css',  // URL
        array(),                       // Dependencies
        '1.0.0'                       // Version
    );
    
    // Enqueue JavaScript
    wp_enqueue_script(
        'your-plugin-script',          // Handle
        plugin_dir_url(__FILE__) . 'assets/script.js',  // URL
        array('jquery'),               // Dependencies
        '1.0.0',                      // Version
        true                          // Load in footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_plugin_assets');
```

## 📚 Lesson 4: Shortcodes

Shortcodes allow users to add plugin functionality to posts and pages:

```php
// Register shortcode
add_shortcode('your_shortcode', 'your_shortcode_function');

function your_shortcode_function($atts) {
    // Parse attributes with defaults
    $atts = shortcode_atts(array(
        'name' => 'World',
        'color' => 'blue'
    ), $atts);
    
    // Always escape output
    $output = '<div style="color: ' . esc_attr($atts['color']) . '">';
    $output .= 'Hello, ' . esc_html($atts['name']) . '!';
    $output .= '</div>';
    
    return $output;
}
```

Usage: `[your_shortcode name="WordPress" color="red"]`

## 📚 Lesson 5: Admin Interface

### Adding Admin Menu Items

```php
add_action('admin_menu', 'add_plugin_admin_menu');

function add_plugin_admin_menu() {
    add_options_page(
        'Plugin Settings',        // Page title
        'My Plugin',             // Menu title
        'manage_options',        // Capability required
        'my-plugin-settings',    // Menu slug
        'plugin_settings_page'   // Callback function
    );
}

function plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>My Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('my_plugin_settings');
            do_settings_sections('my_plugin_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
```

### WordPress Options API

```php
// Save a setting
update_option('my_plugin_setting', 'value');

// Get a setting
$value = get_option('my_plugin_setting', 'default_value');

// Delete a setting
delete_option('my_plugin_setting');
```

## 📚 Lesson 6: AJAX in WordPress

### Backend (PHP)

```php
// Hook for logged-in users
add_action('wp_ajax_my_ajax_action', 'handle_ajax_request');

// Hook for non-logged-in users
add_action('wp_ajax_nopriv_my_ajax_action', 'handle_ajax_request');

function handle_ajax_request() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    // Process request
    $response = array(
        'success' => true,
        'message' => 'AJAX request successful!'
    );
    
    // Send JSON response
    wp_send_json($response);
}
```

### Frontend (JavaScript)

```javascript
jQuery(document).ready(function($) {
    $('#my-button').on('click', function() {
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'my_ajax_action',
                nonce: my_ajax_object.nonce
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                }
            }
        });
    });
});
```

### Passing Data to JavaScript

```php
function enqueue_scripts() {
    wp_enqueue_script('my-script', 'path/to/script.js', array('jquery'));
    
    wp_localize_script('my-script', 'my_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my_ajax_nonce')
    ));
}
```

## 📚 Lesson 7: Security Best Practices

### 1. Nonces (Numbers Used Once)
Protect against CSRF attacks:

```php
// Create nonce
$nonce = wp_create_nonce('my_action_nonce');

// Verify nonce
if (!wp_verify_nonce($_POST['nonce'], 'my_action_nonce')) {
    wp_die('Security check failed');
}
```

### 2. Sanitize Input
Always clean user input:

```php
$email = sanitize_email($_POST['email']);
$text = sanitize_text_field($_POST['text']);
$url = esc_url_raw($_POST['url']);
```

### 3. Escape Output
Always escape data before displaying:

```php
echo esc_html($user_input);           // HTML content
echo esc_attr($attribute_value);      // HTML attributes
echo esc_url($url);                   // URLs
```

### 4. Check User Capabilities

```php
if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}
```

## 🛠 Practical Exercises

### Exercise 1: Create a Simple Plugin
1. Create a new plugin folder in `plugins/`
2. Add a basic plugin header
3. Create a function that displays "Hello World" on the frontend
4. Hook it to `wp_footer`

### Exercise 2: Add a Shortcode
1. Create a shortcode that displays the current date
2. Allow users to format the date with attributes
3. Test it in a post or page

### Exercise 3: Create an Admin Page
1. Add a menu item to the WordPress admin
2. Create a settings page with a form
3. Save and retrieve the settings using the Options API

### Exercise 4: Add AJAX Functionality
1. Create a button that makes an AJAX request
2. Handle the request in PHP
3. Display the response on the page

## 🔍 Debugging Tips

### 1. Enable WordPress Debug Mode
Add to wp-config.php:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### 2. Use error_log() for Debugging
```php
error_log('Debug message: ' . print_r($variable, true));
```

### 3. Browser Developer Tools
- Console: View JavaScript errors and debug output
- Network: Monitor AJAX requests
- Elements: Inspect HTML and CSS

## 📖 Additional Resources

- [WordPress Plugin Developer Handbook](https://developer.wordpress.org/plugins/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [WordPress Hook Reference](https://developer.wordpress.org/reference/hooks/)
- [WordPress Function Reference](https://developer.wordpress.org/reference/)

## 🎯 Next Steps

1. Study the example plugin in `plugins/my-first-plugin/`
2. Try modifying the example plugin
3. Create your own plugin from scratch
4. Join the WordPress community forums
5. Contribute to open-source WordPress plugins

Happy coding! 🚀