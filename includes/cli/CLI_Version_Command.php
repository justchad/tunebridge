<?php

namespace Tunebridge\Cli;

defined('ABSPATH') || exit;

if (!class_exists('\WP_CLI')) {
    return; // Prevents fatal error if WP_CLI is not available
}

/**
 * Handles version management commands for TuneBridge.
 */
class Cli_Version_Command
{
    /**
     * Outputs the current plugin version.
     *
     * ## EXAMPLES
     *
     *     wp tunebridge version get
     *
     * @when after_wp_load
     */
    public function get()
    {
        \WP_CLI::success('TuneBridge version: ' . TUNEBRIDGE_VERSION);
    }

    /**
     * Bumps the plugin version.
     *
     * ## OPTIONS
     *
     * <type>
     * : The type of version bump. Options: patch, minor, major
     *
     * ## EXAMPLES
     *
     *     wp tunebridge version bump patch
     *
     * @when after_wp_load
     */
    public function bump($args)
    {
        list($type) = $args;

        $plugin_file = dirname(__DIR__) . '/Core/plugin.php';

        $contents = file_get_contents($plugin_file);

        if (!preg_match("/const VERSION = '(\d+)\.(\d+)\.(\d+)'/", $contents, $matches)) {
            \WP_CLI::error('Version constant not found.');
            return;
        }

        list(, $major, $minor, $patch) = $matches;

        switch ($type) {
            case 'major':
                $major++;
                $minor = 0;
                $patch = 0;
                break;
            case 'minor':
                $minor++;
                $patch = 0;
                break;
            case 'patch':
                $patch++;
                break;
            default:
                \WP_CLI::error("Invalid type '$type'. Use: patch, minor, or major.");
                return;
        }

        $new_version = "$major.$minor.$patch";

        $contents = preg_replace(
            "/const VERSION = '\d+\.\d+\.\d+';/",
            "const VERSION = '$new_version';",
            $contents
        );

        file_put_contents($plugin_file, $contents);

        \WP_CLI::success("Plugin version bumped to $new_version");
    }
}