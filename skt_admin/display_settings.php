<?php
function sk_testimonial_display_settings() {
	?>
		<div class="wrap">
			<h2><?php _e('Testimonial Design', SKT_UNIQUE_NAME); ?></h2>
			<div id="skt_quick_links">
				<?php include('sk_links.php'); ?>
			</div>
			<div class="error fade"><p><strong><?php _e('Be aware that by changing the HTML and CSS incorrectly it may mess up your blog layout. Be careful!<br />If you are unsure about something, it\'s always OK to ask someone who can help!', SKT_UNIQUE_NAME); ?></strong></p></div>
		<?php
		if (isset($_GET['updated']) && $_GET['updated'] == 'true') {
		?>
			<div id="message" class="updated fade"><p><strong><?php _e('Design Updated', SKT_UNIQUE_NAME); ?></strong></p></div>
		<?php
		}
		?>
			<span class="description">
				<?php _e('These are your default HTML and CSS settings for testimonials. Whenever you output testimonials, these settings will be used.', SKT_UNIQUE_NAME); ?><br />
				<?php _e('If you output only a specific group\'s testimonials, then the group\'s HTML and CSS settings will be used. A group\'s settings are loaded with these values when the group is created.', SKT_UNIQUE_NAME); ?><br />
			</span>
			<form method="post" action="<?php echo esc_url('options.php');?>">
				<div>
					<?php settings_fields('skt-testimonials-design'); ?>
				</div>
				<table class="form-table">
					<tr valign="top">
			        	<th scope="row"><?php _e('HTML Code', SKT_UNIQUE_NAME); ?></th>
			        	<td>
			        		<textarea class="large-text" cols="20" rows="10" name="skt_default_html" id="skt_default_html"><?php echo get_option('skt_default_html'); ?></textarea>
							<br />
							<span class="description">See the Help tab (top right corner) for shortcode descriptions.</span>
						</td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row"><?php _e('CSS Code', SKT_UNIQUE_NAME); ?></th>
			        	<td><textarea class="large-text" cols="20" rows="10" name="skt_default_css" id="skt_default_css"><?php echo get_option('skt_default_css'); ?></textarea></td>
			        </tr>
			    </table>
			    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Update', SKT_UNIQUE_NAME); ?>" /></p>
			</form>
		</div>
	<?php
}
?>