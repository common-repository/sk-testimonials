<?php
/**
 * The main loop for displaying all the testimonials in one page
 *
 *
 * @package WordPress
 * @subpackage SK_Testimonials
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

			<?php
				echo sk_testimonials_output(array('excerpt' => 1));
			?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
