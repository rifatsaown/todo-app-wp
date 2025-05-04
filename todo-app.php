<?php
/**
 * Plugin Name: Todo APP
 * Description: Integrates a Vite-React Todo APP application
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TODOAPP_VERSION', '1.0.0');
define('TODOAPP_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Add admin menu item
 */
function todoapp_add_menu() {
    add_options_page(
        'Todo APP Settings',
        'Todo APP',
        'manage_options',
        'todoapp',
        'todoapp_settings_page'
    );
}

/**
 * Enqueue scripts and styles
 */
function todoapp_enqueue_scripts($hook) {
    // Only load on our plugin's admin page
    if ('settings_page_todoapp' !== $hook) {
        return;
    }

    // Enqueue the local Vite app assets
    wp_enqueue_script(
        'todoapp-app',
        TODOAPP_PLUGIN_URL . '/frontend/dist/index.js',
        array(),
        TODOAPP_VERSION,
        true
    );

    // Add custom attributes for module type and crossorigin
    add_filter('script_loader_tag', function($tag, $handle, $src) {
        if ('todoapp-app' === $handle) {
            return '<script type="module" crossorigin="anonymous" src="' . esc_url($src) . '"></script>';
        }
        return $tag;
    }, 10, 3);

    // Pass WordPress data to your React app
    wp_localize_script(
        'todoapp-app',
        'wpData',
        array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('todoapp_nonce'),
            'pluginUrl' => TODOAPP_PLUGIN_URL
        )
    );
}

/**
 * Render the settings page
 */
function todoapp_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <div class="card">
            <h2>Todo APP</h2>
            <div id="root"></div>
            <hr>
            <h3>How to Use</h3>
            <p>The Todo APP is available only in the WordPress admin dashboard for security reasons.</p>
        </div>
    </div>
    <?php
}

/**
 * Initialize the plugin
 */
function todoapp_init() {
    add_action('admin_menu', 'todoapp_add_menu');
    add_action('admin_enqueue_scripts', 'todoapp_enqueue_scripts');
}

// Hook into WordPress
add_action('init', 'todoapp_init');