<?php

namespace Tunebridge\Contacts;

use WP_List_Table;

defined('ABSPATH') || exit;

class Contact_List_Table extends WP_List_Table
{

    public static function init()
    {
        add_action('admin_menu', [__CLASS__, 'register_page']);
    }

    public static function register_page()
    {
        add_submenu_page(
            'tunebridge',
            __('Contacts', 'tunebridge'),
            __('Contacts', 'tunebridge'),
            'manage_options',
            'tunebridge_contacts',
            [__CLASS__, 'render_page']
        );
    }

    public static function render_page()
    {
        echo '<div class="wrap"><h1>' . esc_html__('TuneBridge Contacts', 'tunebridge') . '</h1>';
        echo '<p>This will be the list table view for contacts.</p>';
        echo '</div>';
    }
}