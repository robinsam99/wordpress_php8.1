<?php
/**
 * The Header for our theme.
 *
 * @package boiler
 */

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KQVKL92');</script>
<!-- End Google Tag Manager -->
<script src="https://action.dstillery.com/orbserv/nsjs?adv=cl1013861&ns=1875&nc=RoyalVelt_HP&ncv=47&dstOrderId=[OrderId]&dstOrderAmount=[OrderAmount]" type="text/javascript"></script>

<meta name="google-site-verification" content="PSzpTH6Z8joiJoIqgkEtepeRDcbMY7r9ybGwRP5n500" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php gravity_form_enqueue_scripts(3, true); ?>
<?php wp_head(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/joinform.js"></script>
<?php
		if('is_page'( 'privacy-policy' )){
		?>
		<style type="text/css">
		.head2 { font-size: 20px;color: #3a3a3a; letter-spacing: 0.5px; line-height: 28px;font-family: 'Avenir Next Cyr W00 Regular';font-weight:bold}
		.head2-text  { font-size: 16px; color: #000000; text-align: justify; letter-spacing: 0.5px; line-height: 28px;}
		table { border: 1px solid #666; }
		th { border: 1px solid #666; padding: 8px 15px; } 
		td { border: 1px solid #666; padding: 8px 15px; text-align:left }
		#royal-pp p{text-align:justify}
		#privacy{max-width: 80%;margin:0px auto;}
		h1{    margin: 1.5em 0;}
		a:hover{text-decoration:underline;}
		</style>		
		<?php } ?>   
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KQVKL92"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

	<header id="global_header">
		<div class="container">
			<div class="top_head">
				<button class="hamburger_button">
					<span></span>
				</button>
				<div class="header_logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo bloginfo('template_url'); ?>/images/Royal_Velvet_Logo.png" /></a>
				</div>
				<div class="header_right">
				<div class="share">
						<ul>
							<li><a target="_blank" href="<?php the_field('facebook_link', 'option'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a target="_blank" href="<?php the_field('twitter_link', 'option'); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a target="_blank" href="<?php the_field('pinterest_link', 'option'); ?>"></a></li>
							<li><a target="_blank" href="<?php the_field('instagram_link', 'option'); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
						</ul>
				</div>
				</div>
			</div>
			<div class="mobile_navigation">
				
				<div class="share">
					<ul>
						<li><a target="_blank" href="<?php the_field('facebook_link', 'option'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a target="_blank" href="<?php the_field('twitter_link', 'option'); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a target="_blank" href="<?php the_field('pinterest_link', 'option'); ?>"></a></li>
						<li><a target="_blank" href="<?php the_field('instagram_link', 'option'); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
