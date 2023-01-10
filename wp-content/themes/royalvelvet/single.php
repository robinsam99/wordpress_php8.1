<?php
/**
 * The Template for displaying all single posts.
 *
 * @package boiler
 */

get_header(); ?>

	<style>
		.current_page_parent {
			color: white;
			border-bottom: white solid 2px;
		}

		.current_page_parent a {
			color: white !important;
		}
	</style>

	<div class="stylemaker_secret">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

		<?php endwhile; // end of the loop. ?>

	</div>

<?php get_footer('social'); ?>
