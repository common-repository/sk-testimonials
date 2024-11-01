<?php

//handle the installation and basic setup of this plugin
require_once 'skt_system/install-setup.php';

//handles all the setup and configuration of the Custom Post Type for Testimonials
require_once 'skt_system/cpt.php';

//adds all the functionality for the taxonomy
require_once 'skt_system/taxonomy.php';

//handles the widget code
require_once 'skt_system/widget.php';

//help text
require_once 'skt_system/help_content.php';

//handles the single testimonial output
require_once 'skt_system/theme-redirect.php';

//add new query variable to WP
function sk_testimonials_add_new_var_to_wp($public_query_vars) {
    $public_query_vars[] = 'skt_css';
    return $public_query_vars;
}
add_filter('query_vars', 'sk_testimonials_add_new_var_to_wp');

//handle outputting the testimonials CSS to a specific output request
function sk_testimonials_css_display() {
    $css = get_query_var('skt_css');
    if ($css == 'css'){
		header("Content-type: text/css");
		//load the main css from settings page
		$output = get_option('skt_default_css');
		echo $output;
        exit; //don't do anything else
    }
}
add_action('template_redirect', 'sk_testimonials_css_display');

//link to the generated CSS file in the header
function sk_testimonials_add_css() {
	$cssFile = plugin_dir_path(__FILE__).'css/skt.css';
	$customCssFile = plugin_dir_path(__FILE__).'css/skt_custom.css';
	
	//this allows for backwards compatibility of CSS files from < 1.16
	sk_testimonials_check_css_files();
	
	//check for custom_css file if it exists use it, otherwise default to the 
	if (get_option('skt_cache_css') == 1 && file_exists($customCssFile)) {
			$myStyleUrl = plugin_dir_url(__FILE__).'css/skt_custom.css';
	} else {
		$myStyleUrl = add_query_arg( 'skt_css', 'css', '/index.php');
	}

    wp_register_style('skt_styles', $myStyleUrl);
    wp_enqueue_style('skt_styles');
}
add_action('wp_enqueue_scripts', 'sk_testimonials_add_css');

// added to admin_init through skt_reg`ister_settings
function sk_testimonials_check_css_files() {
	$cssDir = plugin_dir_path(__FILE__).'css/';
	$filePerms = fileperms($cssDir);
	$customCssFile = plugin_dir_path(__FILE__).'css/skt_custom.css';
	if (get_option('skt_cache_css') == 1) {
		if (!is_writable($cssDir)) {
			add_action('admin_notices', 'sk_testimonials_css_dir_notification');
		} elseif (file_exists($customCssFile) && !is_writable($customCssFile)) {
			add_action('admin_notices', 'sk_testimonials_custom_css_not_writable');
		} elseif (get_option('skt_cache_css_mismatch') == 1) {
			//get the contents of the css option
			$cssDb = get_option('skt_default_css');
			//get the contents of the css file
			$cssFile = (file_exists($customCssFile) ? file_get_contents($customCssFile) : '');
			if ($cssDb != $cssFile || !file_exists($customCssFile)) {
				//try to create the file with the custom css
				$handle = fopen($customCssFile, 'w+');
				if ($handle !== false) {
					$writeStatus = fwrite($handle, $cssDb);
					if ($writeStatus === false) {
						//throw a writing error
						add_action('admin_notices', 'sk_testimonials_failed_writing_css_file');
					}
					fclose($handle);
				} else {
					//throw an error about writing this file
					add_action('admin_notices', 'sk_testimonials_failed_opening_css_file');
				}

				//do a normal notify that the css cache file was created
				add_action('admin_notices', 'sk_testimonials_created_css_notification');
			}
			update_option('skt_cache_css_mismatch', 0);
		}
	}	
}

function sk_testimonials_error($bold, $message) {
	echo "<div id='skt-message' class='error fade skt-notify ".(is_admin() ? 'sk-guide-is-admin' : '')."'><p><strong>".$bold."</strong><br />".$message."</p></div>";
}

function sk_testimonials_notify($bold, $message) {
	echo "<div id='skt-message' class='updated fade skt-notify ".(is_admin() ? 'sk-guide-is-admin' : '')."'><p><strong>".$bold."</strong><br />".$message."</p></div>";
	
}

function sk_testimonials_css_dir_notification() {
	$bold = "Your Testimonials CSS directory is not writable";
	$message = "The directory ".plugin_dir_path(__FILE__).'css/'." should be 777 for your custom css to be cached. <br />To make this error go away, change the permissions of the directory and reload any admin page or turn off testimonials css caching.";
	sk_testimonials_error($bold, $message);
}

function sk_testimonials_failed_opening_css_file() {
	$bold = "We failed to open the custom css file";
	$message = "The file ".plugin_dir_path(__FILE__).'css/skt_custom.css'." could not be opened for writing. Please check the permissions are 777 or consult your hosting provider for help.";
	sk_testimonials_error($bold, $message);
}

function sk_testimonials_failed_writing_css_file() {
	$bold = "We failed when attempting to write to your custom css file";
	$message = "File: ".plugin_dir_path(__FILE__).'css/'." could not be written to, please consult your hosting provider for help.";
	sk_testimonials_error($bold, $message);
}

function sk_testimonials_custom_css_not_writable() {
	$bold = "Your Testimonials Custom CSS file exists but is not writable.";
	$message = "The file ".plugin_dir_path(__FILE__).'css/skt_custom.css'." exists and should be 777 for your custom css settings to be cached. <br />To make this error go away, change the permissions of the file and reload any admin page or turn off testimonials css caching.";
	sk_testimonials_error($bold, $message);
}

function sk_testimonials_created_css_notification() {
	$bold = "We successfully created and/or wrote your testimonials custom css file";
	$message = "The file ".plugin_dir_path(__FILE__).'css/skt_custom.css'." was updated with your custom css options.";
	sk_testimonials_notify($bold, $message);
}

?>