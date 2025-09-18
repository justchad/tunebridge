# Changelog

## [1.1.0] - 2025-09-18
### Added
- Resumed development with full plugin sync from user upload
- Cleaned up structure and removed redundant files
- Synced with updated scope and confirmed baseline

## [1.0.9] - 2025-09-17
- Developer Settings section added to Settings page.
- Toggle to enable mock data responses implemented.
- Refactored Settings_Page to preserve existing structure.

## [1.0.8] - 2025-09-17
- Added centralized mock data provider in `Mock_Data.php` for testing.
- Added toggle support to use mock data instead of real APIs.
- Updated Plugin.php to load mock provider on init.

## [1.0.7] - 2025-09-17
- Stubbed out Messaging and Contacts pages to avoid menu registration errors.
- Cleaned and finalized Admin.php with proper namespacing and requires.
- Verified asset loading, menu registration, and submenu consistency.

## [1.0.6] - Playlist Search AJAX integration
- Added JavaScript-powered search form for Spotify playlists.
- Created Playlist_Search_Ajax handler with nonce and permission checks.
- Integrated Spotify Web API search via client credentials.
- Live AJAX results rendered into table format.

## [1.0.5] - Dashboard block structure finalized
- Rendered 5 modular dashboard blocks.
- Updated Dashboard_Page loader.

## [1.0.4] - Admin menu and dashboard page structure
- Implemented WP Admin menu: Dashboard, Messaging, Contacts, Settings.
- Registered all submenu pages under 'TuneBridge'.
- Created Dashboard_Page class with block loader.
- Initialized dashboard block layout system.

## [1.0.3] - Version bump CLI correction
- Fixed preg_replace issue in CLI version bump command.
- Switched to preg_replace_callback for safe version editing.
- Ensured CLI bump command writes valid PHP.

## [1.0.2] - CLI version bump command
- Added `wp tunebridge version get` and `version bump` commands.
- CLI command now edits Plugin.php version constant.
- Registered CLI command in main plugin bootstrap.

## [1.0.1] - Plugin structure & autoload
- Plugin.php version constant added.
- Base folders scaffolded: core, admin, cli, providers.
- Initial CLI class structure created.
- Snapshot JSON system introduced for crash recovery.

## [1.0.0] - Initial plugin setup
- Plugin activated successfully.
- Plugin headers and bootstrap added.
- Text domain set to `tunebridge`.
