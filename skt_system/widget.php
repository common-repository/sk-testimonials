<?php

class SK_WP_Widget_Testimonials extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'sk_widget_testimonials', 'description' => __('Output Testimonials from sk_testimonials'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('sk-text', __('SK Testimonials'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {

		$title	= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$atts 	= array('count' 	=> (isset($instance['count']) ? $instance['count'] : 5),
						'excerpt' 	=> (isset($instance['excerpt']) ? $instance['excerpt'] : 0),
						'group'		=> (isset($instance['group']) ? $instance['group'] : null),
						'order'		=> (isset($instance['order']) ? $instance['order'] : 'ASC'),
						'orderby'	=> (isset($instance['orderby']) ? $instance['orderby'] : 'rand'));
		echo $args['before_widget'];
		if ( !empty( $title ) ) { 
			echo $args['before_title'] . $title .  $args['after_title']; 
		} 
		?>
		<div class="sk_testimonials_widget">
			<?php 
				echo sk_testimonials_output($atts);
			?>
		</div>
		<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		if (isset($new_instance['title'])) {
			$instance['title'] 		= strip_tags($new_instance['title']);
		}
		if (isset($new_instance['excerpt'])) {
			$instance['excerpt'] 	= ($new_instance['excerpt'] == 'on' ? 1 : 0); 
		}
		if (isset($new_instance['count'])) {
			$instance['count']		= $new_instance['count'];
		}
		if (isset($new_instance['group'])) {
			$instance['group']		= $new_instance['group'];
		}
		if (isset($new_instance['order'])) {
			$instance['order']		= $new_instance['order'];
		}
		if (isset($new_instance['orderby'])) {
			$instance['orderby']	= $new_instance['orderby'];
		}
		return $instance;
	}

	function form( $instance ) {
		$instance 	= wp_parse_args( (array) $instance, 
									array( 	'title' 	=> '', 
										   	'text' 		=> '',
											'count'		=> 5,
											'excerpt'	=> 0,
										   	'group' 	=> null,
											'order' 	=> 'ASC',
											'orderby'	=> 'rand') );
		if (isset($instance['title'])) {
			$title 		= strip_tags($instance['title']);
		}
		
		if (isset($instance['excerpt'])) {
			$excerpt 	= $instance['excerpt'];
		}
		
		if (isset($instance['count'])) {
			$count  	= $instance['count'];
		}
		
		if (isset($instance['group'])) {
			$group 		= $instance['group'];
		}
		
		if (isset($instance['orderby'])) {
			$orderby	= $instance['orderby'];
		}

		if (isset($instance['order'])) {
			$order		= $instance['order'];
		}
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<label><input type="checkbox" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" <?php echo ($excerpt == 1 ? 'checked="checked"' : '');?>/> Show Excerpts instead of full content?</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>">How Many Testimonials?</label><input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" size="4" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('group'); ?>">Testimonial Group</label>
				<select id="<?php echo $this->get_field_id('group'); ?>" name="<?php echo $this->get_field_name('group'); ?>">
					<option value="showall" <?php echo (!isset($group) || $group == 'showall' || empty($group) ? 'selected="selected"' : '');?>>Show All</option>
				<?php
				/*
				*/
				$terms = get_terms( SKT_TAXONOMY, array(
				 	'hide_empty' => 0
				 ) );
				if ( count($terms) > 0 ){
					//load the css from each term
					foreach ( $terms as $term ) {
						printf('<option value="%s" %s>%s</option>', 
									$term->term_id, 
									($group == $term->term_id ? 'selected="selected"' : ''),
									$term->name);
					}
				}
				?>
				</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>">Order By</label>
			<?php
				sk_testimonials_orderby_select($this->get_field_id('orderby'), $this->get_field_name('orderby'), $orderby);
			?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>">Sort Order</label>
			<?php
				sk_testimonials_order_select($this->get_field_id('order'), $this->get_field_name('order'), $order);
			?>
		</p>
		
<?php
	}
}

//handles registering the widget with WordPress
function skt_widgets_init() {
	register_widget('SK_WP_Widget_Testimonials');
}

//adds widgets to the admin
add_action('widgets_init', 'skt_widgets_init');
?>