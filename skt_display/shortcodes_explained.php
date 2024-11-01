<span class="description">
	<p><?php _e('You can customize the HTML for this specific group. The following template variables are available for your use in the HTML.', SKT_UNIQUE_NAME); ?></p><br /><br />
	<table>
		<tr>
			<td>%groups%</td>
			<td><?php _e('Will add the current group name to the class names if the testimonials are being displayed for only this group.', SKT_UNIQUE_NAME); ?></td>
		</tr>
		<tr>
			<td>%url_slug%</td>
			<td><?php _e('Will add the currently displayed url slug to the class names so that you can customize the CSS for this page slug in your theme\'s CSS or in the testimonial CSS below.', SKT_UNIQUE_NAME); ?></td>
		</tr>
			<tr>
				<td>%title%</td>
				<td><?php _e('Will display the Custom Title you gave to your testimonial.', SKT_UNIQUE_NAME); ?></td>
			</tr>
		<tr>
			<td>%image%</td>
			<td><?php _e('It will display the URL to the image.', SKT_UNIQUE_NAME); ?></td>
		</tr>
		<tr>
			<td>%testimonial%</td>
			<td><?php _e('Displays the testimonial text.', SKT_UNIQUE_NAME); ?></td>
		</tr>
		<tr>
			<td>%client_name%</td>
			<td><?php _e('Displays the client name.', SKT_UNIQUE_NAME); ?></td>
		</tr>
		<tr>
			<td>%client_company%</td>
			<td>
				<?php _e('It will display either the company name, the url to the company name or company name as a link to their website. It depends on what you have entered for this two fields.', SKT_UNIQUE_NAME);
				_e('Tip: Name your HTML classes after this group, so that you can identify it easily', SKT_UNIQUE_NAME) ?>
			</td>
		</tr>
	</table>
</span>