<?php

namespace Tunebridge\Admin;

defined('ABSPATH') || exit;

require_once __DIR__ . '/Pages/dashboard_page.php';
require_once __DIR__ . '/Pages/messaging_page.php';
require_once __DIR__ . '/Pages/contacts_page.php';
require_once __DIR__ . '/Pages/settings_page.php';

class Admin
{

    public static function init()
    {
        add_action('admin_menu', [__CLASS__, 'register_menu']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
    }

    public static function register_menu()
    {
        $capability = 'manage_options';

        add_menu_page(
            'TuneBridge',
            'TuneBridge',
            $capability,
            'tunebridge',
            [Pages\Dashboard_Page::class, 'render'],
            'dashicons-playlist-audio',
            25
        );

        add_submenu_page('tunebridge', 'Dashboard', 'Dashboard', $capability, 'tunebridge', [Pages\Dashboard_Page::class, 'render']);
        add_submenu_page('tunebridge', 'Messaging', 'Messaging', $capability, 'tunebridge-messaging', [Pages\Messaging_Page::class, 'render']);
        add_submenu_page('tunebridge', 'Contacts', 'Contacts', $capability, 'tunebridge-contacts', [Pages\Contacts_Page::class, 'render']);
        add_submenu_page('tunebridge', 'Settings', 'Settings', $capability, 'tunebridge-settings', [Pages\Settings_Page::class, 'render']);
    }

    public static function enqueue_assets($hook)
    {
        if (strpos($hook, 'tunebridge') === false) {
            return;
        }

        wp_enqueue_style('tunebridge-admin', plugin_dir_url(__FILE__) . '../../../Assets/css/admin.css', [], '1.0.0');
    }
}