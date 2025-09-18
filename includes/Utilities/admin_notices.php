<?php

namespace Tunebridge\Utilities;

defined('ABSPATH') || exit;

class Admin_Notices
{

    public static function init()
    {
        add_action('admin_notices', [__CLASS__, 'render_notice']);
    }

    public static function render_notice()
    {
        if (!current_user_can('manage_options')) return;

        echo '<div class="notice notice-info is-dismissible">';
        echo '<p>' . esc_html__('TuneBridge is active and ready.', 'tunebridge') . '</p>';
        echo '</div>';
    }
}