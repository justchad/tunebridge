<?php

namespace Tunebridge\Admin\Pages;

defined('ABSPATH') || exit;

class Dashboard_Page
{

    /**
     * Render the Dashboard page.
     */
    public static function render()
    {
?>
<div class="wrap tunebridge-dashboard">
    <h1><?php esc_html_e('TuneBridge Dashboard', 'tunebridge'); ?></h1>

    <div class="tunebridge-container">
        <div class="tunebridge-main">
            <?php
                    self::load_block('block-contact-today');
                    self::load_block('block-notes');
                    self::load_block('block-search-playlists');
                    self::load_block('block-search-artists');
                    ?>
        </div>
        <div class="tunebridge-sidebar">
            <?php
                    self::load_block('block-featured-playlists');
                    ?>
        </div>
    </div>
</div>
<?php
    }

    /**
     * Load a dashboard block partial.
     */
    private static function load_block($slug)
    {
        $file = __DIR__ . '/dashboard/' . $slug . '.php';
        if (file_exists($file)) {
            include $file;
        }
    }
}