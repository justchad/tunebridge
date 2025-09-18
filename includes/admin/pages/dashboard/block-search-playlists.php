<div class="card tunebridge-block tunebridge-playlist-search">
    <div class="card-header">
        <h2 class="h4"><?php esc_html_e('Search Playlists', 'tunebridge'); ?></h2>
    </div>
    <div class="card-body">
        <form method="get" class="tunebridge-playlist-search-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="playlist-name"><?php esc_html_e('Playlist Name', 'tunebridge'); ?></label>
                    <input type="text" id="playlist-name" name="playlist_name" class="regular-text" />
                </div>
                <div class="form-group">
                    <label for="curator-name"><?php esc_html_e('Curator Name', 'tunebridge'); ?></label>
                    <input type="text" id="curator-name" name="curator_name" class="regular-text" />
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="button button-primary">
                        <?php esc_html_e('Search', 'tunebridge'); ?>
                    </button>
                </div>
            </div>
        </form>

        <hr>

        <div class="tunebridge-search-results">
            <p><strong><?php esc_html_e('Search results will appear here.', 'tunebridge'); ?></strong></p>
            <!-- Example static result -->
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Playlist', 'tunebridge'); ?></th>
                        <th><?php esc_html_e('Curator', 'tunebridge'); ?></th>
                        <th><?php esc_html_e('Tracks', 'tunebridge'); ?></th>
                        <th><?php esc_html_e('Actions', 'tunebridge'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>I