<?php 
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

add_filter('redirection_role', 'red8_functionality_custom_redirection_user_role');
function red8_functionality_custom_redirection_user_role($val) {
	return 'manage_options';
}
?>