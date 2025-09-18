<?php

namespace Tunebridge\Admin\Pages;

defined('ABSPATH') || exit;

class Dashboard_Page
{
    public static function render()
    {
?>
<div class="wrap tunebridge-dashboard">
    <h1><?php esc_html_e('TuneBridge Dashboard', 'tunebridge'); ?></h1>

    <div class="row">
        <!-- Main content: 2/3 width -->
        <div class="col-md-8">
            <?php
                    get_template_part('TemplateParts/Dashboard/Blocks/contact_today');
                    get_template_part('TemplateParts/Dashboard/Blocks/notes');
                    get_template_part('TemplateParts/Dashboard/Blocks/search_playlists');
                    get_template_part('TemplateParts/Dashboard/Blocks/search_artists');
                    ?>
        </div>

        <!-- Sidebar: 1/3 width -->
        <div class="col-md-4">
            <?php
                    get_template_part('TemplateParts/Dashboard/Blocks/spotify_featured');
                    ?>
        </div>
    </div>
</div>
<?php
    }
}