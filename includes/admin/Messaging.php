<?php

namespace Tunebridge\Admin;
/**
 * Messaging placeholder for TuneBridge.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

defined( 'ABSPATH' ) || exit;

class Messaging {
	public static function render() {
		echo '<div class="wrap"><h1>' . esc_html__( 'Messaging (MVP placeholder)', 'tunebridge' ) . '</h1></div>';
	}
}
