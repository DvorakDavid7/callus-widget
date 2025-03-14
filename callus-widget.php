<?php
/*
 * Plugin Name: Callus Widget
 */

$default_phone_number = '+420774034180';

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

function my_plugin_enqueue_style() {
    wp_enqueue_style('callus-widget-style', plugin_dir_url(__FILE__) . 'style.css');
}

function my_plugin_register_settings() {
    global $default_phone_number;
    add_option('callus_phone_number', $default_phone_number);
    register_setting('callus_options_group', 'callus_phone_number');
}

function my_contact_form_func() {
    global $default_phone_number;
    $phone = get_option('callus_phone_number', $default_phone_number);
    ob_start(); ?>

    <button onclick="window.location.href = 'tel:<?php echo esc_attr($phone); ?>'" class="call-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
        </svg>
    </button>

    <?php
    return ob_get_clean();
}

function my_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Callus Widget Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('callus_options_group');
            do_settings_sections('callus_options_group');
            ?>
            <label for="callus_phone_number">Phone Number:</label>
            <input type="text" name="callus_phone_number" value="<?php echo get_option('callus_phone_number'); ?>" />
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function my_plugin_add_settings_menu() {
    add_menu_page('Callus Widget', 'Callus Widget', 'manage_options', 'callus-settings', 'my_plugin_settings_page');
}

add_action('admin_menu', 'my_plugin_add_settings_menu');
add_action('admin_init', 'my_plugin_register_settings');
add_shortcode('my_contact_form', 'my_contact_form_func');
add_action('wp_enqueue_scripts', 'my_plugin_enqueue_style');