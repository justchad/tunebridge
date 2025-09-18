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

    <?php
            // Load tab navigation
            get_template_part('TemplateParts/Dashboard/tabs');

            // Load main dashboard layout (2/3 - 1/3 layout)
            get_template_part('TemplateParts/Dashboard/layout');
            ?>
</div>
<?php
    }
}