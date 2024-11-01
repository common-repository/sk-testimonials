<?php
add_action("template_redirect", 'my_theme_redirect');

function my_theme_redirect() {
    global $wp;
    $plugindir = realpath(dirname(__FILE__).'/../');
    //A Specific Custom Post Type
    if (isset($wp->query_vars["post_type"]) && $wp->query_vars["post_type"] == SKT_UNIQUE_NAME) {
		if (isset($wp->query_vars["name"])) {
        	$templatefilename = 'single-testimonial.php';
        	if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            	$return_template = TEMPLATEPATH . '/' . $templatefilename;
        	} else {
            	$return_template = $plugindir . '/skt_display/themefiles/' . $templatefilename;
        	}
        	do_theme_redirect($return_template);
		} else {
			$templatefilename = 'index-testimonial.php';
        	if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            	$return_template = TEMPLATEPATH . '/' . $templatefilename;
        	} else {
            	$return_template = $plugindir . '/skt_display/themefiles/' . $templatefilename;
        	}
        	do_theme_redirect($return_template);
		}
    //A Custom Taxonomy Page
    }
}

function do_theme_redirect($url) {
    global $post, $wp_query;
    if (have_posts()) {
        include($url);
        die();
    } else {
        $wp_query->is_404 = true;
    }
}
?>