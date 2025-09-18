<?php

namespace Tunebridge\Utilities;

defined('ABSPATH') || exit;

class Admin_Notices
{

    protected static $notices = [];

    public static function init()
    {
        add_action('admin_notices', [__CLASS__, 'display_notices']);
    }

    public static function add_notice($message, $type = 'success')
    {
        self::$notices[] = [
            'message' => $message,
            'type'    => $type,
        ];
    }

    public static function display_notices()
    {
        foreach (self::$notices as $notice) {
            printf(
                '<div class="notice notice-%1$s is-dismissible"><p>%2$s</p></div>',
                esc_attr($notice['type']),
                esc_html($notice['message'])
            );
        }
        // Reset notices after displaying
        self::$notices = [];
    }
}