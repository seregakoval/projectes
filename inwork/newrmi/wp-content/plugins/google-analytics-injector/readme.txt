=== Plugin Name ===

Contributors: hoyce
Donate link: 
Tags: google, google analytics, analytics, statistics, stats, javascript, web analytics, 
Requires at least: 3.0
Tested up to: 3.9
Stable tag: 1.1.3

== Description ==

Google Analytics Injector is a plugin which makes it easy for you to start collecting stats with Google Analytics on your WordPress blog. 
After the installation of the plugin you just click on the "Google Analytics Injector Settings" in the "Settings" menu and add your Google Tracking code (eg. UA-1111111-1) in the admin form.

To be sure the tracking code is not used on the wrong site you could restrict the usage by specifying the site url. This plugin also exclude the visits from the Administrator if he/she is currently logged in.

== Installation ==

Using the Plugin Manager

1. Click Plugins
2. Click Add New
3. Search for google-analytics-injector
4. Click Install
5. Click Install Now
6. Click Activate Plugin

Manually

1. Upload `google-analytics-injector` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.0 =
* Initial release

= 1.0.1 =
* Tested stability up to Wordpress 3.3.1
* Removed a PHP notice regarding an undifined index

= 1.1 =
* Updated the validation function for validating the Google Analytics tracking code.

= 1.1.1 =
* The plugin now exclude the visits from the Administrator. (bug fix)
* Tested stability up to Wordpress 3.8

= 1.1.2 =
* Added option for _setDomainName
* The plugin now exclude the visits from given restricted url. (bug fix)
* Tested stability up to Wordpress 3.8.1

= 1.1.3 =
* Added this plugin to Github https://github.com/hoyce/google-analytics-injector
* Tested stability up to Wordpress 3.9