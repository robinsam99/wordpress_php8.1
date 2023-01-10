<?php
/**
 * The template for displaying the footer.
 *
 * @package boiler
 */
?>

	<footer id="global_footer" class="site_footer">
		<div class="container">
			<div class="footer_bottom">
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'footer_menu' ) ); ?>
				<!--<div class="trademark">
					<p>Trademark <?php echo date('Y'); ?></p>
				</div>-->
				<p style="margin-top:10px;">For PR and media inquiries, please contact <a href="mailto:press@iconixbrand.com"><span style="color:#000;">press@iconixbrand.com</span></a>.</p>
			</div>
			
		</div>
	</footer>
<style>
#menu-item-929{
pointer-events:none;
} 
#global_footer .footer_menu {
    list-style: none;
    float: initial;
    margin-left: 70px;
}
#global_footer .footer_menu li:last-child:after {
    color: #ffffff;
}
</style>
<?php wp_footer(); ?>

</body>
</html>
