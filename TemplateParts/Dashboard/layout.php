<?php
defined('ABSPATH') || exit;

$current_tab = $_GET['tab'] ?? 'dashboard';

if ($current_tab !== 'dashboard') {
	echo '<p>' . esc_html__('This tab is under construction.', 'tunebridge') . '</p>';
	return;
}
?>

<div class="tunebridge-layout">
	<div class="tunebridge-main-column" style="width: 66%; float: left;">
		<?php
		get_template_part('TemplateParts/Dashboard/Blocks/contact_today');
		get_template_part('TemplateParts/Dashboard/Blocks/notes');
		get_template_part('TemplateParts/Dashboard/Blocks/search_playlists');
		get_template_part('TemplateParts/Dashboard/Blocks/search_artists');
		?>
	</div>

	<div class="tunebridge-sidebar-column" style="width: 30%; float: right;">
		<?php
		get_template_part('TemplateParts/Dashboard/Blocks/spotify_featured');
		?>
	</div>
	<div style="clear: both;"></div>
</div>
