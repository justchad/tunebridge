<?php

namespace Tunebridge\CLI;

use WP_CLI;

defined('ABSPATH') || exit;

class CLI_Version_Command
{

	/**
	 * Display current plugin version.
	 *
	 * ## EXAMPLES
	 *     wp tunebridge version get
	 */
	public function get()
	{
		WP_CLI::success('TuneBridge version: ' . TUNEBRIDGE_VERSION);
	}

	/**
	 * Bump the plugin version.
	 *
	 * ## OPTIONS
	 * <type>
	 * : Type of bump. Options: patch, minor, major.
	 *
	 * ## EXAMPLES
	 *     wp tunebridge version bump patch
	 */
	public function bump($args)
	{
		$type = $args[0];
		$current = TUNEBRIDGE_VERSION;
		$parts = explode('.', $current);
		if (count($parts) !== 3) {
			WP_CLI::error('Invalid version format.');
		}

		switch ($type) {
			case 'patch':
				$parts[2]++;
				break;
			case 'minor':
				$parts[1]++;
				$parts[2] = 0;
				break;
			case 'major':
				$parts[0]++;
				$parts[1] = 0;
				$parts[2] = 0;
				break;
			default:
				WP_CLI::error('Invalid bump type. Use patch, minor, or major.');
		}

		$new_version = implode('.', $parts);

		// Update Plugin.php file
		$plugin_file = plugin_dir_path(__FILE__) . '../Core/Plugin.php';
		$contents = file_get_contents($plugin_file);
		$contents = preg_replace("/const VERSION = '(.*?)';/", "const VERSION = '$new_version';", $contents);
		file_put_contents($plugin_file, $contents);

		// Write new changelog entry
		$changelog_path = plugin_dir_path(__FILE__) . '../../../CHANGELOG.md';
		$date = date('Y-m-d');
		$entry = "## [$new_version] - $date\n- Version bumped to $new_version\n\n";
		file_put_contents($changelog_path, $entry . file_get_contents($changelog_path));

		// Update snapshot
		$snapshot = plugin_dir_path(__FILE__) . '../../../tunebridge_snapshot.json';
		$snapshot_data = [
			'version' => $new_version,
			'last_bumped' => $date,
		];
		file_put_contents($snapshot, json_encode($snapshot_data, JSON_PRETTY_PRINT));

		WP_CLI::success("Plugin version bumped to $new_version");
	}
}