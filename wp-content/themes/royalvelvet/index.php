<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package boiler
 */

ini_set('display_errors', 0);


if (function_exists('get_header')) {
	get_header();
}else{
    /* Redirect browser */
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "");
    /* Make sure that code below does not get executed when we redirect. */
    exit;
}; 
?>

	<div class="stylemaker_secrets">
		<section class="container">
			<div class="stylemaker_top">
				<?php $post_page_id = get_option('page_for_posts'); ?>
				<h1><?php echo get_the_title($post_page_id); ?></h1>
				<div class="content_wysiwyg">
					<?php echo apply_filters('the_content', get_post_field('post_content', $post_page_id)); ?>
				</div>
			</div>

			<ul class="posts">
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php if(get_field('page_type') === 'video') {
								  $extra_label = '[Video] - ';
							  } else {
								  $extra_label = '';
							  }
						?>

						<li>
							<?php if(has_post_thumbnail()) : ?>
								<a href="<?php the_permalink(); ?>" class="title"><?php the_post_thumbnail( 'stylemaker' ); ?></a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>" class="title"><img src="<?php echo bloginfo('template_url'); ?>/images/stylemaker_image.jpg" /></a>
							<?php endif; ?>
							<a style="<?php if(get_field('bold_title') === 'yes' ) { echo 'font-family: \'Avenir Next LT W01 Bold\'; font-weight: bold;'; } ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?> <?php if(get_field('page_type', get_the_ID()) === 'video') { echo '(Video)'; } ?></a>
						</li>

					<?php endwhile; ?>

					<li>
						<a href="http://www.jcpenney.com/for-the-home/royal-velvet/cat.jump?id=cat1001890002&deptId=dept20000011&cmJCP_T=G1&cmJCP_C=D1" target="_blank"><img src="<?php echo bloginfo('template_url'); ?>/images/shop_rv_jcp.jpg" /></a>
					</li>

				<?php else : ?>

					<?php get_template_part( 'no-results', 'index' ); ?>

				<?php endif; ?>
			</ul>

		</section>
	</div>

<?php get_footer(); ?>
