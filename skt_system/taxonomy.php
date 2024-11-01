<?php
function sk_testimonial_create_taxonomy() {
	register_taxonomy(SKT_TAXONOMY, 
					SKT_UNIQUE_NAME, 
					array(
						'labels' 	=> array(
							'name' 					=> __( 'Testimonial Groups' ),
							'singular_name' 		=> __( 'Testimonial Group' ),
							'add_new'				=> __('Add New', 'testimonial group'),
							'add_new_item'			=> __('Add New Testimonial Group'),
							'edit_item'				=> __('Edit Testimonial Groups'),
							'new_item' 				=> __('New Testimonial Group'),
							'view_item' 			=> __('View Testimonial Groups'),
							'search_items' 			=> __('Search Testimonial Groups'),
							'not_found' 			=> __('No Testimonial Groups Found'),
							'not_found_in_trash' 	=> __('No Testimonial Groups Found in Trash'),
							'parent_item_colon' 	=> __('Parent Testimonial Group'),
							'menu_name' 			=> __('Testimonial Groups')
						),
						'public'	=> true,
						'show_in_nav_menus'	=> true,
						'show_ui'			=> true,
						'show_tagcloud'		=> true,
						'hierarchical'		=> true //if this changes modify the client-name output column
					));
}

add_filter("manage_edit-".SKT_TAXONOMY."_columns", 'skt_taxonomy_columns');	
 
function skt_taxonomy_columns($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'name' => __('Name'),
		'header_icon' => '',
		'description' => __('Description'),
		'slug' => __('Slug'),
		'posts' => __('Count')
		);
	return $columns;
}


//add the taxonomy to the system
add_action( 'init', 'sk_testimonial_create_taxonomy' );
?>