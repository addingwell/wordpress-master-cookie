=== Visitor UUID Cookie ===
Contributors: Addingwell
Tags: uuid, cookie, visitor, tracking
Requires at least: 4.6
Tested up to: 5.7
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple plugin to create a visitor UUID server cookie named _aw_master_id.

== Description ==

This plugin sets a unique UUID for each visitor and stores it as a server-side cookie called `_aw_master_id`. 
The cookie lifetime is set to 13 months

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/visitor-uuid-cookie` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.

== Frequently Asked Questions ==

= How does this plugin work? =

The plugin generates a UUID for each visitor who is not logged in and stores it in a cookie named `_aw_master_id` and in the server-side session.

== Screenshots ==

1. No screenshots needed for this simple plugin.

== Changelog ==

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0 =
Initial release.
