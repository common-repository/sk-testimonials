<?php
function sk_testimonial_add_help_text() { 
	$screen = get_current_screen();
	//echo '<br />';
	//var_dump($screen->id);
	switch ($screen->id) {
		case 'widgets':
			$screen->add_help_tab( array(
			'id'		=> 'sk-testimonials-widgets',
			'title'		=> __('Testimonial Widget Help'),
			'content'	=> sk_testimonial_widget_help_text()
			) );
			$screen->set_help_sidebar( sk_testimonial_testimonials_help_text_sidebar());
			break;
		case SKT_UNIQUE_NAME:
			$screen->add_help_tab( array(
			'id'		=> 'sk-testimonials-widgets',
			'title'		=> __('Testimonials Help'),
			'content'	=> sk_testimonial_testimonials_overview_help_text()
			) );
			$screen->set_help_sidebar( sk_testimonial_testimonials_help_text_sidebar());
			break;
		case 'edit-testimonial-group':
		case 'sk_testimonials_page_display_settings':
			$screen->add_help_tab( array(
			'id'		=> 'sk-testimonials-design',
			'title'		=> __('Testimonials Help'),
			'content'	=> sk_testimonial_design_help_text()
			) );
			$screen->set_help_sidebar( sk_testimonial_testimonials_help_text_sidebar());
			break;
		case 'sk_testimonials_page_testimonial_settings':
			$screen->add_help_tab( array(
			'id'		=> 'sk-testimonials-settings',
			'title'		=> __('Testimonials Help'),
			'content'	=> sk_testimonial_plugin_settings_help_text()
			) );
			$screen->set_help_sidebar( sk_testimonial_testimonials_help_text_sidebar());
			break;
		default:
			break;
	}
}

function sk_testimonial_widget_help_text() {
    $contextual_help =
      '<p>' . __('When deciding how to configure your Testimonials Widget(s):') . '</p>' .
      '<ul>' .
      '<li>' . __('Decide whether you want to show the whole testimonial or an excerpt.') . '</li>' .
      '<li>' . __('Decide how many testimonials you want to show from this widget.') . '</li>' .
      '<li>' . __('Specify the url for the client. If you don\'t specify the url, then the name and company will not be linked.') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to show a specific group of testimonials, choose a group. Otherwise, leave it as "show all".') . '</p>' .
      '<ul>' .
      '<li>' . __('Add a group name or select a current group name from the Testimonials Group module.') . '</li>' .
      '<li>' . __('Testimonials can be added to more than one group, so they can be displayed in more than one place.') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the testimonial to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>';
  return $contextual_help;
}

//add the help text for the testimonials pages
function sk_testimonial_testimonials_overview_help_text() { 
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a testimonial:') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the client giving the testimonial.') . '</li>' .
      '<li>' . __('Specify the client\'s company.') . '</li>' .
      '<li>' . __('Specify the url for the client. If you don\'t specify the url, then the name and company will not be linked.') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to group testimonials so that they can be displayed together:') . '</p>' .
      '<ul>' .
      '<li>' . __('Add a group name or select a current group name from the Testimonials Group module.') . '</li>' .
      '<li>' . __('Testimonials can be added to more than one group, so they can be displayed in more than one place.') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the testimonial to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>' ;
	return $contextual_help;
}
function sk_testimonial_testimonials_help_text_sidebar() { 

      $content = '<p><strong>' . __('For more information about the Spotted Koi Testimonial:') . '</strong></p>' .
      '<p>' . __('<a href="http://spottedkoi.com/plugins/sk-testimonials" target="_blank">SK Testimonials Plugin</a>') . '</p>'	.
      '<p>' . __('<a href="http://help.spottedkoi.com/categories/sk-testimonials" target="_blank">SK Testimonials Help Forum</a>') . '</p>';
  return $content;
}

//add the help text for the testimonials pages
function sk_testimonial_design_help_text() { 
	ob_start();
		include realpath(plugin_dir_path( __FILE__ )."../skt_display/").'/shortcodes_explained.php';
    $contextual_help = ob_get_clean();
  return $contextual_help;
}

//add the help text for the testimonials pages
function sk_testimonial_plugin_settings_help_text() { 
    $contextual_help =
      '<p>' . __('Your default testimonial settings:') . '</p>' .
      '<ul>' .
      '<li>' . __('You can set the default order of the testimonial display for whenever an order is not specified.') . '</li>' .
      '<li>' . __('You can also choose to support the writers of this plugin by linking to SpottedKoi.com after your testimonials list.') . '</li>' .
      '</ul>';
  return $contextual_help;
}

// Adds my_help_tab when my_admin_page loads
add_action('admin_head', 'sk_testimonial_add_help_text');
//add_action( 'admin_head-widgets', 'sk_testimonial_add_widget_help_text', 10, 3 );
?>