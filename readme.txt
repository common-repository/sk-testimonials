=== SK Testimonials ===
Contributors: wprelief
Donate link: http://spottedkoi.com/
Tags: testimonials, business testimonials
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.16.1

The SK Testimonials Plugin allows you to list and display Testimonials on your site.  You can list them in any order, by groups, through widgets or shortcodes. You have full functionality to how your testimonials are built and displayed. 

== Description ==

The SK Testimonials Plugin allows you to list and display Testimonials on your site.  You can list them in any order, by groups, through widgets or shortcodes. You have full functionality to how your testimonials are built and displayed. 

1. Easy To Manage
1. Easy To Add and Edit
1. Contextual Help Documentation in the WordPress admin
1. Widgets, Shortcodes, and Template Tags
1. Display and design management
1. Global Settings for output
1. Testimonials show up in /testimonials/ on your site
1. Testimonial slugs use the business and customer name
1. Custom Template files can be overridden by placing files called index-testimonial.php or single-testimonial.php in your theme
1. Image defaults to Gravatar's "Mystery Man"
1. Customize your slug away from "testimonials" to whatever you want, if you want
1. Cache your custom CSS for page speed load time optimization

== Installation ==

1. Upload the zip file through your plugins->add new screen OR Unzip the archive and upload the sk-testimonials directory via FTP to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. To configure your plugin settings, find the "Testimonials" menu item just under "Comments"

== Frequently Asked Questions ==

= Why are testimonials important? =

When you list out testimonials on your site, potential customers have the opportunity to read what your current customers are saying about you and your company.

= How do I override the included template files? = 

We included a couple files in the plugin called index-testimonial.php and single-testimonial.php.  These files handle the output of the testimonials so that your global design settings are considered when they are output to the screen. You can copy these files to your theme directory and then your versions will be used instead of the ones included with the plugin. 

Just make sure that you use the template tags included for outputting testimonials, otherwise your global display settings will not be considered.

== Screenshots ==

1. All of your testimonials functionality is in one place, allowing you the easiest management of your testimonial information.
2. Adding a new testimonial is as easy as adding a post or page and has many of the same features such as excerpts, featured images, the visual editor, groups, and display order management. Just make sure that you add the information about the person or company who submitted your testimonial.
3. Managing your testimonials has never been easier, because we tapped into the core WordPress methods for managing content. Your Testimonials act like posts!
4. There's help documentation in your site, so you have that information at your fingertips. If you ever need more help, we have a support forum ready and waiting for your questions.
5. Testimonial groups are added and managed easily and efficiently. You can assign testimonials a group so that you can display that group in specific places on your site.
6. Manage the layout and design (HTML and CSS) of your testimonials from the design page, without having to modify your theme!
7. Set defaults that apply site-wide, but that can be overridden anywhere you display testimonials.
8. The widget functionality allows you to put Testimonials anywhere there is a sidebar. You can set the display however you would like, including overriding the global display defaults for this widget.

== Changelog ==

= 1.16.1 =
* Added in the ability to add titles to your html output

= 1.16 = 
* Solved the group issue with groups not showing properly when selected in the shortcode.
* added the ability to change your slug for the testimonials
* added css caching ability with a testimonials setting

= 1.15 =
* Added in title control, for page title purposes. WordPress was defaulting the page titles to be "Auto Draft".  We will load a title in by default if the user doesn't enter one - to avoid "Auto Draft"

= 1.14 = 
* made a change for the SEO conscience people, from client-name_business-name to client-name-business-name
* removed the default CSS entry for 330px on the widget width

= 1.13 =
* Fixed an issue with the rand on the widget not going through
* set defaults for the widget in a couple places, for some reason they were not passing through properly
* fixed the widget count issue

= 1.12 = 
* Added a check for function_exists('get_the_post_thumbnail') to fix the issue for themes without that feature turned on.

= 1.11 = 
* Repaired a template redirect issue that could be causing some issues for users.

= 1.1 =
* Fixed issues with the widget display:
  * The counts were not working because of a variable misnomer
  * The categories were not working because of the same issue with counts
  * The before_widget, after_widget, before_title, and after_titles were not displaying correctly.

= 1.0 =
* Plugin created

== Upgrade Notice ==

= 1.16 =
* If you want to have the testimonial custom css be cached, for page speed improvements then make sure to change your cache settings in the testimonials settings page
* You can now change the testimonials slug from "testimonials" to anything you want now!