=== SILVERCLEAN LITE ===

Contributors: Iceable
Tags: gray, silver, white, light, two-columns, right-sidebar, flexible-width, custom-header, custom-menu, featured-images, full-width-template, sticky-post, theme-options, threaded-comments, translation-ready
Requires at least: 3.5
Tested up to: 3.6.1
Stable tag: 1.1.4

== ABOUT SILVERCLEAN LITE ==

Silverclean Lite is a clean, elegant and responsive theme for WordPress. Perfect for various uses from personal blogging to small business website.
It features two widgetizable areas (sidebar and optional footer).

Silverclean Lite is the lite version of Silverclean Pro, which comes with many additional features and access to premium class pro support forum and can be found at http://www.iceablethemes.com

== GETTING STARTED ==

Once you activate the theme from your WordPress admin panel, you can visit the "Theme Options" page to quickly and easily upload your own logo and optionally set a custom favicon.
If you will be using a custom header image, you can also optionally choose to enable or disable it on your homepage, blog index pages, single post pages and individual pages.
It is highly recommended to set a menu (in appearance > menu) instead of relying on the default fallback menu. Doing so will automatically activate the dropdown version of your menu in responsive mode.

Additional documentation and free support forums can be found at http://www.iceablethemes.com under "support".

== SPECIAL FEATURES INSTRUCTIONS ==

* Footer widgets: The widgetizable footer is disabled by default. To activate it, simply go to Appearance > Widgets and drop some widgets in the "Footer" area, just like you would do for the sidebar. It is recommended to use 4 widgets in the footer, or no widgets at all to disable it.

== LICENSE ==

This theme is released under the terms of the GNU GPLv2 License.
Please refer to license.txt for more information.

== CREDITS ==

This theme bundles some third party javascript and jQuery plugins, released under GPL or GPL compatible licenses:
* hoverIntent: Copyright 2007, 2013 Brian Cherne. MIT License. http://cherne.net/brian/resources/jquery.hoverIntent.html
* superfish: Copyright 2013 Joel Birch. Dual licensed under the MIT and GPL licenses. http://users.tpg.com.au/j_birch/plugins/superfish/

All other files are copyright 2013 Iceable Media.

== TRANSLATIONS ==

Translating this theme into you own language is quick and easy, you will find a .POT file in the /languages folder to get you started. It contains about 40 strings only.
If you don't have a .po file editor yet, you can download Poedit from http://www.poedit.net/download.php - Poedit is free and available for Windows, Mac OS and Linux.

If you have translated this theme into your own language and are willing to share your translation with the community, please feel free to do so on the forums at http://www.iceablethemes.com
Your translation files will be added to the next update. Don't forget to leave your name, email address and/or website link so credits can be given to you!

== CHANGELOG ==

= 1.1.4 =
October 21st, 2013
* Translation information in readme.txt
* Added: Option to use a text-based site title instead of a logo
* Fixed: inconsistent logo padding

= 1.1.3 =
October 14th, 2013
* Updated: sticky posts styling
* Updated: minor enhancements to some HTML tags formattings
* Updated: now enqueuing style.css, allowing users to easily add their own CSS rules
* Fixed: default sidebar display (when no widgets are set) in page.php
* Fixed: only display category icon in postmeta when a category is set (fix for attachment pages)
* Added: image navigation links on attachment pages
* Updated POT file
* Added: esc_url() used with home_url() in header.php
* Added: tracking tag on link to Silverclean Pro for statistics
* Tested with WP 3.6.1

= 1.1.2 =
July 1st, 2013
* Fixed: issues with image alignments.
* Tested with WP 3.5.2

= 1.1.1 =
May 31, 2013
* Patched a little glitch in option framework (causing minor issues on new installations)
* Patched an issue with custom header display setting on new installations and homepage

= 1.1 =
May 24th, 2013
* Revision, enhancement and clean up of the whole code, in accordance with WP best practices
* Removed the slider which was using CPT (considered plugin territory by the WPTRT)
* Replaced the slider with WP custom header implementation
* Ability to show/hide custom header on front page, blog index, single posts and individual pages

= 1.0.5 =
May 2nd, 2013
* Fixed: Changed license to GPLv2 for improved compatibility
* Fixed: Escaping user-entered data before printing
* Fixed: Appropriately prefixed all custom functions
* Removed: Unnecessary enqueuing of jQuery
* Removed: Unnecessary use of function_exist() conditional
* Removed: Unnecessary use of dynamic css
* Removed: Unused images files from the option framework
* Updated: Author URI

= 1.0.4 =
April 18th, 2013
* Fixed: PHP notice upon first activation on a new instalation.

= 1.0.3 =
April 18th, 2013
* Fixed: PHP notice upon activation when upgrading from 1.0.1
* Fixed: Further enhancement to Icefit Improved Excerpt to preserve styling tag without breaking the markup

= 1.0.2 =
April 16th, 2013
* Added: Option to choose what content to display on blog index pages (Full content, WP default excerpt or Icefit improved excerpt)
* Added: Option to activate the slideshow on blog index pages
* Added: Support for optional captions for slides
* Added: /languages folder with default po and mo files and POT file for localization
* Fixed: Icefit Improved Excerpt processing was breaking the markup in some situations
* Changed: Updated Theme URI to Silverclean Lite demo site

= 1.0.1 =
March 14th, 2013
* Added: No-JavaScript fallback for theme options.
* Changed: default logo is more generic, with no text.
* Changed: Updated Theme and Author URI
* Changed: Updated readme.txt

= 1.0 =
March 6th, 2013
* Initial release