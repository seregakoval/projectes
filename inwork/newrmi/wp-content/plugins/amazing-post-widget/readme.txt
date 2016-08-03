=== Amazing Posts Widget ===
Contributors: faugro
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TCP69QNH4X5EJ
Tags: widget, posts, post, thumbnails, custom post types
Requires at least: 3.4
Tested up to: 3.9
License: GPL2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display Posts on widget with amazing way, It's really suitable with your blog or portfolio.

== Description ==

This widget is combining and inspired by two great plugin, recent post flexslider and flexible posts widget, but using different slider. We use liquidslider that fit with this widgets purpose. 

= Features & options =

* Customizable widget title
* Get posts using either a selectable category or custom post type.
* Set the number of page displayed (using slider).
* Set the number of columns and row per page displayed.
* Easily set your own image width and height.
* Set the padding for each post.
* Select the sort orderby: Date, ID, Title, Menu Order, Random and sort order: ASC or DESC.

= Shortcode =
Example Use: [pj_apw post_title="true" excerpt_length="50" categories="all" thumbnail="true" img_width="250" img_height="150" rows="2" columns="1" pages_number="2" template="amaz-columns.php"]

Check out our demo : 
1. <a href="http://themeforest.net/item/raddin-elegant-responsive-wordpress-themes/6568509?ref=hainug" target="_blank">demo1</a><br />
2. <a href="http://wp.themesoul.com/nyirok/" target="_blank">demo2</a>

Work great with <a href="http://wordpress.org/plugins/siteorigin-panels/">Page Builder by SiteOrigin</a>

If you get an error after updating this plugin, please go to appearance > widget > and just save it, 
or if you need to edit the padding, you may edit it first, than save it.


== Installation ==

1. Upload the `amazing-pw` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to 'Appearance' > 'Widgets' and place the widget into a sidebar to configure it.



== Changelog ==

= 1.1.0 =
* Added Post Padding Option.

= 1.0.10 =
* Fixed Bug, hide slide title.

= 1.0.9 =
* Fixed Bug due to missused ob.

= 1.0.8 =
* Fixed Float Bug, when the number of page is 1 or not use slider.
* Added shortcode "this feature is still in beta".

= 1.0.7 =
* Fixed Bug with siteorigin panel.

= 1.0.6 =
* Add alternative enqueue script.

= 1.0.5 =
* Put enqueue script function inside add_action.

= 1.0.4 =
* Added enqueue jquery, fixed bug if theme not load jquery.

= 1.0.3 =
* Added ignore sticky post code.

= 1.0.2 =
* Fixed bug, enqueue jquery easing (sorry, i forget to add this on 1.0.1 version), it will work great now.

= 1.0.1 =
* Replace background-image for slider navigation with background-color
* Add responsive css code, will show only 1 column on small device

= 1.0.0 =
* First public release