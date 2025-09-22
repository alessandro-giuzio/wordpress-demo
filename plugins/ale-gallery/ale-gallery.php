<?php

/**
 * Plugin Name: Gallery Plugin
 * Plugin URI:  https://example.com/ale-gallery
 * Author:      Alessandro Giuzio
 * Author URI:  Plugin Author Link
 * Description: This plugin does wonders
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: prefix-plugin-name
 */

// Functions
function pluginprefix_activate()
{
  error_log('✅ Gallery Plugin Activated');
}

function pluginprefix_deactivate()
{
  error_log('🛑 Gallery Plugin Deactivated');
}

// Activation
register_activation_hook(__FILE__, 'pluginprefix_activate');
// Deactivation
register_deactivation_hook(
  __FILE__,
  'pluginprefix_deactivate'
);
