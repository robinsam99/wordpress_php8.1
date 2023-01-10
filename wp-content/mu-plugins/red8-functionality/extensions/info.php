<?php 
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}


// Extensions listed alphabetically
$extensions = array(
	
	// ACF Gravity Forms Field
	array(
		'title' => 'ACF Gravity Forms Field',
		'name' => 'gravity_forms_acf_field',
		'description' => 'Allow the ability to use the Gravity Forms ACF Field',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_GRAVITY_FORMS_ACF',
		'option_name' => 'red8_functionality_gravity_forms_acf',
		'file' => 'gf-acf-field/acf-gravity_forms_field.php',
		'notice_name' => array('advanced-custom-fields-pro/acf.php', 'gravityforms/gravityforms.php'),
		'notice_message' => 'The Gravity Forms and ACF plugins are active, but you don\'t have the Gravity Forms ACF Field extension activated. Would you like to activate it?',
		'dismiss_title' => 'red8_functionality_dismiss_gf_acf_link',
	),
	
	// ACF Link Field
	array(
		'title' => 'ACF Link Field',
		'name' => 'acf_link_field',
		'description' => 'Add the Link Field to ACF',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_ACF_LINK_FIELD',
		'option_name' => 'red8_functionality_acf_link_field',
		'file' => 'acf-link-field/acf-link_field.php',
		'notice_name' => 'advanced-custom-fields-pro/acf.php',
		'notice_message' => 'The ACF plugin is active, but you don\'t have the ACF Link Field extension activated. Would you like to activate it?',
		'dismiss_title' => 'red8_functionality_dismiss_acf_link',
	),
	
	
	
	// ACF Picturefill
	array(
		'title' => 'ACF Picturefill Field',
		'name' => 'acf_picturefill_field',
		'description' => 'Add the Picturefill Field to ACF',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_ACF_PICTUREFILL_FIELD',
		'option_name' => 'red8_functionality_acf_picturefill_field',
		'file' => 'acf-picturefill-field/acf-picturefill_field.php',
		'notice_name' => 'advanced-custom-fields-pro/acf.php',
		'notice_message' => 'The ACF plugin is active, but you don\'t have the ACF Picturefill Field extension activated. Would you like to activate it?',
		'dismiss_title' => 'red8_functionality_dismiss_acf_picturefill_field',
	),
	
	
	// ACF Time Picker
	array(
		'title' => 'ACF Time Picker Field',
		'name' => 'acf_time_picker_field',
		'description' => 'Add the Time Picker Field to ACF',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_ACF_TIME_PICKER_FIELD',
		'option_name' => 'red8_functionality_acf_time_picker_field',
		'file' => 'acf-time-picker-field/acf-time_picker_field.php',
		'notice_name' => 'advanced-custom-fields-pro/acf.php',
		'notice_message' => 'The ACF plugin is active, but you don\'t have the ACF Time Picker Field extension activated. Would you like to activate it?',
		'dismiss_title' => 'red8_functionality_dismiss_acf_time_picker_field',
	),
	
	
	// Button Generator
	array(
		'title' => 'Button Generator',
		'name' => 'button_generator',
		'description' => 'Add the Button Generator plugin to your posts',
		'admin_page' => 'admin.php?page=wp_button_generator',
		'option_title' => 'RED8_FUNC_BUTTON_GENERATOR',
		'option_name' => 'red8_functionality_button_generator',
		'file' => 'button-generator/wp-button-generator.php',
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	// Custom Post Type Manager
	array(
		'title' => 'Custom Post Type Manager',
		'name' => 'custom_post_type_manager',
		'description' => 'Ability to create and manage custom post types and taxonomies',
		'admin_page' => 'admin.php?page=custom_post_type_manager',
		'option_title' => 'RED8_FUNC_CUSTOM_POST_TYPE_MANAGER',
		'option_name' => 'red8_functionality_custom_post_type_manager',
		'file' => 'custom-post-type-manager/custom-post-type-manager.php',
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	
	// Filter Pro
	array(
		'title' => 'Filter Pro',
		'name' => 'filter_pro',
		'description' => 'Allow the ability to use the Filter Pro plugin',
		'admin_page' => 'admin.php?page=filter-pro',
		'option_title' => 'RED8_FUNC_FILTER_PRO',
		'option_name' => 'red8_functionality_filter_pro',
		'file' => 'filter-pro/filter-pro.php',
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	
	// Footer Popup
	array(
		'title' => 'Footer Popup',
		'name' => 'footer_popup',
		'description' => 'Add the Footer Popup to your site',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_FOOTER_POPUP',
		'option_name' => 'red8_functionality_footer_popup',
		'file' => 'footer-popup/footer-popup.php',
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	
	// Page Jump
	array(
		'title' => 'Page Jump',
		'name' => 'page_jump',
		'description' => 'Add the "Jump To Top" button to your site',
		'admin_page' => 'admin.php?page=red8_func_page_jump',
		'option_title' => 'RED8_FUNC_PAGE_JUMP',
		'option_name' => 'red8_functionality_page_jump',
		'file' => 'page-jump/page-jump.php',
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	//Red8 Google Maps
	array(
		'title' => 'Red8 Google Maps',
		'name'	=> 'red8_gmaps',
		'description' => 'Create/Add Google Maps to posts easily.',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_R8_GMAPS',
		'option_name' => 'red8_functionality_gmaps',
		'file' => 'red8-gmaps/red8-gmaps.php',	
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	// Redirection Manager Role
	array(
		'title' => 'Redirection Manager Role',
		'name' => 'redirection_manager_role',
		'description' => 'Allow the Manager role to access the Redirection Options page',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_REDIRECTION_ROLE',
		'option_name' => 'red8_functionality_redirection_role',
		'file' => 'redirection-manager-role/redirection-manager-role.php',
		'notice_name' => 'redirection/redirection.php',
		'notice_message' => 'The Redirection plugin is active, but you don\'t have the Redirection Manager Role extension activated. Would you like to activate it?',
		'dismiss_title' => 'red8_functionality_dismiss_redirection_role',
	),
	
	// Shortcode Cheat Sheet
	array(
		'title' => 'Shortcode Cheat Sheet',
		'name' => 'shortcode_cheat_sheet',
		'description' => 'Add a meta box that lists all possible shortcodes',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_SHORTCODE_CHEAT_SHEET',
		'option_name' => 'red8_functionality_shortcode_cheat_sheet',
		'file' => 'shortcode-cheat-sheet/shortcode-cheat-sheet.php',
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	
	// Sidebar Manager
	array(
		'title' => 'Sidebar Manager',
		'name' => 'sidebar_manager',
		'description' => 'Create and manage custom sidebars',
		'admin_page' => 'admin.php?page=sidebar-manager',
		'option_title' => 'RED8_FUNC_SIDEBAR_MANAGER',
		'option_name' => 'red8_functionality_sidebar_manager',
		'file' => 'sidebar-manager/sidebar-manager.php',
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	
	// Sliding Sidebar
	array(
		'title' => 'Sliding Sidebar',
		'name' => 'sliding_sidebar',
		'description' => 'Allow the sidebar on the edit post screen to slide in/out',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_SLIDING_SIDEBAR',
		'option_name' => 'red8_functionality_sliding_sidebar',
		'file' => 'sliding-sidebar/sliding-sidebar.php',
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	
	// Speed Bump
	array(
		'title' => 'Speed Bump',
		'name' => 'speed_bump',
		'description' => 'Allow the ability to use the Speed Bump plugin',
		'admin_page' => 'admin.php?page=speed-bump',
		'option_title' => 'RED8_FUNC_SPEED_BUMP',
		'option_name' => 'red8_functionality_speed_bump',
		'file' => 'speed-bump/speed-bump.php',
		'notice_name' => null,
		'notice_message' => null,
		'dismiss_title' => null,
	),
	
	
	// Yoast + ACF
	array(
		'title' => 'Yoast + ACF',
		'name' => 'yoast_acf',
		'description' => 'Allow the Yoast plugin to track ACF fields',
		'admin_page' => null,
		'option_title' => 'RED8_FUNC_YOAST_ACF',
		'option_name' => 'red8_functionality_yoast_acf',
		'file' => 'yoast-acf/yoast-acf.php',
		'notice_name' => array('wordpress-seo/wp-seo.php', 'advanced-custom-fields-pro/acf.php'),
		'notice_message' => 'The Yoast SEO and ACF plugins are active, but you don\'t have the Yoast + ACF extension activated. Would you like to activate it?',
		'dismiss_title' => 'red8_functionality_dismiss_yoast_acf',
	),

);

return $extensions;
?>