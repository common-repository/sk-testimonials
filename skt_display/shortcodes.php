<?php
/*
 For shortcode parameter descriptions, see comments in sk_testimonials/skt_display/html_output.php
 */
function sk_testimonials_shortcode($atts) {
	$args = shortcode_atts( array(
				'group' 	=> 'showall',
				'count' 	=> -1,
				'excerpt' 	=> false,
				'orderby'	=> get_option('skt_default_orderby'),
				'order'		=> get_option('skt_default_order')
				), $atts );
	return sk_testimonials_output($args);
}
add_shortcode('testimonials', 'sk_testimonials_shortcode');
?>