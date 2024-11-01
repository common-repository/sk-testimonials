<?php
/*
	Setups up the defaults configuration options for the plugin and the pages
*/

function sk_testimonial_install() {
	add_option('skt_version', SKT_VERSION);
	add_option('skt_default_orderby', 'id', '', 'yes');
	add_option('skt_default_order', 'ASC', '', 'yes');
	add_option('skt_default_readmore', 'Read More', '', 'yes');
	add_option('skt_delete_tables', '0', '', 'yes');
	add_option('skt_default_css', '
.skt_item {
	margin: 0 0 24px 0;
	overflow: hidden;
	width: 100%;
	clear:left;
}
.skt_image_cont {
	float: left;
	height: 88px;
	margin: 4px 20px 0 5px;
	width: 88px;
}
.skt_image_cont img {
	border: 2px solid #CCCCCC;
}
.skt_content_cont {
	float: left;
	width: 330px;
}
.skt_content_cont p {
	margin-bottom: 0;
}
.skt_testimonial {
	color: #555555;
	font-size: 12px;
	line-height: 21px;
	margin: 0 0 12px;
}
.skt_client_name {
	font-weight: bold;
	margin-top: 10px;
}
.skt_client_company {
	margin: 0;
	color: #00AEEF;
	font-size: 12px;
}
.skt_client_company a {
	color: #00AEEF;
	font-size: 12px;
	text-decoration: none;
}
.skt_client_company a:hover {
	color: #555555;
}
', '', 'yes');
	add_option('skt_default_html', '
<div class="skt_item">
	<div class="skt_image_cont"><img src="%image%" alt="%skt_client_name%"/></div>
	<div class="skt_content_cont">
		<p class="skt_testimonial">%testimonial%</p>
		<p class="skt_client_name">%client_name%</p>
		<p class="skt_client_company"><a href="%url_slug%">%client_company%</a></p>
	</div>
</div>', '', 'yes');

	add_option('skt_promote_plugin', '0', '', 'yes');
}
register_activation_hook(__FILE__, 'skt_install');


//sets up the configuration pages for the testimonials output
function sk_testimonials_pages() {
	//add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	add_submenu_page('edit.php?post_type='.SKT_UNIQUE_NAME, 'Design Settings', 'Design Settings', 'manage_options', 'display_settings', 'sk_testimonial_display_settings');
	add_submenu_page('edit.php?post_type='.SKT_UNIQUE_NAME, 'Testimonials Settings', 'Testimonial Settings', 'manage_options', 'testimonial_settings', 'sk_testimonial_testimonial_settings');
}
add_action("admin_menu", 'sk_testimonials_pages');

?>
