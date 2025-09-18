<div class="tunebridge-contact-fields">
    <p>
        <label for="_tunebridge_email"><?php _e('Email', 'tunebridge'); ?></label><br />
        <input type="email" name="_tunebridge_email" class="regular-text"
            value="<?php echo esc_attr($meta['email']); ?>" />
    </p>

    <p>
        <label for="_tunebridge_source"><?php _e('Source', 'tunebridge'); ?></label><br />
        <input type="text" name="_tunebridge_source" class="regular-text"
            value="<?php echo esc_attr($meta['source']); ?>" />
    </p>

    <p>
        <label for="_tunebridge_platforms"><?php _e('Platforms (comma-separated)', 'tunebridge'); ?></label><br />
        <input type="text" name="_tunebridge_platforms" class="regular-text"
            value="<?php echo esc_attr($meta['platforms']); ?>" />
    </p>

    <p>
        <label for="_tunebridge_playlists"><?php _e('Playlists (comma-separated)', 'tunebridge'); ?></label><br />
        <input type="text" name="_tunebridge_playlists" class="regular-text"
            value="<?php echo esc_attr($meta['playlists']); ?>" />
    </p>

    <p>
        <label for="_tunebridge_socials"><?php _e('Socials (key:value JSON)', 'tunebridge'); ?></label><br />
        <textarea name="_tunebridge_socials" class="large-text"
            rows="2"><?php echo esc_textarea($meta['socials']); ?></textarea>
    </p>

    <p>
        <label for="_tunebridge_notes"><?php _e('Notes', 'tunebridge'); ?></label><br />
        <textarea name="_tunebridge_notes" class="large-text"
            rows="4"><?php echo esc_textarea($meta['notes']); ?></textarea>
    </p>
</div>