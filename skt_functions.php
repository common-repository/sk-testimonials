<?php

function sk_testimonials_orderby_select($fieldId, $fieldName, $orderby)
{
	?>
	<select id="<?php echo $fieldId; ?>" name="<?php echo $fieldName; ?>">
	<?php
	$terms = array('Id (default)' 	=> 'id',
					'Publish Date' 	=> 'date', 
					'Random'		=> 'rand', 
					'Custom Order'	=> 'menu_order', 
					'Client Name'	=> 'client_name', 
					'Client Company'=> 'client_company', 
					'Client Link'	=> 'client_link');
	if ( count($terms) > 0 ){
		//load the css from each term
		foreach ( $terms as $k => $v ) {
			printf('<option value="%s" %s>%s</option>', 
						$v, 
						($orderby == $v ? 'selected="selected"' : ''),
						$k);
		}
	}
	?>
	</select>
	<?php
}

function sk_testimonials_order_select($fieldId, $fieldName, $order) {
	?>
	<select id="<?php echo $fieldId; ?>" name="<?php echo $fieldName; ?>">
	<?php
	/*
	*/
	$terms = array('Ascending' 	=> 'ASC',
					'Descending' 	=> 'DESC');
	if ( count($terms) > 0 ){
		//load the css from each term
		foreach ( $terms as $k => $v ) {
			printf('<option value="%s" %s>%s</option>', 
						$v, 
						($order == $v ? 'selected="selected"' : ''),
						$k);
		}
	}
	?>
	</select>
	<?php
}

function sk_testimonials_excerpt($content, $permalink, $length) {
	$excerpt = $content;
	$excerpt = preg_replace(" (\[.*?\])",'', $excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, 40);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
	$excerpt = $excerpt.'... <a href="'.$permalink.'">'.get_option('skt_default_readmore').'more</a>';
	return $excerpt;
}

?>