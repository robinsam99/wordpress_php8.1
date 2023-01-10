<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package boiler
 */

get_header(); ?>
   <style>
     html {
     	background-color: #35373c;
     }
   </style>
	<div class="error-404">
		<section class="container page-404">
			<div class="post not-found">
				<h1 class="h1-404">404</h1>
				<h1 class="sub-h1">Page Not Found</h1>
				<p >Please see our <a href="<?php echo get_permalink(181); ?>">Style Selector</a> to find what you are looking for.</p>
			</div>
		</section>
	</div>
<?php get_footer(); ?>
