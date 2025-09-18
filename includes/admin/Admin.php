<?php

namespace Tunebridge\Admin;

defined('ABSPATH') || exit;

// ✅ Require admin page files
require_once __DIR__ . '/pages/Dashboard_Page.php';
require_once __DIR__ . '/pages/Settings_Page.php';
require_once __DIR__ . '/pages/Messaging_Page.php';
require_once __DIR__ . '/pages/Contacts_Page.php';

use Tunebridge\Admin\Pages\Dashboard_Page;
use Tunebridge\Admin\Pages\Settings_Page;
use Tunebridge\Admin\Pages\Messaging_Page;
use Tunebridge\Admin\Pages\Contacts_Page;

/**
 * Handles admin menu and page loading.
 */
class Admin
{

	/**
	 * Initialize admin menus and assets.
	 */
	public static function init()
	{
		add_action('admin_menu', [__CLASS__, 'register_menu']);
		add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_assets']);

		// ✅ Register settings fields (wrapped in admin_init)
		Settings_Page::register();
	}

	/**
	 * Register the admin menu and submenus.
	 */
	public static function register_menu()
	{
		$capability = 'manage_options';

		add_menu_page(
			__('TuneBridge', 'tunebridge'),
			__('TuneBridge', 'tunebridge'),
			$capability,
			'tunebridge',
			[Dashboard_Page::class, 'render'],
			'dashicons-playlist-audio',
			25
		);

		add_submenu_page(
			'tunebridge',
			__('Messaging', 'tunebridge'),
			__('Messaging', 'tunebridge'),
			$capability,
			'tunebridge-msg',
			[Messaging_Page::class, 'render']
		);

		add_submenu_page(
			'tunebridge',
			__('Contacts', 'tunebridge'),
			__('Contacts', 'tunebridge'),
			$capability,
			'tunebridge-ctc',
			[Contacts_Page::class, 'render']
		);

		add_submenu_page(
			'tunebridge',
			__('Settings', 'tunebridge'),
			__('Settings', 'tunebridge'),
			'manage_options',
			'tunebridge_settings',
			[Settings_Page::class, 'render']
		);
	}

	/**
	 * Enqueue admin JS assets.
	 */
	public static function enqueue_assets($hook)
	{
		if ($hook !== 'toplevel_page_tunebridge') {
			return;
		}

		wp_enqueue_script(
			'tunebridge-playlist-search',
			TUNEBRIDGE_URL . 'assets/js/admin/playlist-search.js',
			[],
			TUNEBRIDGE_VERSION,
			true
		);

		wp_localize_script('tunebridge-playlist-search', 'tunebridge', [
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('tunebridge_nonce'),
		]);
	}
}