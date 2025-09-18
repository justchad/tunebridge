<?php
defined('ABSPATH') || exit;

$current_tab = $_GET['tab'] ?? 'dashboard';

if ($current_tab !== 'dashboard') {
    return;
}
?>

<div class="tunebridge-dashboard-wrapper" style="display: flex; flex-wrap: wrap; gap: 2rem;">
    <div class="main-area" style="flex: 2; min-width: 300px;">
        <?php
        get_template_part('TemplateParts/Dashboard/Blocks/contact_today');
        get_template_part('TemplateParts/Dashboard/Blocks/notes');
        get_template_part('TemplateParts/Dashboard/Blocks/search_playlists');
        get_template_part('TemplateParts/Dashboard/Blocks/search_artists');
        ?>
    </div>

    <div class="sidebar-area" style="flex: 1; min-width: 250px;">
        <?php get_template_part('TemplateParts/Dashboard/Blocks/spotify_featured'); ?>
    </div>
</div>