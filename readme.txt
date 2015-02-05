=== Cookie Message ===
Contributors: Jenst
Tags: cookie,cookies,message,notice
Requires at least: 4.1
Tested up to: 4.1
Stable tag: 1.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

EU cookie law message at the bottom of the screen.

== Description ==
Cookie Message plugin will on activation add a message at the bottom of your screen.

When clicking the button it will disapear. How long is for you to decide but default is forever. It will remember it by HTML5 localstorage, not by a cookie.

You have settings for information that goes into the message, colors, fonts and you can disable CSS and javascript if you need to. See screenshots for more information about the settings.

== Installation ==
1. Download from wp-admin plugin installer.
2. Set the settings at "Settings" > "Cookie Message"

== Frequently Asked Questions ==
= How are the settings saved? =
All settings are saved in one field in the option table.

= Can I get more styling options in the future? =
Probably not so much. I actually removed som options to make it smaller and easier to use. Use "Custom style" or disable CSS and set the style in your own theme files instead.

= What is the EU cookie law =
You need to inform every user that you are using cookies on your site. Google Analytics is probably the most used script that use cookies.

= The plugin does not work. What should I do? =
Look for javascript errors. Be sure there is not a localstorage variable set. If you clicked the button the message will not come back.

= How can I delete the localstorage variable? =
In wp-admin set the "Logged in" to "Enable" and reload the site. It will then delete the localstorage variable on every pageload if it exists.

== Screenshots ==
1. How it might look on your site
2. Message settings
3. Style settings
4. Advanced settings

== Changelog ==
1. 1.2 - Fixed CSS issue with z-index
2. 1.1 - Fixed CSS-bug
3. 1.0 - Initial release