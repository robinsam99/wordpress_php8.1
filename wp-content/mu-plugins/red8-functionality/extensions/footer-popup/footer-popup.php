<?php 
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

add_action('wp_footer', 'red8_func_add_footer_popup');
function red8_func_add_footer_popup() {
	
	ob_start(); ?>
	<div class="red8_func_footer_popup">
		<div class="red8_func_popup_left">
			<div>
				<h3>Footer Header</h3>
				<p>Footer copy</p>
			</div>
			<img src="" />
		</div>
		<div class="red8_func_popup_right">
			<div class="red8_func_popup_close_btn">X</div>
	    </div>
	    <div class="red8_func_mobile_popup_close_btn">X</div>
	</div>
	<?php
	echo ob_get_clean();
}

add_action('wp_enqueue_scripts', 'red8_func_enqueue_footer_popup_scripts');
function red8_func_enqueue_footer_popup_scripts() {
	wp_enqueue_style( 'red8-func-footer-popup', plugins_url('css/style.css', __FILE__) );
	
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'red8-func-footer-popup', plugins_url('js/main.js', __FILE__), array('jquery'), '1.0.0', true );
}
?>