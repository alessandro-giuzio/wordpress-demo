<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://example.net
 * @since             1.0.0
 * @package           New_Testimonial
 *
 * @wordpress-plugin
 * Plugin Name:       New-Testimonial
 * Plugin URI:        https://example.com
 * Description:       Plugin short description
 * Version:           1.0.0
 * Author:            Alessandro Giuzio
 * Author URI:        https://example.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       new-testimonial
 * Domain Path:       /languages
 */

// Include the Post Types file
require_once plugin_dir_path( __FILE__ ) . 'includes/post-type.php';

// Include the Shortcodes file
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';
// Register shortcodes
new New_Testimonial_Shortcodes();

// Include the Meta Box file
require_once plugin_dir_path( __FILE__ ) . 'includes/meta-box.php';

// Include the REST API file
require_once plugin_dir_path( __FILE__ ) . 'includes/rest-api.php';


// Include the Admin CSS file
require_once plugin_dir_path( __FILE__ ) . 'includes/admin-css.php';

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NEW_TESTIMONIAL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-new-testimonial-activator.php
 */
function activate_new_testimonial() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-new-testimonial-activator.php';
	New_Testimonial_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-new-testimonial-deactivator.php
 */
function deactivate_new_testimonial() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-new-testimonial-deactivator.php';
	New_Testimonial_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_new_testimonial' );
register_deactivation_hook( __FILE__, 'deactivate_new_testimonial' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-new-testimonial.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_new_testimonial() {

	$plugin = new New_Testimonial();
	$plugin->run();

}
run_new_testimonial();
