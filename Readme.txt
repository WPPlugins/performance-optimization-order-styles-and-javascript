=== Plugin Name ===
Contributors: satya61229
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JCVH4RPHL4P5G
Tags: speed, optimization, performance, CSS, Style, JavaScript, Script, plugin
Requires at least: 2.0.2
Tested up to: 3.6
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Ordering StyleSheet and JavaScript (external and inline) for performance optimization.

== Description ==

Did you ever read about Optimization of website/blog through ordering styles and Scripts in head section? 
If you like your website load in browser as quickly as possible then you may have read in performance optimization tips that 
you should move all CSS files on top and script at last in HTML head section &lt;head&gt;&lt;/head&gt;.

How do you order those calls? If you are manually putting CSS and JavaScript files in head section (&lt;head&gt;&lt;/head&gt;),
then you can do this very easily. Just modify once and optimization for this is over. 
What if you are using plugins and that are adding calls to JavaScript and CSS files dynamically. This is case of Wordpress blog,
where we use many plugins and those plugins add various Styles and Script files dynamically from wp_head() call.

If above lines, do not makes much sense to you then probably you have not 
read this documentation on <a href="http://code.google.com/speed/page-speed/docs/rtt.html#PutStylesBeforeScripts">Google</a>.

The plugin will also collect different inline scripts to one place. Thus making the source code
look better.

To check, if the plugin is doing anything or not, compare the Head section before and after 
activating the plugin. 

(For reading more details discussion, follow the Plugin link on right side.)

[Author (satya61229) About page on WP](http://profiles.wordpress.org/satya61229)


== Installation ==

1. Donwload the plugin from Wordpress Plugin Directory (http://wordpress.org/extend/plugins/)
2. Upload `order-styles-js.php` to the `/wp-content/plugins/` directory
3. Active the plugin
4. Add the following lines of codes at header.php file where you see &lt;head&gt; section.
You need to add only PHP lines given below. HTML code is for demonstration purpose only. 
Mime type "UTF-8" is my mime type. Mention your mime type meta tag. It will just there cut and paste just after 
Head section. If "Content-Type" is not available (suppose) in your Wordpress header.php file, 
then no worry, you can add the 1st part just after &lt;head&gt;.
   
&lt;head&gt;

&lt;meta http-equiv="Content-Type" content="&lt;?php bloginfo('html_type'); ?&gt;; charset=&lt;?php bloginfo('charset'); ?&gt;" /&gt;

`<?php
// 1. After Head start section
if (function_exists('orderStyleJS')) {
	orderStyleJS( 'start' );
}
?>`

&lt;!-- blah blah - any other meta element. Stylesheet - External JavaScript - Internal Js --&gt;

&lt;!-- blah blah - any other meta element. Stylesheet - External JavaScript - Internal Js --&gt;

`<?php
// 2. Just before Head close section
if (function_exists('orderStyleJS')) {
	orderStyleJS( 'end' );
}
?>`

&lt;/head&gt;

== Frequently Asked Questions ==

= Is this plugin useful for every wordpress installation? = 
This plugin should work in any Wordpress version. However, I will recommend using it to only those Wordpress installation where any caching system is in use. Remember, every code takes resources even if it is smaller. My code is not an exception. So, if you are using any caching system then the plugin code need not run every time a request is made for a page on your website/blog.



== Changelog ==

= 1.1 =

Just a ReadMe Refresh to tell WP that everything is still fine and work perfectly. 

= 1.0 =

* Correction in Readme.txt file. 
* Removed empty script tags coming in case there was no inline script in head section.
* Bug fixed when there was an style (&lt;style&gt;&lt;/style&gt;) tag inside head section.

= 0.5 =

* Order external stylesheets files and External and Internal JS


== Upgrade Notice ==

= 1.0 =

* Removes the empty Script tag you may be getting in case you do not have any inline script in Head section.
* Correction in Readme.txt file.
* Bug fixed when there was an style (&lt;style&gt;&lt;/style&gt;) tag inside head section.