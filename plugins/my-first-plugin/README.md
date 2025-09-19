# My First Plugin

A comprehensive WordPress plugin example designed for learning plugin development.

## Features

This plugin demonstrates:

- **Plugin Structure**: Proper file organization and plugin header
- **WordPress Hooks**: Actions and filters
- **Enqueuing Assets**: CSS and JavaScript files
- **Shortcodes**: Custom shortcode implementation
- **Admin Interface**: Settings page in WordPress admin
- **AJAX Functionality**: Frontend and backend AJAX handling
- **Database Options**: Storing and retrieving plugin settings
- **Security**: Nonce verification and data sanitization
- **Plugin Lifecycle**: Activation, deactivation, and uninstall hooks

## Installation

1. Copy this plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the WordPress admin
3. Configure settings under Settings > My First Plugin

## Usage

### Shortcode

Use the `[hello_world]` shortcode in posts or pages:

```
[hello_world]
[hello_world name="WordPress"]
```

### Admin Features

- Visit Settings > My First Plugin to configure the plugin
- Test AJAX functionality from the admin page
- View plugin signature on single posts

## Learning Points

### 1. Plugin Header
The plugin header at the top of the main PHP file tells WordPress about your plugin.

### 2. Security Best Practices
- Always use `defined('ABSPATH')` check to prevent direct access
- Use nonces for AJAX requests
- Sanitize and escape all user input

### 3. WordPress Hooks
- `init`: Plugin initialization
- `wp_enqueue_scripts`: Load CSS/JS files
- `wp_head`: Add content to HTML head
- `admin_menu`: Add admin menu items

### 4. Plugin Lifecycle
- Activation: Run code when plugin is activated
- Deactivation: Clean up when deactivated
- Uninstall: Remove all plugin data when deleted

### 5. AJAX in WordPress
- Register AJAX actions for logged-in and non-logged-in users
- Use wp_localize_script to pass data to JavaScript
- Always verify nonces for security

## File Structure

```
my-first-plugin/
├── my-first-plugin.php    # Main plugin file
├── README.md              # This documentation
└── assets/
    ├── style.css          # Plugin styles
    └── script.js          # Plugin JavaScript
```

## Next Steps

To extend this plugin, try:

1. Adding custom post types
2. Creating custom meta boxes
3. Implementing REST API endpoints
4. Adding widget functionality
5. Creating custom database tables