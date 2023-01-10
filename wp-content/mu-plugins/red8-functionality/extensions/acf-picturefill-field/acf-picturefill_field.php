<?php

/*
Plugin Name: Advanced Custom Fields: Picturefill
Plugin URI: PLUGIN_URL
Description: Add different sized images that load at different breakpoints using Picturefill
Version: 1.0.0
Author: Red8 Interactive
Author URI: http://red8interactive.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/




// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-picturefill_field', false, dirname( plugin_basename(__FILE__) ) . '/lang/' ); 




// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_picturefill_field( $version ) {
	
	include_once('acf-picturefill_field-v5.php');
	
}

add_action('acf/include_field_types', 'include_field_types_picturefill_field');	




// 3. Include field type for ACF4
function register_fields_picturefill_field() {
	
	include_once('acf-picturefill_field-v4.php');
	
}

add_action('acf/register_fields', 'register_fields_picturefill_field');	



	
?>