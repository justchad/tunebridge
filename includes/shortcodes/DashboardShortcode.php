<?php

namespace Tunebridge\Shortcodes;
/**
 * Shortcodes for TuneBridge.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

defined( 'ABSPATH' ) || exit;

class Shortcodes {

	public static function register_shortcodes() {
		add_shortcode( 'tunebridge_dashboard', [ __CLASS__, 'dashboard_shortcode' ] );
	}

	public static function dashboard_shortcode( $atts ) {
		ob_start();
		echo '<div class="tunebridge-dashboard-shortcode">';
		\TuneBridge\load_template_part( 'dashboard.php' );
		echo '</div>';
		return ob_get_clean();
	}
}
