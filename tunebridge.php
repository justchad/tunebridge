<?php

/**
 * Plugin Name:     TuneBridge
 * Plugin URI:      https://chatgpt.com/g/g-6cqBCrKTn-wp-plugin-architect
 * Description:     Research and outreach tool for music platforms and playlists.
 * Version:         1.0.3
 * Author:          WP Plugin Architect
 * Author URI:      https://chatgpt.com/g/g-6cqBCrKTn-wp-plugin-architect
 * Text Domain:     tunebridge
 * Domain Path:     /languages
 */

defined('ABSPATH') || exit;

// Autoload (if applicable)
// require_once __DIR__ . '/vendor/autoload.php';

// Core
require_once __DIR__ . '/includes/core/Plugin.php';
\Tunebridge\Core\Plugin::init();

// CLI
if (defined('WP_CLI') && WP_CLI) {
	require_once __DIR__ . '/includes/cli/CLI_Version_Command.php';
	\WP_CLI::add_command('tunebridge version', \Tunebridge\CLI\CLI_Version_Command::class);
}

// Admin
if (is_admin()) {
	require_once __DIR__ . '/includes/admin/Admin.php';
	\Tunebridge\Admin\Admin::init();
}