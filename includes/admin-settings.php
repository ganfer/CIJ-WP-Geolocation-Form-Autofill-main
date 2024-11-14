<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class GeolocationFormAutofillPlugin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    // Admin-Menü
    public function add_admin_menu() {
        add_menu_page(
            __('Geolocation Form Autofill', 'geolocation-form-autofill'),
            __('Geolocation Autofill', 'geolocation-form-autofill'),
            'manage_options',
            'geolocation-form-autofill',
            array($this, 'admin_page'),
            'dashicons-location'
        );
    }

    // Settings
    public function register_settings() {
        register_setting('geolocation_form_autofill_settings', 'geolocation_form_autofill_enable');
        register_setting('geolocation_form_autofill_settings', 'geolocation_form_autofill_location');
    }

    // Admin-Page
    public function admin_page() {
        wp_enqueue_style('geolocation_form_autofill_admin_style', GEOLOCATION_FORM_AUTOFILL_URL . 'assets/css/admin-style.css');
        ?>
        <div class="wrap">
            <h1><?php _e('Dynamics Customer Insights - Journeys Forms Geolocation Form Autofill Plugin', 'geolocation-form-autofill'); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields('geolocation_form_autofill_settings'); ?>
                <?php do_settings_sections('geolocation_form_autofill_settings'); ?>
                
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Enable Plugin', 'geolocation-form-autofill'); ?></th>
                        <td>
                            <input type="checkbox" name="geolocation_form_autofill_enable" value="1" <?php checked(1, get_option('geolocation_form_autofill_enable'), true); ?> />
                            <label for="geolocation_form_autofill_enable"><?php _e('Activate the plugin to start autofilling forms.', 'geolocation-form-autofill'); ?></label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Script Location', 'geolocation-form-autofill'); ?></th>
                        <td>
                            <select name="geolocation_form_autofill_location">
                                <option value="header" <?php selected(get_option('geolocation_form_autofill_location', 'header'), 'header'); ?>>
                                    <?php _e('In Header', 'geolocation-form-autofill'); ?>
                                </option>
                                <option value="shortcode" <?php selected(get_option('geolocation_form_autofill_location', 'header'), 'shortcode'); ?>>
                                    <?php _e('Via Shortcode', 'geolocation-form-autofill'); ?>
                                </option>
                            </select>
                        </td>
                    </tr>
                </table>

                <?php submit_button(__('Save Changes', 'geolocation-form-autofill')); ?>
            </form>

            <h2><?php _e('Instructions', 'geolocation-form-autofill'); ?></h2>
            <p><?php _e('This plugin automatically fills city and postal code fields in Dynamics Customer Insights - Journeys forms based on user geolocation.', 'geolocation-form-autofill'); ?></p>
            <p><?php _e('If you want to use the script on specific pages, select "Via Shortcode" above and use this shortcode on the desired page:', 'geolocation-form-autofill'); ?></p><p><code>[geolocation_form_autofill]</code></p>
        </div>
        <?php
    }
}
?>
