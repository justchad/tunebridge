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
    <?php get_template_part('TemplateParts/Dashboard/dashboard_tabs'); ?>
</div>
<?php
    }
}