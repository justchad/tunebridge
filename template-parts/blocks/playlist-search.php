<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><?php _e('Search Playlists', 'tunebridge'); ?></h5>
    </div>
    <div class="card-body">
        <form id="tunebridge-playlist-search-form" class="mb-3">
            <input type="text" name="playlist_query" class="form-control"
                placeholder="<?php esc_attr_e('Enter playlist name or curator...', 'tunebridge'); ?>" />
            <button type="submit" class="btn btn-primary mt-2"><?php _e('Search', 'tunebridge'); ?></button>
        </form>
        <table class="table table-bordered table-sm mt-3">
            <thead>
                <tr>
                    <th><?php _e('Name', 'tunebridge'); ?></th>
                    <th><?php _e('Curator', 'tunebridge'); ?></th>
                    <th><?php _e('Tracks', 'tunebridge'); ?></th>
                    <th><?php _e('Followers', 'tunebridge'); ?></th>
                    <th><?php _e('Link', 'tunebridge'); ?></th>
                </tr>
            </thead>
            <tbody id="tunebridge-playlist-search-results">
                <tr>
                    <td colspan="5"><?php _e('No results yet.', 'tunebridge'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>