<?php

namespace Tunebridge\Core;

defined('ABSPATH') || exit;

class Plugin
{

    const VERSION = '1.0.2';

    public static function init()
    {
        define('TUNEBRIDGE_VERSION', self::VERSION);
        define('TUNEBRIDGE_PATH', plugin_dir_path(__FILE__) . '/../../');
        define('TUNEBRIDGE_URL', plugin_dir_url(__FILE__) . '/../../');
        define('TUNEBRIDGE_PLUGIN_FILE', TUNEBRIDGE_PATH . 'tunebridge.php');
    }
}