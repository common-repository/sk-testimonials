<?php
/**
 * The main loop for displaying a single Testimonial on a page
 *
 *
 * @package WordPress
 * @subpackage SK_Testimonials
 * @since Twenty Ten 1.0
 */
global $wp;
get_header(); ?>

		<div id="container">
			<div id="content" role="main">

			<?php
			/* Run the loop to output the post.
			 * If you want to overload this in a child theme then include a file
			 * called loop-single.php and that will be used instead.
			 */
			echo sk_testimonials_output(array('single' => $wp->query_vars['name']));
			?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
