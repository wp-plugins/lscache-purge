=== LiteSpeed Cache Purge ===
Contributors: LiteSpeed Tech.
Tags: lsws, lscache, purge, cache
Requires at least: LSWS 4.2.2-ent (2CPU license or above)
Tested up to: 3.5.1
Stable tag: 1.0.1

== Description ==
Plugin for invalidating Wordpress items on a litespeed cache

LiteSpeed Cache Purge sends an HTTP PURGE or REFRESH request to the URL of a page or post every time it is modified. This occurs when editing, publishing, commenting or deleting an item.

== Requirements ==
In order to work, the varnish cache meeds to accept PURGE/REFRESH request from the host of the wordpress web server.

Tested with LSWS 4.2.2 WP 3.5.1

== Installation ==
Download to your plugin directory. Or simply install via Wordpress admin interface.
Activate.
Settings: choose purge method (PURGE or REFRESH)
LScache: to enable, 

WebAdmin console => Configuration => Server => Cache

Cache Storage Settings
Storage Path: /disk/lscache
Max Object Size: 128000 

Cache Policy
Enable Cache: Yes
Cache Expire Time (seconds): 120
Cache Stale Age (seconds): Not Set
Cache Request with Query String: No
Cache Request with Cookie: Yes
Cache Response with Cookie: Yes
Ignore Request Cache-Control: Yes
Ignore Response Cache-Control: Yes
Enable Private Cache: Not Set
Private Cache Expire Time (seconds): Not Set

Do-Not-Cache URL
wp-admin

For details, refer to http://blog.litespeedtech.com/2013/02/18/lsws-cache-purge-plugin/

== Changelog ==

= 1.0.1 =
* Eliminate 'The plugin generated 1 characters of unexpected output during activation' error message.

= 1.0.0 =
* Initial Release

