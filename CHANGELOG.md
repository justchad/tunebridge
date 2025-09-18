## [1.0.4] - 2025-09-18
### Changed
- Removed redundant `dashboard_tabs.php` template.
- Confirmed `tabs.php` is the correct version for dashboard tab rendering.
- Cleaned up and verified file structure to align with active plugin structure.

## [1.0.3] - 2025-09-17
### Added
- Dashboard block rendering framework
- Dashboard block loader and registration system
- Template part discovery for Dashboard blocks
- Integration with admin controller to render blocks

### Fixed
- Admin controller alignment with file structure and menu setup

### Changed
- Improved consistency between file structure and routing


## [1.0.2] - 2025-09-17
### Added
- Contact custom post type registered.
- Meta box support for contact details (email, status).
- Stub for contact list table under WP admin submenu.
- Action links for contacts (e.g. “Send Message”).
- Basic admin notice for plugin activation status.
- Utilities and CLI namespace wiring confirmed.

## [1.0.2] - 2025-09-17
### Added
- Dashboard admin page with tabbed navigation (`Dashboard`, `Messaging`, `Contacts`)
- Responsive layout with 2/3 main content and 1/3 sidebar
- Mock block template parts:
  - Contact Today
  - Notes
  - Search Playlists
  - Search Artists
  - Spotify Featured Playlists
- UI structure using `TemplateParts/Dashboard/Blocks` with PascalCase directories and snake_case files


## [1.0.1] - 2025-09-17
### Changed
- Fixed incorrect file path in `Cli_Version_Command` for locating `plugin.php`.
- Ensured `WP_CLI` constant is defined before registering the CLI command.

## [1.0.1] - 2025-09-17
### Added
- Plugin base structure initialized
- Core bootstrapping via `Includes/Core/plugin.php`
- CLI command: `wp tunebridge version` now available

### Infrastructure
- Directory and file structure standardized:
  - Capitalized directory names (e.g., `Includes`, `Assets`)
  - Lowercase underscored file names (e.g., `dashboard_page.php`)
- Source control initialized as per `source_control.txt`

### Notes
- This version sets the foundation for the admin interface, CLI integration, and core plugin loading.
