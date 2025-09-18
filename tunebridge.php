<?php

/**
 * Plugin Name:       TuneBridge
 * Plugin URI:        https://github.com/justchad/tunebridge
 * Description:       Research and outreach tool for music platforms and playlists.
 * Version:           1.0.0
 * Author:            Chad McElwain
 * Author URI:        https://github.com/justchad
 * Text Domain:       tunebridge
 * Domain Path:       /languages
 */

defined('ABSPATH') || exit;

require_once __DIR__ . '/Includes/Core/plugin.php';
\Tunebridge\Core\Plugin::init();

require_once __DIR__ . '/Includes/Admin/admin.php';
\Tunebridge\Admin\Admin::init();

if (defined('WP_CLI') && WP_CLI) {
    require_once __DIR__ . '/Includes/Cli/cli_version_command.php';
    \WP_CLI::add_command('tunebridge version', \Tunebridge\Cli\Cli_Version_Command::class);
}