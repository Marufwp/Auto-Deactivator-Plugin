<?php
/**
 * Plugin Name: Auto Deactivator Plugin
 * Description: Automatically deactivate conflicting plugins or themes during critical errors.
 * Version: 1.0
 * Author: Maruf Hossain
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Register a shutdown function to catch fatal errors
register_shutdown_function('emergency_capture_fatal_errors');

function emergency_capture_fatal_errors()
{
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        // Set a transient indicating a critical error occurred
        set_transient('emergency_plugin_deactivate', true, 60 * 60); // 1 hour
    }
}

add_action('admin_init', 'emergency_check_and_deactivate_plugins');

function emergency_check_and_deactivate_plugins()
{
    if (get_transient('emergency_plugin_deactivate')) {
        // Clear the transient
        delete_transient('emergency_plugin_deactivate');

        // Load necessary WordPress functions
        if (!function_exists('deactivate_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        // Get the list of active plugins
        $active_plugins = get_option('active_plugins');

        // Deactivate all plugins except this one
        foreach ($active_plugins as $plugin) {
            if ($plugin !== plugin_basename(__FILE__)) {
                deactivate_plugins($plugin);
            }
        }

        // Clear cache
        wp_cache_flush();

        // Add an admin notice
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning is-dismissible"><p>The Auto Deactivator Plugin is active. It will automatically deactivate conflicting plugins during critical errors. Please check the site and reactivate plugins as needed.</p></div>';
        });

        // Redirect to the admin dashboard
        wp_safe_redirect(admin_url());
        exit();
    }
}

// Add a notice to the admin area to inform users about the plugin
add_action('admin_notices', 'emergency_admin_notice');

function emergency_admin_notice()
{
    if (!is_admin()) {
        return;
    }
    $user = wp_get_current_user();
    if (isset($user->roles) && in_array('administrator', $user->roles)) {
        echo '<div class="notice notice-warning is-dismissible"><p>The Auto Deactivator Plugin is active. It will automatically deactivate conflicting plugins during critical errors. Please deactivate this plugin after resolving the issues.</p></div>';
    }
}
