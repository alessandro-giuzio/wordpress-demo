<?php
/**
 * Plugin Name: My First Plugin
 * Description: A simple WordPress plugin for learning plugin development.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: my-first-plugin
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('MY_FIRST_PLUGIN_URL', plugin_dir_url(__FILE__));
define('MY_FIRST_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Main plugin class
 */
class MyFirstPlugin {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
    }
    
    /**
     * Initialize the plugin
     */
    public function init() {
        // Add hooks and filters here
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_head', array($this, 'add_meta_tags'));
        add_filter('the_content', array($this, 'add_signature_to_posts'));
        add_shortcode('hello_world', array($this, 'hello_world_shortcode'));
        
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Add AJAX handlers
        add_action('wp_ajax_my_first_ajax_action', array($this, 'handle_ajax_request'));
        add_action('wp_ajax_nopriv_my_first_ajax_action', array($this, 'handle_ajax_request'));
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'my-first-plugin-js',
            MY_FIRST_PLUGIN_URL . 'assets/script.js',
            array('jquery'),
            '1.0.0',
            true
        );
        
        wp_enqueue_style(
            'my-first-plugin-css',
            MY_FIRST_PLUGIN_URL . 'assets/style.css',
            array(),
            '1.0.0'
        );
        
        // Localize script for AJAX
        wp_localize_script('my-first-plugin-js', 'my_first_plugin_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_first_plugin_nonce')
        ));
    }
    
    /**
     * Add meta tags to head
     */
    public function add_meta_tags() {
        echo '<meta name="my-first-plugin" content="active" />' . "\n";
    }
    
    /**
     * Add signature to post content
     */
    public function add_signature_to_posts($content) {
        if (is_single() && is_main_query()) {
            $signature = '<p><em>Posted with My First Plugin</em></p>';
            $content .= $signature;
        }
        return $content;
    }
    
    /**
     * Hello World shortcode
     */
    public function hello_world_shortcode($atts) {
        $atts = shortcode_atts(array(
            'name' => 'World'
        ), $atts);
        
        return '<div class="hello-world-shortcode">Hello, ' . esc_html($atts['name']) . '!</div>';
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            'My First Plugin Settings',
            'My First Plugin',
            'manage_options',
            'my-first-plugin',
            array($this, 'admin_page')
        );
    }
    
    /**
     * Admin page content
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>My First Plugin Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('my_first_plugin_settings');
                do_settings_sections('my_first_plugin_settings');
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">Sample Setting</th>
                        <td>
                            <input type="text" name="my_first_plugin_sample_setting" 
                                   value="<?php echo esc_attr(get_option('my_first_plugin_sample_setting')); ?>" />
                            <p class="description">This is a sample setting for learning purposes.</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
            
            <h2>Test AJAX</h2>
            <button id="test-ajax-button" class="button">Test AJAX Request</button>
            <div id="ajax-response"></div>
        </div>
        <?php
    }
    
    /**
     * Handle AJAX request
     */
    public function handle_ajax_request() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'my_first_plugin_nonce')) {
            wp_die('Security check failed');
        }
        
        $response = array(
            'success' => true,
            'message' => 'AJAX request successful!',
            'timestamp' => current_time('mysql')
        );
        
        wp_send_json($response);
    }
}

// Initialize the plugin
new MyFirstPlugin();

/**
 * Activation hook
 */
function my_first_plugin_activate() {
    // Code to run on plugin activation
    add_option('my_first_plugin_sample_setting', 'Default value');
}
register_activation_hook(__FILE__, 'my_first_plugin_activate');

/**
 * Deactivation hook
 */
function my_first_plugin_deactivate() {
    // Code to run on plugin deactivation
    // Don't delete options here, do it in uninstall hook
}
register_deactivation_hook(__FILE__, 'my_first_plugin_deactivate');

/**
 * Uninstall hook
 */
function my_first_plugin_uninstall() {
    // Code to run on plugin uninstall
    delete_option('my_first_plugin_sample_setting');
}
register_uninstall_hook(__FILE__, 'my_first_plugin_uninstall');