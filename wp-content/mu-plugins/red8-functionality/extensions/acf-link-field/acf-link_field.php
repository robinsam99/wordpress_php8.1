<?php

// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-link_field', false, dirname( plugin_basename(__FILE__) ) . '/lang/' ); 




// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_link_field( $version ) {
	
	include_once('acf-link_field-v5.php');
	
}

add_action('acf/include_field_types', 'include_field_types_link_field');	




// 3. Include field type for ACF4
function register_fields_link_field() {
	
	include_once('acf-link_field-v4.php');
	
}

add_action('acf/register_fields', 'register_fields_link_field');	



	
?>