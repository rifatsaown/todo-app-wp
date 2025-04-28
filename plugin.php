<?php
/*
Plugin Name: Todo App WP
Description: A simple Todo app built with React and integrated into WordPress.
Version: 1.0.0
Author: Md Rifat Hossen Saown
Author URI: https://github.com/rifatsaown
License: GPL2
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Todo_App_Plugin
 */
class Todo_App_Plugin {

    /**
     * Constructor
     */
    public function __construct() {
        // Hook into WordPress
        add_action('admin_menu', array($this, 'register_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('todo_app', 'todo_app_wp_shortcode');
    }

    /**
     * Register admin menu item
     */
    public function register_admin_menu() {
        add_menu_page(
            'Todo App',
            'Todo App',
            'manage_options',
            'todo-app',
            array($this, 'render_app'),
            'dashicons-list-view',
            30
        );
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts($hook) {
        // Get the plugin directory URL
        $plugin_url = plugin_dir_url(__FILE__);

        // Enqueue WordPress's React and ReactDOM
        wp_enqueue_script('react');
        wp_enqueue_script('react-dom');

        // Add inline script to expose React and ReactDOM globally
        wp_add_inline_script(
            'react',
            "window.React = React; window.ReactDOM = ReactDOM;"
        );

        // Locate the JavaScript file
        $js_files = glob(plugin_dir_path(__FILE__) . 'frontend/dist/*.js');
        if (!empty($js_files)) {
            $js_file = basename($js_files[0]);
            wp_enqueue_script(
                'todo-app-script',
                $plugin_url . 'frontend/dist/' . $js_file,
                ['react', 'react-dom'], // Add React and ReactDOM as dependencies
                '1.0.0',
                true
            );
        }

        // Remove CSS enqueue logic as there is no CSS file in the build
        // Previously enqueued CSS logic has been removed.

        // Add inline script to initialize the React app - using direct DOM manipulation instead of ReactDOM.createRoot
        wp_add_inline_script(
            'todo-app-script',
            "document.addEventListener('DOMContentLoaded', function() {
                var adminRoot = document.getElementById('todo-app-root');
                var pageRoot = document.getElementById('todo-app');
                
                if (adminRoot) {
                    ReactDOM.render(React.createElement(Ih), adminRoot);
                }
                
                if (pageRoot) {
                    ReactDOM.render(React.createElement(Ih), pageRoot);
                }
            });"
        );
    }

    /**
     * Render the app container
     */
    public function render_app() {
        echo '<div class="wrap">';
        echo '<h1>Todo App</h1>';
        echo '<div id="todo-app-root"></div>';
        echo '</div>';
    }
}

// Initialize the plugin
new Todo_App_Plugin();

// Enqueue the React app's assets dynamically
function todo_app_wp_enqueue_assets() {
    $plugin_dir = plugin_dir_path(__FILE__);
    $plugin_url = plugin_dir_url(__FILE__);

    // Locate the JavaScript file
    $js_files = glob($plugin_dir . 'frontend/dist/*.js');
    if (!empty($js_files)) {
        $js_file = basename($js_files[0]);
        wp_enqueue_script(
            'todo-app-wp-js',
            $plugin_url . 'frontend/dist/' . $js_file,
            [],
            '1.0.0',
            true
        );
    }

    // Remove CSS enqueue logic as there is no CSS file in the build
    // Previously enqueued CSS logic has been removed.
}
add_action('wp_enqueue_scripts', 'todo_app_wp_enqueue_assets');

// Shortcode to render the React app
function todo_app_wp_shortcode() {
    return '<div id="todo-app"></div>';
}
add_shortcode('todo_app', 'todo_app_wp_shortcode');