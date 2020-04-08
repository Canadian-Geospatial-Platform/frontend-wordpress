=== Shortcodes Creator Ultimate ===
Contributors: cmorillas1
Donate link: https://www.paypal.me/CesarMorillas
Tags: shortcodes, ajax, php, code, injection, javascript, css
Requires at least: 4.6
Tested up to: 5.3.2
Requires PHP: 5.6
Stable tag: 4.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create all kind of custom shortcodes. They can include: html, php, javascript code, css code and file resources (including .js and .css files in the head section) and images and documents files to be used everywhere. It also can include code for make ajax calls.

== Description ==

A clean, powerful and lightweight way to generate and include custom shortcodes with:
*   HTML/PHP code.
*   CSS code.
*   Javascript code.
*   PHP backend code for Ajax calls.
*   CSS and Javascript files.
*   Other resources files: images, pdfs, ...

- The plugin doesn't interfere with the wordpress database. Nothing is wrote there. Very lightweight.
- Ajax calls are secured with nonces. (https://developer.wordpress.org/themes/theme-security/using-nonces/)
- Shortcodes can be inserted in post, pages, text widgets and html widgets.
- Shortcodes can be enabled/disabled individually.
- Custom CSS and Javascript files required for the shortcode are enqueued in the head section.
- Clean and efficient: Nothing about any saved shortcode is executed if the shortcode is not present in the current frontend page.
- Shortcodes can be used to inject some kind of php, javascript, css or ajax (php) code.
- Repository of already made shortcodes in the plugin page: <a href="http://shortcodescreator.com">http://shortcodescreator.com</a>

***** TIP ********
- Due to the flexibility of the shortcode creation, an invalid code can broke your site. If so, you can activate safe mode on a per-page basis by appending ?safe-mode=true to the URL. In this manner, it disables the execution of all the shortcodes created.

***** WARNING ******
All installed shortcodes will be permanently deleted if plugin is unistalled or updated. Please, backup all the shortcodes before.

***** WARNING AGAIN ******
If update the plugin, all shortcodes will be permanently removed. Please backup shortcodes before update the plugin.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress


== Frequently Asked Questions ==

= Where are the shortcodes stored ?

Shortcodes have a fixed files an directories structure. They are stored in plugins/ultimate-shortcodes-creator/shortcodes/ directory. All data is stored inside each shortcode directory. The name of the folder is the name of the [shortcode].

= Can I request a feature ? =

Yes, you can contact with me at cmorillas1@gmail.com.

= Will I lose my shortcodes if I change the theme or upgrade WordPress?

No, the shortcodes are stored in plugins directory and they are independent of the theme and unaffected by WordPress upgrades.

= Will I lose my shortcodes if I update the plugin?

Yes, because when Wordpress update any plugin the entire directory is removed. Please be careful with that.


== Screenshots ==

1. List of shortcodes.
2. Edition of a shortcode.
3. HTML/PHP edition tab.
4. JS edition tab.
5. Resources upload files tab.

== Changelog ==
***** WARNING AGAIN ******
If update the plugin, all shortcodes will be permanently removed. Please backup shortcodes before update the plugin.

= 1.9.2 =
* Fixed upload plugin error

= 1.9 =
* Support for remote install of predefined shortcodes

= 1.8 =
* Added support to import/export shortcodes
* Added support to backup/restore all shortcodes
* Changed menu name

= 1.1 =
* Minor changes.
* Fixed minor errors.

= 1.0 =
* Major update.
* Changed shortcode way: [scu name="shortcode_name"].

= 0.1 =
* First release.


== Upgrade Notice ==

***** WARNING AGAIN ******
If update the plugin, all shortcodes will be permanently removed. Please backup shortcodes before update the plugin.

= 1.9.2 =
* Fixed upload plugin error

= 1.1 =
* Since version 1.0 the plugin is re-coded.
* Changed shortcode way: [scu name="shortcode_name"].
* Please backup shortcodes before update.
* Fixed import/export via ftp.
* Shortcodes can be inserted in text and html widgets. 

