<?php

namespace Tunebridge\Core;

defined('ABSPATH') || exit;

/**
 * Class Plugin
 *
 * Holds core constants and static init helpers.
 */
class Plugin
{

	/**
	 * Plugin version.
	 */
	const VERSION = '1.1.0';

	/**
	 * Set core constants for the plugin.
	 */
	public static function init()
	{
		define('TUNEBRIDGE_VERSION', self::VERSION);
		define('TUNEBRIDGE_PATH', plugin_dir_path(__FILE__) . '../../');
		define('TUNEBRIDGE_URL', plugin_dir_url(__FILE__) . '../../');
		define('TUNEBRIDGE_PLUGIN_FILE', TUNEBRIDGE_PATH . 'tunebridge.php');
	}
}

// ✅ Place this AFTER the class

require_once __DIR__ . '/../ajax/Playlist_Search_Ajax.php';
\Tunebridge\Ajax\Playlist_Search_Ajax::init();