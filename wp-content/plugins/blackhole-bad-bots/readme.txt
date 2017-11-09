=== Blackhole for Bad Bots ===

Plugin Name: Blackhole for Bad Bots
Plugin URI: https://perishablepress.com/blackhole-bad-bots/
Description: Protects your site against bad bots by trapping them in a blackhole.
Tags: anti-spam, bots, honeypot, security, whois,  antispam, anti spam, bad bots, ban, blacklist, block, ip, protect, robots, robots.txt, spam, spider, trap
Author: Jeff Starr
Contributors: specialk
Author URI: https://plugin-planet.com/
Donate link: https://m0n.co/donate
Requires at least: 4.1
Tested up to: 4.8
Stable tag: 1.7.1
Version: 1.7.1
Text Domain: blackhole-bad-bots
Domain Path: /languages
License: GPL v2 or later

Protect your site against bad bots by trapping them in a virtual blackhole.



== Description ==

Add your own virtual Blackhole trap for bad bots. The Blackhole plugin includes a hidden link to your pages. You then add a line to your robots.txt file that forbids bots from following the hidden link. Bots that ignore or disobey your robots rules will crawl the link and fall into the honeypot trap. Once trapped, bad bots are denied further access to your WordPress-powered website.

I call it the "one-strike" rule: bots have one chance to obey your site's robots.txt rule. Failure to comply results in immediate banishment. The best part is that the Blackhole only affects bad bots: human users never see the hidden link, and good bots obey the robots rules in the first place. Win-win! :)

_Using a caching plugin? Check out the [Installation notes](https://wordpress.org/plugins/blackhole-bad-bots/installation/) for important info._



**Features**

* Easy to set up
* Squeaky clean code
* Focused and modular
* Born of simplicity, no frills
* Lightweight, fast and flexible
* Built with the WordPress API
* Works with other security plugins
* Easy to reset the list of bad bots
* Easy to delete any bot from the list
* Blackhole link includes "nofollow" attribute
* Plugin options configurable via settings screen
* Works silently behind the scenes to protect your site
* Whitelists all major search engines to never block
* Focused on flexibility, performance, and security
* Email alerts with WHOIS lookup for blocked bots
* Complete inline documentation via the Help tab
* Provides setting to whitelist any IP addresses
* Customize the message displayed to bad bots ;)
* One-click restore plugin default options

Blackhole for Bad Bots protects your site against bad bots, spammers, scrapers, scanners, and other automated threats.

