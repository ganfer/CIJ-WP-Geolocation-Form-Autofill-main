<?php
/**
 * Plugin Name: CI-J Geolocation Form Autofill
 * Description: A plugin to prefill Dynamics Customer Insights - Journeys forms using geolocation.
 * Version: 1.0
 * Author: Ferdinand Ganter
 * Author URI: https://fganter.de
 * Text Domain: geolocation-form-autofill
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Define constants
define('GEOLOCATION_FORM_AUTOFILL_PATH', plugin_dir_path(__FILE__));
define('GEOLOCATION_FORM_AUTOFILL_URL', plugin_dir_url(__FILE__));

// Load required files
require_once GEOLOCATION_FORM_AUTOFILL_PATH . 'includes/admin-settings.php';
require_once GEOLOCATION_FORM_AUTOFILL_PATH . 'includes/scripts.php';

// Initialize the main plugin class
new GeolocationFormAutofillPlugin();

// Add Settings link on the Plugins page
function gf_autofill_settings_link($links) {
    $settings_link = '<a href="admin.php?page=geolocation-form-autofill">' . __('Settings', 'geolocation-form-autofill') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'gf_autofill_settings_link');

// Add additional links below the plugin description
function gf_autofill_plugin_meta_links($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $links[] = '<a href="https://github.com/ganfer/CIJ-WP-Geolocation-Form-Autofill" target="_blank">' . __('View Details', 'geolocation-form-autofill') . '</a>';
    }
    return $links;
}
add_filter('plugin_row_meta', 'gf_autofill_plugin_meta_links', 10, 2);

// Load text domain for translations
function gf_autofill_load_textdomain() {
    load_plugin_textdomain('geolocation-form-autofill', false, basename(dirname(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'gf_autofill_load_textdomain');
