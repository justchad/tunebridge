<?php

namespace Tunebridge\Data;

defined('ABSPATH') || exit;

/**
 * Provides mock data for dev/testing mode.
 */
class Mock_Data
{

    public static function get_playlists()
    {
        return [
            [
                'id'        => '123',
                'name'      => 'Indie Vibes',
                'curator'   => 'IndieWave',
                'tracks'    => 48,
                'followers' => 2543,
                'url'       => 'https://open.spotify.com/playlist/123',
            ],
            // ...more
        ];
    }

    public static function get_artists()
    {
        return [
            [
                'id'      => 'abc123',
                'name'    => 'The Echo Project',
                'genre'   => 'Alt Rock',
                'country' => 'US',
                'spotify' => 'https://open.spotify.com/artist/abc123',
            ],
            // ...
        ];
    }

    public static function get_contact_card($id = null)
    {
        return [
            'id'     => $id ?? 1,
            'name'   => 'Alex Johnson',
            'email'  => 'alex@example.com',
            'status' => 'Follow-Up',
            'source' => 'Spotify',
            'meta'   => [
                'platforms' => ['Spotify', 'Apple Music'],
                'socials'   => ['twitter' => '@alexj'],
                'notes'     => ['Loves indie pop', 'Based in NYC'],
            ],
        ];
    }

    public static function get_messages()
    {
        return [
            [
                'id'      => 1,
                'label'   => 'Initial Contact',
                'tags'    => ['initial'],
                'content' => 'Hey {{name}}, I found your playlist and thought our track might be a good fit...',
            ],
            // ...
        ];
    }

    public static function get_notes()
    {
        return [
            [
                'id'   => 1,
                'type' => 'search',
                'note' => 'Looked up "Indie Electro" playlists today.',
                'date' => '2025-09-17',
            ],
            // ...
        ];
    }
}