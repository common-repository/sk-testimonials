<?php

//handles outputting the actual testimonials data
//returns the output to the function calling it
/*
$args = array(
			group - id, slug, name - the group that you want to display, default=showall
			count - number - the number of testimonials to show, default=-1
			excerpt - bool - whether to show the excerpt, default=false
			orderby - string - what to order your testimonials by, default=id
				options:
					id, date, rand, menu_order, client_name, client_company, client_link
			order	- string - which direction to order your testimonials default=ASC
		)
*/
function sk_testimonials_output($args) {
	$output = $html = $group = null;
	$html 		= get_option("skt_default_html");

	//get the proper HTML for this output
	if (isset($args['group']) && $args['group'] != 'showall') {
		$group		= $args['group'];
		if (is_numeric($group)) {
			$groupObj	= get_term($group, SKT_TAXONOMY);
		} else {
			$groupObj 	= get_term_by('name', $group, SKT_TAXONOMY);
			if ($groupObj === false) {
				$groupObj 	= get_term_by('slug', $group, SKT_TAXONOMY);
			}
		}
		
		$groupData	= get_option("category_".$group);
		$html 		= str_replace('%groups%', $groupObj->name, $html);
	}

	$postsPerPage = -1;

	if (isset($args['count'])) {
		$postsPerPage = $args['count'];
	}
	
	$excerpt = false;
	if (isset($args['excerpt']) && ($args['excerpt'] === 1 || $args['excerpt'] == (bool)true)) {
		$excerpt = true;
	}
	
	$metakey 	= null;
	$orderby	= get_option('skt_default_orderby');
	if (isset($args['orderby'])) {
		$orderby = $args['orderby'];
		switch ($args['orderby']) {
			case 'client_name':
				$orderby = 'meta_value';
				$metakey = 'sk_testimonial_client';
				break;
			case 'client_company':
				$orderby = 'meta_value';
				$metakey = 'sk_testimonial_client_company';
				break;
			case 'client_link':
				$orderby = 'meta_value';
				$metakey = 'sk_testimonial_client_link';
				break;
			default:
				break;
		}
	}

	$order	= get_option('skt_default_order');
	if (isset($args['order'])) {
		$order = $args['order'];
	}
	
	$qargs = array( 'post_type' 		=> SKT_UNIQUE_NAME, 
					'post_count'		=> $postsPerPage,
					'posts_per_page' 	=> $postsPerPage,
					'order'				=> $order,
					'orderby'			=> $orderby);

	if (isset($args['single'])) {
		$qargs['name'] = $args['single'];
		unset($qargs['posts_per_page']);
	} elseif (isset($metakey)) { // this is not used on singles
		$qargs['meta_key'] = $metakey;
	}
	
	if (isset($groupObj)) {
		$qargs[SKT_TAXONOMY] = $groupObj->slug;
	}
	
	$loop = new WP_Query( $qargs );
	while ( $loop->have_posts() ) : $loop->the_post();
		$thumbnail = null;
		if (function_exists('get_the_post_thumbnail')) {
			$thumbnail = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
		}
		
		if (empty($thumbnail)) {
			$thumbnail = get_option('skt_default_thumbnail');
		}
		
		if (empty($thumbnail)) {
			//just get the default image for the testimonial image
			$thumbnail = $grav_url = "http://www.gravatar.com/avatar/" . 
		         md5(strtolower('mm')) . "?d=" . urlencode('mm') . "&s=" . 88;
		}
		
		$meta = get_post_custom(get_the_ID());
		$output .= str_replace(array('%url_slug%', 
								  '%title%',
								  '%image%', 
								  '%testimonial%', 
								  '%client_name%', 
								  '%client_company%'), 
							array($meta['sk_testimonial_client_link'][0],
								  get_the_title(get_the_ID()),
								  $thumbnail,
 								  ($excerpt == 1 ? get_the_excerpt() : get_the_content()),
								  $meta['sk_testimonial_client'][0],
								  $meta['sk_testimonial_client_company'][0]), 
							$html);
	endwhile;
	wp_reset_query();
	if (get_option('skt_promote_plugin') === 1) {
		$output .= '<br /><div class="skt_promote">Testimonials Plugin by <a href="http://spottedkoi.com">Spotted Koi</a></div>';
	}
	return $output;
}

?>