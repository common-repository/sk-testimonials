<?php

//Create the CPT for testimonials
function sk_testimonial_create_post_type() {
	
	$slug = get_option('skt_page_slug');
	if ($slug === false) {
		$slug = 'testimonials';
	}
	
	register_post_type( SKT_UNIQUE_NAME,
		array(
			'labels' => array(
				'name' 					=> __('Testimonials'),
				'singular_name' 		=> __('Testimonial'),
				'add_new'				=> __('Add New', 'testimonial'),
				'add_new_item'			=> __('Add New Testimonial'),
				'edit_item'				=> __('Edit Testimonial'),
				'new_item' 				=> __('New Testimonial'),
				'view_item' 			=> __('View Testimonial'),
				'search_items' 			=> __('Search Testimonials'),
				'not_found' 			=> __('No Testimonials Found'),
				'not_found_in_trash' 	=> __('No Testimonials Found in Trash'),
				'parent_item_colon' 	=> __('Parent Testimonial'),
				'menu_name' 			=> __('Testimonials')
			),
		'public' 				=> true,
		'has_archive' 			=> true,
		'description'			=> 'Testimonials for your site, so people can find out how awesome you are!',
		'publicly_queryable'	=> true,
		'exclude_from_search '	=> false,
		'show_ui' 				=> true,
		'menu_position '		=> 5,
		'supports'				=> array('title',
										'editor',
										'thumbnail',
										'excerpt',
										//'custom-fields',
										'page-attributes',
										//'post-formats'
										),
		'register_meta_box_cb'	=> 'testimonials_meta_boxes',
		'taxonomies'			=> array(SKT_TAXONOMY),
		'has_archive'			=> true,
		'rewrite'				=> array('slug' 		=> $slug,
										 'with_front' 	=> FALSE),
		'can_export'			=> true
		)
	);

	if (get_option('skt_flush_rewrite_rules') == 1 || get_option('skt_flush_rewrite_rules') == '') {
		flush_rewrite_rules();
		update_option('skt_flush_rewrite_rules', 0);
	}
}
//flush the rewrite rules for WP
function sk_testimonials_rewrite_flush() 
{
    sk_testimonial_create_post_type();
    flush_rewrite_rules();
}

//handle updating the messaging for CPTs
function sk_testimonial_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages[SKT_UNIQUE_NAME] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Testimonial updated. <a href="%s">View testimonial</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Testimonial updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Testimonial restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Testimonial published. <a href="%s">View testimonial</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Testimonial saved.'),
    8 => sprintf( __('Testimonial submitted. <a target="_blank" href="%s">Preview testimonial</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview testimonial</a>'),
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Testimonial draft updated. <a target="_blank" href="%s">Preview testimonial</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

//add the meta box to the CPT edit page
function testimonials_meta_boxes() {
	add_meta_box('testimonial-client', 
				'Client Information', 
				'sk_testimonial_client_info', 
				SKT_UNIQUE_NAME, 
				'side', 
				'high');
}

//Handle the output for the meta box
function sk_testimonial_client_info($post) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'sk_testimonial_noncename' );
	
	$client 	= get_post_meta($post->ID, 'sk_testimonial_client');
	if (!isset($client[0]) || empty($client[0])) {
		$client = null;
	} else {
		$client = $client[0];
	}
	$company	= get_post_meta($post->ID, 'sk_testimonial_client_company');
	if (!isset($company[0]) || empty($company[0])) {
		$company = null;
	} else {
		$company = $company[0];
	}
	$link		= get_post_meta($post->ID, 'sk_testimonial_client_link');
	if (!isset($link[0]) || empty($link[0])) {
		$link = null;
	} else {
		$link = $link[0];
	}	
	?>
	<span class="description">
		Enter Information about the person who wrote this testimonial
	</span>
	<p>
		<label for="sk_testimonial_client">
			<strong>Client Name:</strong>
		</label>
		<br />
		<input type="text" name="sk_testimonial_client" id="sk_testimonial_client" size="39" value="<?php echo $client;?>" />
	</p>
	<p>
		<label for="sk_testimonial_client_company">
			<strong>Client's Company:</strong>
		</label>
		<br />
		<input type="text" name="sk_testimonial_client_company" id="sk_testimonial_client_company" size="39"  value="<?php echo $company;?>" />
	</p>
	<p>
		<label for="sk_testimonial_client_link">
			<strong>Client Link:</strong>
		</label>
		<br />
		<input type="text" name="sk_testimonial_client_link" id="sk_testimonial_client_link" placeholder="http://<?php echo $_SERVER['SERVER_NAME']?>" size="39" value="<?php echo $link;?>" />
	</p>
	<?php
}

//handle saving the meta box data
function sk_testimonial_save_postdata($postId) {

	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	    return;
	
	if (isset($_POST['post_type']) && SKT_UNIQUE_NAME == $_POST['post_type'])  {

		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !wp_verify_nonce( $_POST['sk_testimonial_noncename'], plugin_basename( __FILE__ ) ) )
	    return;

		// Check permissions
	  	if (!current_user_can('edit_post', $postId))
	      return;
	
		// OK, we're authenticated: we need to find and save the data
		$client 	= $_POST['sk_testimonial_client'];
		$company 	= $_POST['sk_testimonial_client_company'];

		// Add this data to the post_meta
		update_post_meta($postId, 'sk_testimonial_client', 			$client);
		update_post_meta($postId, 'sk_testimonial_client_link', 	$_POST['sk_testimonial_client_link']);
		update_post_meta($postId, 'sk_testimonial_client_company', 	$company);
	} else {
	  if (!current_user_can('edit_post', $postId))
	      return;
	}

	
}

