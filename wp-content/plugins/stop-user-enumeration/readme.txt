=== Fullworks WP VPS Security ===
Contributors: fullworks
Tags: User Enumeration, Security, WPSCAN, fail2ban,
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4EMTVFMKXRRYY
Requires at least: 3.4
Tested up to: 4.8.1
Stable tag: 1.3.10
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Secure your site against hacking attacks such as User Enumeration
== Description ==

Fullworks WP VPS Security is plugin built to help protect VPS and Dedicated Servver installations of WordPress, butr also can be used happily on Shared Hosting accounts.

The primary feature is Stop User Enumeration, a feature that detects your WordPress usernames from being enumerated by hackers.

User Enumeration is a type of attack where nefarious parties can probe your website to discover your login name. This is often a pre-cursor to brute-force password attacks. Stop User Enumeration helps block this attack and even allows you to log IPs launching these attacks to block further attacks in the future.

As the attack IP is logged you can use (optional additional configuration) fail2ban to block the attack directly at your server's firewall, a very powerful solution for VPS owners to stop brute force attacks as well as DDoS attacks.

Since WordPress 4.5 user data can also be obtained by API calls without logging in, this is a WordPress feature, but if you don't need it to get user data, this
plugin will restrict and log that too.

The plugin collects attack data for analysis.


== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. If needed to change defaults settings, visit the settings page

== Frequently asked questions ==

= It doesn't seem to work! ==
Are you logged in?  This plugin won't do anything for logged in users, it only works when you are logged out. A common mistake is to install the plugin and test it, while still logged in as admin.
= Are there any settings? =
Yes, but the default ones are fine for most cases
= Will it work on Multisite? =
Yes
= Why don't I just block with .htaccess =
A .htaccess solution may suffice, but most published do not cover POST blocking, REST API blocking and still allow admin users access.
= Does it break anything? =
If a comment is left by someone just giving a number that comment would be forbidden, as it is assume a hack attempt, but the plugin has a bit of code that strips out numbers from comment author names
= Do I need fail2ban for this to work? =
No, but fail2ban will allow you to block IP addresses at your VPS firewall that attempt user enumeration.
= What do I do with the fail2ban file?=
You only need this if you are using Fail2Ban.
Place  the file wordpress-userenum.conf in your fail2ban installation's filter.d directory.
edit your jail.local  to include lines like
`[wordpress-userenum]
enabled = true
filter = wordpress-userenumaction   = iptables-allports[name=WORDPRESS-USERENUM]
           sendmail-whois-lines[name=WORDPRESS-USERENUM, dest=youremail@yourdomain, logpath=/var/log/messages]
logpath = /var/log/messages
maxretry = 1
findtime = 600
bantime = 2500000`
Adjusted to your own requirements.

== Pro ==

Pro features coming soon.

== Changelog ==

= 1.3.10 =

Fixed unused javascript & css in settings page

= 1.3.9 =

Added language settings to allow translation.

Sanitized text being written to syslog

Closed potential REST API bypass

= 1.3.8 =

Security fix to stop XSS exploit

Also coded so should work with PHP 5.3 - although PHP 5.3. has been end of life for over two years it seems some hosts still use this. This is a security risk in its own right and
sites using PHP 5.3 should try to upgrade to a supported version of PHP, but this change is for backward compatibility.

= 1.3.7 =

Fix to allow deprecated PHP Version 5.4 to work, as 5.4 seems to still be in common use despite end of life

Note this code wont work on PHP 5.3

= 1.3.6 =

Fix PHP error

= 1.3.5 =

* full rewrite
* Changed detection rules to stop a reported bypass
* Added detection and suppression of REST API calls to user data
* Added settings page to allow REST API calls or stop system logging as required
* Added code to remove numbers from comment authors, and setting to turn that off

= 1.3.4 =

* Simplify code and deal with undefined request and other argument issues
= 1.3.3 =

* Correct issue of undefined index in certain conditions
= 1.3.2 =

* Added donate link to plugin listing
= 1.3.1 =

* code improvement  from Thomas van der Westen

= 1.2.8 =

* bug fix to allow comments to use author in url

= 1.2.8 =

* allow comments to use author in url

= 1.2.7 =

* bug fix to POST protection

= 1.2.6 =

* bug fix to POST protection

= 1.2.5 =

* Added protection against bypass using null bytes  (thanks to vunerbality identification and solution by cvcrcky )
* Added protection angainst POST bypass (thanks to vunerbaility identification by urbanadventurer and solution ideas from Ov3rfly and Malivuk )


= 1.2.4 =

* Added code to check whether not admin (to stop admin features failing) and changed trailing slash code to trap situation where not posts are found and user is displayed in title


= 1.2.3 =


* Fixed bug that stopped export in admin

= 1.2.2 =

* Added code to stop bypassing the check when a trailing slash is added

= 1.2.1 =
* minor change to handle a specific php issue with a certain version



= 1.1 =

* added close log
* corrected call to wp die

= 1.0 =
*  first release

== Upgrade notice ==
