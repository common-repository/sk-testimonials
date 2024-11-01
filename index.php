<?php
/*
Plugin Name: SK Testimonials
Plugin URI: http://spottedkoi.com/plugins/sk-testimonials
Description: Testimonials plugin that uses the core WordPress functionality to store and display plugins, loosely based on the feature set of the unsupported ltw_testimonials plugin.
Version: 1.16
Author: Spottedkoi LLC
Author URI: http://spottedkoi.com
*/

//setting a global variable for reuse when we refer to the sk_testimonials CPT
define('SKT_UNIQUE_NAME', 'sk_testimonials');
define('SKT_TAXONOMY', 'testimonial-group');
define('SKT_VERSION', 1.4);

//bring in plugin shared functions
require_once 'skt_functions.php';

//all the wp system modifications and calls
require_once 'skt_system.php';

//all the plugin admin pages
require_once 'skt_admin.php';

//everything that outputs data
require_once 'skt_display.php';

/*
Plugin this code is loosely based on, some code borrowed or copied outright:
	http://www.lessthanweb.com/products/wp-plugin-ltw-testimonials
References used:
	http://codex.wordpress.org/Function_Reference/register_post_type
	http://codex.wordpress.org/Function_Reference/register_widget
	http://codex.wordpress.org/Function_Reference/add_meta_box
	http://codex.wordpress.org/Plugin_API/Filter_Reference
	http://adambrown.info/p/wp_hooks/
	http://wordpress.org/support/topic/add-id-column-to-custom-taxonomy-admin-display-1
	http://codex.wordpress.org/Function_Reference/add_submenu_page
	http://codex.wordpress.org/Function_Reference/get_the_taxonomies
	http://codex.wordpress.org/Global_Variables
	http://codex.wordpress.org/Function_Reference/is_active_widget
	http://codex.wordpress.org/Function_Reference/wp_enqueue_style
	http://clark-technet.com/2010/01/wordpress-theme-developers-tip-call-dynamic-css-the-right-way
	http://ottopress.com/2010/dont-include-wp-load-please/
	http://codex.wordpress.org/Function_Reference/get_terms
	http://codex.wordpress.org/Function_Reference/get_post_custom
	http://codex.wordpress.org/Class_Reference/WP_Query
	http://adambrown.info/p/wp_hooks/hook/%7B$new_status%7D_%7B$post-%3Epost_type%7D
	http://www.rlmseo.com/blog/wordpress-post-variable-quick-reference/
	http://www.leewillis.co.uk/wordpress-custom-post-type-theming-is-broken/
	http://stackoverflow.com/questions/4647604/wp-use-file-in-plugin-directory-as-custom-page-template/4975004#4975004
	http://codex.wordpress.org/Using_Gravatars
	http://codex.wordpress.org/Custom_Queries
*/
?>