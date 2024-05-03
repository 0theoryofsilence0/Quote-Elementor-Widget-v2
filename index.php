<?php
/*
Plugin Name: Quote Widget
Description: An Elementor add-on widget that lets users add a "Quote" to any page using the Elementor builder. (Customers Page)
Version: 1.0
Author: Julius Enriquez
Author URI: https://0theoryofsilence0.github.io/jenriquez/
Text Domain: quote_widget_elementor 
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the Elementor widget class
add_action('elementor/widgets/widgets_registered', function () {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'quote-widget.php';
});

function quote_widget_elementor_check_activation()
{
    // Check if Elementor is installed but not active
    if (check_plugin_installed('elementor')) {
        if (!is_plugin_active('elementor/elementor.php')) {
            if (current_user_can('activate_plugins')) {
                // Elementor is installed but not active, show "Activate" button
                $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . 'elementor/elementor.php' . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_elementor/elementor.php');
                $message = '<p>' . __('Quote Widget plugin is not working because you need to activate Elementor plugin.', 'quote_widget_elementor') . '</p>';
                $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $activation_url, __('Activate Now', 'quote_widget_elementor')) . '</p>';
                add_action('admin_notices', function () use ($message) {
                    echo '<div class="notice notice-error is-dismissible">' . $message . '</div>';
                });
                // Deactivate the plugin
                deactivate_plugins(plugin_basename(__FILE__));
                return;
            }
        }
    } else {
        // Elementor is not installed, show "Install" button
        if (current_user_can('install_plugins')) {
            $install_url = wp_nonce_url(self_admin_url(sprintf('update.php?action=install-plugin&plugin=%s', 'elementor')), 'install-plugin_elementor');
            $message = sprintf('<p>%s</p>', __('Quote Widget plugin is not working because you need to Install Elementor plugin.', 'quote_widget_elementor'));
            $message .= sprintf('<p><a href="%s" class="button-primary">%s</a></p>', $install_url, __('Install Now', 'quote_widget_elementor'));
            add_action('admin_notices', function () use ($message) {
                echo '<div class="notice notice-error is-dismissible">' . $message . '</div>';
            });
            // Deactivate the plugin
            deactivate_plugins(plugin_basename(__FILE__));
            return;
        }
    }
}

// Function to check if a plugin is installed
function check_plugin_installed($plugin_slug) {
    $installed_plugins = get_plugins();
    return isset($installed_plugins[$plugin_slug . '/' . $plugin_slug . '.php']);
}

add_action('admin_init', 'quote_widget_elementor_check_activation');

// Deactivate the quote_widget plugin if Elementor is deactivated
function quote_widget_deactivate_on_elementor_deactivation($plugin, $network_deactivating)
{
    if ($plugin === 'elementor/elementor.php') {
        deactivate_plugins(plugin_basename(__FILE__));
    }
}

add_action('deactivated_plugin', 'quote_widget_deactivate_on_elementor_deactivation', 10, 2);

// Enqueue CSS
function quote_widget_widget_enqueue_styles()
{
    wp_enqueue_style('quote_widget-styles', plugins_url('assets/widget-style.css', __FILE__));
}

add_action('elementor/frontend/after_enqueue_styles', 'quote_widget_widget_enqueue_styles');

