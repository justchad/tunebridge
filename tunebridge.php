<?php

/**
 * Plugin Name:     TuneBridge
 * Plugin URI:      https://chatgpt.com/g/g-6cqBCrKTn-wp-plugin-architect
 * Description:     Research and outreach tool for music platforms and playlists.
 * Version:         1.1.1
 * Author:          WP Plugin Architect
 * Author URI:      https://chatgpt.com/g/g-6cqBCrKTn-wp-plugin-architect
 * Text Domain:     tunebridge
 * Domain Path:     /languages
 */

defined('ABSPATH') || exit;

// 🔧 Core Constants
define('TUNEBRIDGE_VERSION', '1.1.1');
define('TUNEBRIDGE_PATH', plugin_dir_path(__FILE__));
define('TUNEBRIDGE_URL', plugin_dir_url(__FILE__));
define('TUNEBRIDGE_PLUGIN_FILE', __FILE__);

// 🧠 Core
require_once TUNEBRIDGE_PATH . 'includes/ajax/Playlist_Search_Ajax.php';
\Tunebridge\Ajax\Playlist_Search_Ajax::init();

// 📇 Contacts System
require_once TUNEBRIDGE_PATH . 'includes/Contacts/Contact_Post_Type.php';
\Tunebridge\Contacts\Contact_Post_Type::init();

require_once TUNEBRIDGE_PATH . 'includes/Contacts/Contact_Meta.php';
\Tunebridge\Contacts\Contact_Meta::init();

require_once TUNEBRIDGE_PATH . 'includes/Contacts/Contact_List_Table.php';
\Tunebridge\Contacts\Contact_List_Table::init();

require_once TUNEBRIDGE_PATH . 'includes/Contacts/Contact_List_Actions.php';
\Tunebridge\Contacts\Contact_List_Actions::init();

// 🔧 Utilities
require_once TUNEBRIDGE_PATH . 'includes/Utilities/Admin_Notices.php';
\Tunebridge\Utilities\Admin_Notices::init();

// 🖥️ Admin
if (is_admin()) {
	require_once TUNEBRIDGE_PATH . 'includes/admin/Admin.php';
	\Tunebridge\Admin\Admin::init();
}

// ⚙️ CLI
if (defined('WP_CLI') && WP_CLI) {
	require_once TUNEBRIDGE_PATH . 'includes/cli/CLI_Version_Command.php';
	\WP_CLI::add_command('tunebridge version', \Tunebridge\CLI\CLI_Version_Command::class);
}

// ✅ Load any helper files
foreach (glob(TUNEBRIDGE_PATH . 'includes/helpers/*.php') as $helper_file) {
	require_once $helper_file;
}