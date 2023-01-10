<?php
/**
 * @package boiler
 */
?>

<div class="container710">
	<h1><?php the_title(); ?></h1>
	<div class="intro_copy">
		<?php the_field('intro_copy'); ?>
	</div>

	<?php if(get_field('page_type') == 'default') {
			  $type = 'default';
		  } else {
			  $type = 'video';
		  }
	?>

	<?php if($type === 'default' && get_field('banner_image')) : ?>
		<?php $image = get_field('banner_image'); ?>
		<div class="banner_image">
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
		</div>
	<?php endif; ?>
</div>


<?php if($type === 'video' && get_field('video_link')) : ?>
	<div class="video_wrap">
		<div class="container785">
			<div class="video_container">
				<?php the_field('video_link'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php $pin_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id )); ?>

<div class="container710">
	<div class="share">
		<span>SHARE:</span>
		<ul>
			<li><a onClick="__gaTracker('send', 'event', 'Tips Detail: Social Share', 'Click', 'Facebook')" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
			<li><a onClick="__gaTracker('send', 'event', 'Tips Detail: Social Share', 'Click', 'Twitter')" href="https://twitter.com/intent/tweet?text=<?php echo urlencode('Royal Velvet '.get_the_title()); ?>&url=<?php echo urlencode(get_permalink()); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
			<li><a onClick="__gaTracker('send', 'event', 'Tips Detail: Social Share', 'Click', 'Pinterest')" data-pin-do="buttonPin" data-pin-round="true" data-pin-save="false" href="https://pinterest.com/pin/create/bookmarklet/?url=<?php echo $pin_image[0]; ?>&description=<?php echo 'Royal Velvet '.get_the_title().' - '.get_permalink(); ?>" target="_blank"></a></li>
		</ul>
	</div>

	<div class="content_wysiwyg">
		<?php the_content(); ?>
	</div>

	<div class="more_stylemaker_secrets">
		<div class="side_border">
			<h3>
				<span>MORE STYLEMAKER SECRETS</span>
			</h3>
		</div>
		<ul>
		<?php
		    $args = array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'post__not_in' => array(get_the_ID()),
				'orderby' => 'rand'
			);

		    $related_tips = new WP_Query($args);

		    while( $related_tips->have_posts() ) : $related_tips->the_post();
		?>

			<?php
				if (get_field('page_type', get_the_ID()) === 'video') {
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
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?> <?php if(get_field('page_type', get_the_ID()) === 'video') { echo '(Video)'; } ?></a>
			</li>

		<?php endwhile; wp_reset_postdata(); ?>
		</ul>
	</div>

	<div class="tip_signup_wrap">
		<div class="tip_signup">
			<img src="<?php echo bloginfo('template_url'); ?>/images/rv_silver_logo_icon.png" />
			<p>Sign up to receive decorating tips and<br>product information right in your inbox.</p>
			<div class="join_now">
				<a class="fancybox" href="#join_now">JOIN NOW</a>
			</div>
		</div>
	</div>
</div>
