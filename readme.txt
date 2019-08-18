
=== DTRT Admin Toolbar Links ===
Contributors: dotherightthingnz
Donate link: http://dotherightthing.co.nz
Tags: links, toolbar, admin
Requires at least: 4.9.5
Tested up to: 4.9.5
Requires PHP: 7.2.20
Stable tag: 0.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add links to the toolbar at the top of WordPress admin screens.

== Description ==

Add links to the toolbar at the top of WordPress admin screens.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wpdtrt-admin-toolbar-links` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->DTRT Admin Toolbar Links screen to configure the plugin

== Frequently Asked Questions ==

= How do I use the widget? =

One or more widgets can be displayed within one or more sidebars:

1. Locate the widget: Appearance > Widgets > *DTRT Admin Toolbar Links Widget*
2. Drag and drop the widget into one of your sidebars
3. Add a *Title*
4. Specify options

= How do I use the shortcode? =

```
<!-- within the editor -->
[wpdtrt_admin_toolbar_links option="value"]

// in a PHP template, as a template tag
<?php echo do_shortcode( '[wpdtrt_admin_toolbar_links option="value"]' ); ?>
```

== Screenshots ==

1. The caption for ./images/screenshot-1.(png|jpg|jpeg|gif)
2. The caption for ./images/screenshot-2.(png|jpg|jpeg|gif)

== Changelog ==

= 0.1.0 =
* Initial version

== Upgrade Notice ==

= 0.1.0 =
* Initial release