_Not using WordPress? Check out the [standalone PHP version of Blackhole](https://perishablepress.com/blackhole-bad-bots/)!_

_[Pro version now available &raquo;](https://plugin-planet.com/blackhole-pro/)_



**Whitelist**

By default, this plugin does NOT block any of the major search engines:

* AOL.com
* Baidu
* Bingbot/MSN
* DuckDuckGo
* Googlebot
* Teoma
* Yahoo!
* Yandex

These search engines (and all of their myriad variations) are whitelisted. They always are allowed full access to your site, even if they disobey your robots.txt rules. This list can be customized in the plugin settings.

_Header Image Courtesy NASA/JPL-Caltech._



== Screenshots ==

1. Blackhole Settings Screen (showing default options)
2. Blackhole Bad Bots Screen (showing some example bots)



== Installation ==

**Installing Blackhole for Bad Bots**

1. Upload the Blackhole plugin to your blog and activate
2. Visit the Blackhole Settings and copy the Robots Rules
3. Add the Robots Rules to your site's robots.txt file
4. Configure the Blackhole Settings as desired and done

For complete documentation, click the "Help" tab in the upper-right corner of the Blackhole settings screen. Help tab also available on the "Bad Bots" screen.

[More info on installing WP plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)



**No robots.txt?**

If your site does not have a robots.txt file, you can create one as follows:

1. Add a blank text file to the root directory of your site
2. Name the text file, robots.txt and upload to your server

Done. See the next section to learn more and validate your robots.txt file.



**Robots Tools & Info**

* [Learn more about robots.txt](http://www.robotstxt.org/)
* [Validate your robots.txt file](http://www.lxrmarketplace.com/robots-txt-validator-tool.html)
* [Validate robots.txt in Google Webmaster Tools](https://www.google.com/webmasters/tools/robots-testing-tool)



**Caching Plugins**

Blackhole for Bad Bots is not yet tested with all caching plugins and scripts. So it may not be compatible with all of them. Here is a list of known compatible caching plugins/scripts and the steps required for full compatibility:

* WP Fastest Cache
* Siteground SG SuperCacher plugin
* Probably others: [report another cache plugin](https://perishablepress.com/contact/)

If you are using a caching plugin, follow these steps:

* Add the Blackhole URL (available via the "Robots Rules" setting) to the cache plugin's "ignore" list
* Add the IP(s) of your site, proxy server, cache plugin, etc. to the Blackhole setting, "Whitelisted IPs"
* Also check out the [whitelist tutorial](https://plugin-planet.com/blackhole-pro-whitelist-plugins/) for more information

If none of those tricks work, it's recommended to deactivate the plugin. Please test thoroughly (refer to next section for more infos).



**Testing**

To test that the Blackhole trap is working, view the source code of any web page on your site. Scroll down near the footer of the page until you locate a link that looks similar to the following:

	<a rel="nofollow" style="display:none;" href="https://example.com/?blackhole=1234567890" title="Blackhole for Bad Bots">Do NOT follow this link or you will be banned from the site!</a>

Click the link (the `href` value) to view the Warning Message. After visiting the Warning Message, refresh the page to view the Access Denied message. And/or visit any other page on the front-end of your site to verify that you have been banned. But don't worry, you will never be banned from the WP Admin Area or the WP Login Page. So simply log in and remove your IP address from the Bad Bots list to restore front-end access. 



**Whitelisted Bots**

Blackhole for Bad Bots is rigorously tested to ensure that the top search engine bots are NEVER BLOCKED. Any bots reporting a User Agent that contains any of the following strings will always have access to your site, even if they disobey robots.txt.

	aolbuild, baidu, bingbot, bingpreview, msnbot, duckduckgo, adsbot-google, googlebot, mediapartners-google, teoma, slurp, yandex

Of course, this list is completely customizable via the plugin settings. Each added string is matched against the full user agent, so be careful. Learn more about [user agents of the top search engines](https://perishablepress.com/list-all-user-agents-top-search-engines/).

You can also whitelist bots by IP address. Visit the setting, "Whitelisted IPs", and enter the IP address (separate multiple IPs with commas). You can also whitelist entire ranges of IPs. In the same plugin setting, add something like this:

	123.456.

That will allow all bots reporting any IP that begins with `123.456.`. You can also whitelist IP addresses using CIDR notation. Check out the Help tab on the plugin settings page for details.



**Customizing**

Blackhole provides plenty of hooks for customizing and extending:

	blackhole_options
	blackhole_badbots
	blackhole_get_options
	blackhole_get_badbots
	blackhole_log_data
	blackhole_trigger
	blackhole_vars
	blackhole_log
	blackhole_ip_keys
	blackhole_alert_name
	blackhole_alert_subject
	blackhole_alert_message
	blackhole_alert_headers
	blackhole_needle
	blackhole_message_default
	blackhole_message_custom
	blackhole_message_nothing
	blackhole_ignore_loggedin
	blackhole_ignore_backend
	blackhole_ignore_login
	blackhole_block_status
	blackhole_block_protocol
	blackhole_block_connection
	blackhole_ip_filter
	blackhole_settings_contextual_help
	blackhole_badbots_contextual_help

If you need a hook added, [drop me a line](https://perishablepress.com/contact/), will be glad to hook it up ;)



**Custom Warning Template**

The Blackhole displays two types of messages:

* Warning Message - Displayed when bots follow the blackhole trigger link
* Blocked Message - Displayed for all requests made by blocked bots

The Blocked Message may be customized via the plugin settings. The Warning Message may be customized by setting up a custom template:

1. Copy `blackhole-template.php` from the plugin's `/inc/` directory
2. Paste the file into your theme template, for example: `/wp-content/my-awesome-theme/blackhole-template.php`
3. Customize any of the markup between "BEGIN TEMPLATE" and "END TEMPLATE"
4. Upload to your server and done

If the custom template exists in your theme directory, the plugin automatically will use it to display the Warning Message. If the custom template does not exist in your theme directory, the plugin will fallback to the default warning message.



_[More options available in the Pro version &raquo;](https://plugin-planet.com/blackhole-pro/)_



**Uninstalling**

Blackhole for Bad Bots cleans up after itself. All plugin settings and the bad bot list will be removed from your database when the plugin is uninstalled via the Plugins screen.



== Upgrade Notice ==

To upgrade Blackhole for Bad Bots, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

Note: uninstalling the plugin from the WP Plugins screen results in the removal of all settings and data from the WP database. 



== Frequently Asked Questions ==

**What other security plugins do you recommend?**

I recently recorded a video tutorial series for Lynda.com on [how to secure WordPress sites](https://m0n.co/securewp). That's a good place to learn more about the best techniques and WP plugins for protecting your site against threats.

**How is this plugin different than a firewall?**

Blackhole uses its own "smart bot technology" that only blocks bots if they have demonstrated bad behavior. Firewalls typically are "static" and block requests based on a predefined set of patterns. That means that firewalls sometimes block legitimate visitors. Blackhole never blocks regular visitors, and only it blocks bots that disobey your site's robots.txt rules. So the rate of false positives is close to zero.


**The trigger link is not appearing in the source code of my pages.**

In order for the plugin to add the trigger link to your pages, your theme must include the template tag, `wp_footer()`. This is a recommended tag for all WordPress themes, so your theme should include it. If not, you can either add it yourself or contact the theme developer and ask for help. Here is [more information about wp_footer()](https://codex.wordpress.org/Function_Reference/wp_footer). Once the footer tag is included, the plugin will be able to add the trigger link to your pages.


**Will this block good bots like Google and Bing?**

No. Never. All the major search engine bots are whitelisted and will never be blocked. Unless you remove them from the whitelist setting, which is not recommended.


**I think the plugin is blocking Chrome, Firefox, etc.?**

Impossible because the plugin never blocks by user agent. It only blocks by IP address. No other criteria are used to block anything.


**Is it possible to block some bots by just adding them to blocked list and deny them Access to my website?**

Not possible with the free version, but the [Pro version](https://plugin-planet.com/blackhole-pro/) includes an easy way to add bots manually (via the Bad Bot Log).


**How do I add other bots to the whitelist?**

Visit the plugin settings and add to the list.


**How do I reset the list of blocked bots?**

Visit the plugin settings and click the button.


**How do I delete the example/default bot from the log?**

Not possible with the free version, but can do with the [Pro version](https://plugin-planet.com/blackhole-pro/).


**How can I disable the email alerts?**

Visit the plugin settings and click the button.


**Is there a standalone version of the Blackhole?**

Yes. Visit Perishable Press to download a [PHP-based version](https://perishablepress.com/blackhole-bad-bots/) that does not require WordPress.


**Is there a Pro version of Blackhole?**

Yes, the [Pro version](https://plugin-planet.com/blackhole-pro/) is available at Plugin Planet.


**Is Multisite supported?**

Not yet, but it's on the to-do list.


**Can I manually include the blackhole link?**

Yes, you can add the following code anywhere in your theme template:

`<?php if (function_exists('blackhole_trigger')) blackhole_trigger(); ?>`


**Should whitelisted bots contain exact names, or can I just use partial names?**

You can use partial names or full names, depending on how specific you would like to be with blocking. If you look at the default whitelisted bot strings, you will see that they are just portions of the full user agent. So for example you can block all bots that include the string "whateverbot" by including that string in the whitelist setting. It makes it easier to block bots, but you have to be careful about false positives.


**What about WordPress automatic (hidden) robots.txt?**

By default, WordPress will automatically serve a hidden, "virtual" robots.txt file to anything that requests it. Once you add your own "real" robots.txt file, WordPress will stop generating the virtual one. So when it comes to WordPress and robots.txt, real trumps virtual. Blackhole Pro requires that you add some rules to an actual robots.txt file, but it does not create/add any robots rules or the robots.txt file for you. Check out the plugin's Help tab for more infos.


**Which WP caching plugins are compatible with Blackhole?**

Blackhole for Bad Bots is not yet tested with all caching plugins and scripts. So it may not be compatible with all of them. Here is a list of known compatible caching plugins and the steps required for full compatibility:

* WP Fastest Cache — Add the blackhole trigger URL to the cache ignore list
* [Report another caching plugin](https://perishablepress.com/contact/)

If you are using a caching plugin or script, and Blackhole isn't working, you can try one of the the following solutions:

* Add the blackhole URL (available via the "Robots Rules" setting) to your caching plugin's "ignore" list
* Add the IP(s) of your caching script or load balancer to the Blackhole setting, "Whitelisted IPs"

If neither of those tricks work, it's recommended to deactivate the plugin. Please test thoroughly (for more info, refer to the "Testing" section in the readme.txt).



**Got a question?**

Send any questions or feedback via my [contact form](https://perishablepress.com/contact/)



== Support development of this plugin ==

I develop and maintain this free plugin with love for the WordPress community. To show support, you can [make a cash donation](https://m0n.co/donate), [bitcoin donation](https://m0n.co/bitcoin), or purchase one of my books: 

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)

And/or purchase one of my premium WordPress plugins:

* [BBQ Pro](https://plugin-planet.com/bbq-pro/) - Pro version of Block Bad Queries
* [Blackhole Pro](https://plugin-planet.com/blackhole-pro/) - Pro version of Blackhole for Bad Bots
* [SES Pro](https://plugin-planet.com/ses-pro/) - Super-simple &amp; flexible email signup forms
* [USP Pro](https://plugin-planet.com/usp-pro/) - Pro version of User Submitted Posts

Links, tweets and likes also appreciated. Thanks! :)



== Changelog ==

**1.7.1 (2017/08/13)**

* Replaces `wp_doing_cron()` with direct check for `DOING_CRON`
* Tests on WordPress 4.9 (alpha)

**1.7 (2017/07/29)**

* Adds support for CIDR notation for whitelisted IPs
* Adds function to ignore command-line requests
* Adds logic to ignore WP-Cron requests
* Updates contextual help (Help tab)
* Tests on WordPress 4.9 (alpha)

**1.6 (2017/04/09)**

* Updates default IP keys
* Adds some missing translation strings
* Auto-adds server IP to whitelist settings
* Adds French translation (thanks to Bouzin)
* Adds filter for IP keys, `blackhole_ip_keys`
* Adds meta noindex, nofollow to blackhole page
* Replaces global `$wp_version` with `get_bloginfo('version')`
* Enhances default character set for whois lookup
* Regenerates default translation template
* Tests on WordPress version 4.8

**1.5 (2017/03/08)**

* Fixes some incorrect translation strings
* Adds some style to the Robots Rules setting
* Adds complete contextual help (via the Help tab)
* Adds info about the default bot to the Bad Bots screen
* Replaces delete link with blackhole icon for default bot
* Removes line breaks from plugin-activation warning messages
* Replaces `admin_url()` with `admin_url('plugins.php')` for activation warning
* Replaces `get_template_directory` with `get_stylesheet_directory`
* Updates plugin links on the WP Plugins screen
* Adds default option for `ip_whitelist` setting
* Adds option to set the address for the "From" email header
* Improves loading of PHP include files
* Changes link text for clearing list of bad bots
* Adds new action hook: `blackhole_settings_contextual_help`
* Adds new action hook: `blackhole_badbots_contextual_help`
* Refines the Settings and Bad Bots screens
* Improves logic for script/style enqueue
* Adds blurb about Pro version
* Generates new translation template
* Tests on WordPress version 4.8 (alpha)

**1.4 (2016/11/14)**

Important: if you are upgrading from a previous version and are using a Custom Warning Template, please move it to your theme directory. Otherwise it will be deleted when you upgrade the plugin. Check out the "Custom Warning Template" section under the [Installation documentation](https://wordpress.org/plugins/blackhole-bad-bots/installation/) for more information.

* Fixes missing settings notices via settings_errors
* Adds strong tags to admin notices
* Changes directory for custom warning template
* Removes the `/custom/` directory
* Removes Save Changes button from Bad Bot screen
* Updates some default settings page styles
* Changes stable tag from trunk to latest version
* Adds `&raquo;` to rate plugin link on Plugins screen
* Improves escaping for localization tags
* Updates URl for rate this plugin link
* Tests on WordPress version 4.7 (beta)

**1.3.1 (2016/08/11)**

* Fixes bug with IP-address whitelisting
* Fixes bug with user-agent whitelisting
* Makes a small change to settings label
* Generates new translation template

**1.3 (2016/08/08)**

* Updates [WP Admin Notices](https://digwp.com/2016/05/wordpress-admin-notices/)
* Replaces `_e()` with `esc_html_e()`
* Replaces `__()` with `esc_html__()`
* Removes unnecessary `settings_errors()`
* Renames text domain from "bbb" to "blackhole-bad-bots"
* Renames `/lang/` directory to `/languages/`
* Updates `load_i18n()`
* Refines `blackhole_callback_robots()`
* Fixes bug in `blackhole_whois()`
* Improves performance by eliminating redundant whois lookup
* Adds new hook to filter IP address validation: `blackhole_ip_filter`
* Improves IP address handling (adds three new IP-related functions)
* Improves readability of whois email notifications
* Adds "Whitelisted IPs" setting
* Adds a rate this plugin link
* Tests on WordPress 4.6

**1.2 (2016/03/28)**

* Updates URL for BBB_HOME
* Tweaks display of "Blocked Bots" in plugin settings
* Tests on WordPress 4.5 beta

**1.1 (2016/02/22)**

* Adds "baidu" to the search engine whitelist
* Adds credit to documentation for header image

**1.0 (2016/02/22)**

* Initial release


