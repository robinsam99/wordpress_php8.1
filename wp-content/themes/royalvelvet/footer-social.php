<?php
/**
 * The template for displaying the footer.
 *
 * @package boiler
 */
?>


	<?php $url = get_bloginfo('template_url'); ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {

			jQuery(document).bind('gform_confirmation_loaded', function(event, formId) {
				var url = <?php echo json_encode($url, JSON_UNESCAPED_SLASHES); ?>;
				if(formId === 1) {
					$('.join_top').empty();
					$('.join_top').html('<img src="'+url+'/images/black_logo_with_text.png" />');
				} else if (formId === 2) {
					$('.tip_signup').empty();
					$('.tip_signup').html('<img src="'+url+'/images/black_logo_with_text.png" />');
				}
			});

		});
	</script>

	<footer id="global_footer" class="site_footer">
		<div class="container">
			<div id="join_now">
				<div class="join_top">
					<img src="<?php echo bloginfo('template_url'); ?>/images/rv_silver_logo_icon.png" />
					<p>Sign up for special offers and decorating ideas!</p>
				</div>
				<?php //gravity_form( 3, $display_title = false, $display_description = false, $display_inactive = false, $field_values = null, $ajax = true, $tabindex, $echo = true ); ?>
				<div class="join-form" align="center">
				<?php echo do_shortcode( '[contact-form-7 id="889" title="Join Form"]' );?>
				</div>
			</div>
			<p>Get Connected.</p>
            <div class="share">
            	<ul>
            		<li><a onClick="__gaTracker('send', 'event', 'Tips Detail: Social Button', 'Click', 'Facebook')" target="_blank" href="<?php the_field('facebook_link', 'option'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            		<li><a onClick="__gaTracker('send', 'event', 'Tips Detail: Social Button', 'Click', 'Twitter')" target="_blank" href="<?php the_field('twitter_link', 'option'); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a onClick="__gaTracker('send', 'event', 'Tips Detail: Social Button', 'Click', 'Pinterest')" target="_blank" href="<?php the_field('pinterest_link', 'option'); ?>"></a></li>
            		<li><a onClick="__gaTracker('send', 'event', 'Tips Detail: Social Button', 'Click', 'Instagram')" target="_blank" href="<?php the_field('instagram_link', 'option'); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            	</ul>
            </div>
			<div class="footer_bottom">
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'footer_menu' ) ); ?>
				<div class="trademark">
					<p onClick="__gaTracker('send', 'event', 'Site Info', 'Click', 'Trademark')">Trademark <?php echo date('Y'); ?></p>
				</div>
			</div>
		</div>
	</footer>

<?php wp_footer(); ?>

</body>
</html>
