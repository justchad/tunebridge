<?php

namespace Tunebridge\Admin;
/**
 * Dashboard UI rendering.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

defined( 'ABSPATH' ) || exit;

class Dashboard {

	public static function render() {
		?>
		<div class="wrap tunebridge-wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'TuneBridge Dashboard', 'tunebridge' ); ?></h1>

			<nav class="nav-tab-wrapper">
				<a href="#" class="nav-tab nav-tab-active" data-tab="dashboard"><?php esc_html_e( 'Dashboard', 'tunebridge' ); ?></a>
				<a href="#" class="nav-tab" data-tab="messaging"><?php esc_html_e( 'Messaging', 'tunebridge' ); ?></a>
				<a href="#" class="nav-tab" data-tab="contacts"><?php esc_html_e( 'Contacts', 'tunebridge' ); ?></a>
			</nav>

			<div class="tunebridge-tab-content">
				<div id="tab-dashboard" class="tab-section active">
					<?php \TuneBridge\load_template_part( 'dashboard.php' ); ?>
				</div>
				<div id="tab-messaging" class="tab-section">
					<p><?php esc_html_e( 'Messaging content coming soon.', 'tunebridge' ); ?></p>
				</div>
				<div id="tab-contacts" class="tab-section">
					<p><?php esc_html_e( 'Contacts content coming soon.', 'tunebridge' ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}
}
