<?php

namespace Tunebridge\CLI;

use WP_CLI;

defined('ABSPATH') || exit;

class CLI
{

    public static function register()
    {
        WP_CLI::add_command('tunebridge version', CLI_Version_Command::class);
    }
}