//fix the URL slug to have proper information
function sk_testimonial_append_slug($data) {
    global $post_ID;
	$title = $url = null;
	if ($data['post_type'] == SKT_UNIQUE_NAME) {
		if (isset($_POST['sk_testimonial_client'])) {
			$url = $_POST['sk_testimonial_client'];
			$title = $_POST['sk_testimonial_client'];
			if (isset($_POST['sk_testimonial_client_company'])) {
				$url .= '-'.$_POST['sk_testimonial_client_company'];
				$title .= ' '.$_POST['sk_testimonial_client_company'];
			}
		} elseif (isset($_POST['sk_testimonial_client_company'])) {
			$url = isset($_POST['sk_testimonial_client_company']);
			$title = isset($_POST['sk_testimonial_client_company']);
		}
	
		if (!is_null($url)) {
			$data['post_name'] = wp_unique_post_slug(sanitize_title($url, $post_ID), $post_ID, $data['post_status'], $data['post_type'], isset($data['post_parent']) ? $data['post_parent'] : null);
		}
		
		if (!is_null($title) && $data['post_title'] == 'Auto Draft') {
			$data['post_title'] = $title;
		}
	}
    return $data;
}

//Setup the columns for the testimonials list
function sk_testimonial_columns($defaults) {	
	$new = array('cb'			=> $defaults['cb'],
				//'title'		=> 'Title',
				'client-name'	=> 'Client Name',
				'testimonial'	=> 'Testimonial',	
				'groups'		=> 'Group',
				'date'			=> $defaults['date']);
  	return $new;
}

//set up the output for the data in the testimonials list
function sk_testimonial_custom_column($column_name, $postId) {

  	$taxonomy 	= $column_name;
	$post 		= get_post($postId);
  	$post_type 	= $post->post_type;//get_post_type($postId);
  	$clientName = get_post_meta($postId, 'sk_testimonial_client', true);
	$company	= get_post_meta($postId, 'sk_testimonial_client_company', true);
	$link		= get_post_meta($postId, 'sk_testimonial_client_link', true);
	switch ($column_name) {
		case 'client-name':
			printf('<a href="%s">%s</a><br />%s%s%s',
				get_edit_post_link($post->ID, true),
				(isset($clientName) ? '<strong>'.$clientName.'</strong>' : '<em>no client name</em>'),
				(isset($company) ? $company : '-'),
				(isset($link) ? ' - <a href="'.$link.'">'.$link.'</a>' : ''),
				sk_testimonials_row_actions($post));
			break;
		case 'testimonial':
			//get the testimonial excerpt
			the_excerpt($post->ID);
			break;
		case 'groups':
			//get the list of taxonomies
			the_taxonomies('post='.$post->ID.'&before=<ul>&after=</ul>');
			break;
	}
}

//builds the row actions for each testimonial (edit, view, trash)
function sk_testimonials_row_actions($post) {
	$post_type_object = get_post_type_object( SKT_UNIQUE_NAME );
	if ( $post_type_object->public ) {
		if ( in_array( $post->post_status, array( 'pending', 'draft', 'future' ) ) ) {
			if ( current_user_can('edit_post'))
				$viewLink = '<a href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) . '" title="' . esc_attr( ( 'Preview This Testimonial' ) ) . '" rel="permalink">' . __( 'Preview' ) . '</a>';
		} elseif ( 'trash' != $post->post_status ) {
			$viewLink = '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( __( 'View This Testimonial' ) ) . '" rel="permalink">' . __( 'View' ) . '</a>';
		}
	}
	
	
	return sprintf('
		<div class="row-actions">
			<span class="edit">
				<a title="Edit this Testimonial" href="%s">
					Edit
				</a> | 
			</span>
			<span class="trash">
				<a href="%s" title="Move this Testimonial to the Trash" class="submitdelete">
					Trash
				</a> | 
			</span>
			<span class="view">
				%s
			</span>
		</div>',
			get_edit_post_link($post->ID, true),
			get_delete_post_link($post->ID),
			$viewLink);
}

//call the function that sets up the testimonials CPT
add_action( 'init', 'sk_testimonial_create_post_type' );
//flush the rewrite rules for WP
register_activation_hook( __FILE__, 'sk_testimonials_rewrite_flush' );
//add filter to ensure the testimonial is displayed when user updates a book 
add_filter( 'post_updated_messages', 'sk_testimonial_updated_messages' );
//grab the meta fields when we save a testimonial
add_action( 'save_post', 'sk_testimonial_save_postdata' );
//Creates a unique slug for the testimonial
add_filter('wp_insert_post_data', 'sk_testimonial_append_slug', 10);
//Add the custom columns for the testimonials list
add_filter( 'manage_edit-'.SKT_UNIQUE_NAME.'_columns', 'sk_testimonial_columns' );
//add the output data to the custom testimonials list column
add_action( 'manage_'.SKT_UNIQUE_NAME.'_posts_custom_column', 'sk_testimonial_custom_column', 10, 2 );
//add the output data to the custom testimonials list column
add_action( 'manage_'.SKT_UNIQUE_NAME.'_posts_column', 'sk_testimonial_custom_column', 10, 2 );

?>