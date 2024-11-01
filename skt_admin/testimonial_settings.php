<?php

function sk_testimonial_testimonial_settings() {
	?>
		<div class="wrap">
			<h2><?php _e('Testimonials Settings', SKT_UNIQUE_NAME); ?></h2>
			<div id="skt_quick_links">
				<?php include('sk_links.php'); ?>
			</div>
		<?php
		if (isset($_GET['updated']) && $_GET['updated'] == 'true') {
			?>
			<div id="message" class="updated fade"><p><strong><?php _e('Settings Updated', SKT_UNIQUE_NAME); ?></strong></p></div>
			<?php
		}
		?>
			<form method="post" action="<?php echo esc_url('options.php');?>">
				<div>
					<?php settings_fields('skt-testimonials-settings'); ?>
				</div>
				<table class="form-table">
					<tr valign="top">
			        	<th scope="row"><?php _e('Testimonials page slug', SKT_UNIQUE_NAME); ?></th>
			        	<td>
							<?php
							$slug = get_option('skt_page_slug');
							if ($slug === false) {
								$slug = 'testimonials';
							}
							?>
							<input type="text" name="skt_page_slug" id="skt_page_slug" value="<?php echo $slug;?>"/>
							<p>The default slug is "testimonials", and will show all your testimonials on your page here: <?php bloginfo('url')?>/testimonials/</p>
							<p>Do not include anything other than lower case letters and underscores.</p>
						</td>
			        </tr>
				
					<tr valign="top">
			        	<th scope="row"><?php _e('Default testimonials sort by', SKT_UNIQUE_NAME); ?></th>
			        	<td>
							<?php
							sk_testimonials_orderby_select('skt_default_orderby', 'skt_default_orderby', get_option('skt_default_orderby'));
							?>
						</td>
			        </tr>
					<tr valign="top">
			        	<th scope="row"><?php _e('Default testimonials sort order', SKT_UNIQUE_NAME); ?></th>
			        	<td>
							<?php
								sk_testimonials_order_select('skt_default_order', 'skt_default_order', get_option('skt_default_order'));
							?>
						</td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row"><?php _e('Cache the CSS', SKT_UNIQUE_NAME); ?></th>
			        	<td>
							<input type="checkbox" name="skt_cache_css" value="1" <?php checked( get_option('skt_cache_css'), 1 ); ?> />
						</td>
			        </tr>

			        <tr valign="top">
			        	<th scope="row"><?php _e('Promote this plugin', SKT_UNIQUE_NAME); ?></th>
			        	<td>
			        		<input type="checkbox" name="skt_promote_plugin" value="1"<?php echo get_option('skt_promote_plugin') == '1' ? ' checked="checked"' : ''; ?>/> <?php _e('A link will be added to the end of the testimonial list.', SKT_UNIQUE_NAME); ?>
						</td>
			        </tr>
			    </table>
			    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Update', SKT_UNIQUE_NAME); ?>" /></p>
			</form>
		</div>
	<?php
}

function sk_testimonials_check_page_slug($new) {
	$new = sanitize_title($new);
	if ($new != 'testimonials' || $new != get_option('skt_page_slug')) {
		update_option('skt_flush_rewrite_rules', 1);
	}
	return $new;
}

function sk_testimonials_check_css($css) {
	update_option('skt_cache_css_mismatch', 1);
	return $css;
}

function skt_register_settings()
{
	register_setting('skt-testimonials-settings', 'skt_default_orderby');
	register_setting('skt-testimonials-settings', 'skt_default_order');
	register_setting('skt-testimonials-settings', 'skt_promote_plugin');
	register_setting('skt-testimonials-settings', 'skt_page_slug', 'sk_testimonials_check_page_slug');
	register_setting('skt-testimonials-settings', 'skt_cache_css');

	register_setting('skt-testimonials-design', 'skt_default_css', 'sk_testimonials_check_css');
	register_setting('skt-testimonials-design', 'skt_default_html');

	if (get_option('skt_version') != SKT_VERSION) {
		update_option('skt_version', SKT_VERSION);
	}
	
	if (get_option('skt_page_slug') === false) {
		add_option('skt_page_slug', 'testimonials', '', 'yes');
	}
	
	if (get_option('skt_sort_testimonials') === false) {
		add_option('skt_sort_testimonials', '1', '', 'yes');
	}
	if (get_option('skt_delete_tables') === false) {
		add_option('skt_delete_tables', '0', '', 'yes');
	}
	if (get_option('skt_default_css') === false) {
		add_option('skt_default_css', '
.skt_item {
	margin: 0 0 24px 0;
	overflow: hidden;
	width: 100%;
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
	}

	if (get_option('skt_default_html') === false) {
		add_option('skt_default_html', '
<div class="skt_item">
	<div class="skt_image_cont"><img src="%image%" alt=""/></div>
	<div class="skt_content_cont">
		<p class="skt_testimonial">%testimonial%</p>
		<p class="skt_client_name">%client_name%</p>
		<p class="skt_client_company">%client_company%</p>
	</div>
</div>', '', 'yes');
	}	
	
	if (get_option('skt_promote_plugin') === false) {
		add_option('skt_promote_plugin', '0', '', 'yes');
	}
	
	if (get_option('skt_cache_css') == 1) {
		sk_testimonials_check_css_files();
	}
	
	if (get_option('skt_cache_css_mismatch') === false) {
		add_option('skt_cache_css_mismatch', 1);
	}
}
add_action( 'admin_init', 'skt_register_settings' );
?>