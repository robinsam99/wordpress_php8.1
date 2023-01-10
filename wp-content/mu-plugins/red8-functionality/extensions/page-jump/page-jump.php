<?php 
if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly
}

if( !class_exists('Red8_Page_Jump') ) {
	
	class Red8_Page_Jump {
		
		function __construct() {
			self::define_constants();
			self::load_hooks();
		}
		
		public static function define_constants() {
			define('RED8_FUNCTIONALITY_PAGE_JUMP_PLUGIN_NAME', 'red8_func_page_jump');
			define('RED8_FUNCTIONALITY_PAGE_JUMP_BG_COLOR', 'page_jump_background_color');
			define('RED8_FUNCTIONALITY_PAGE_JUMP_BORDER_RADIUS', 'page_jump_border_radius');
		}
		
		public static function load_hooks() {
			add_action('wp_footer', array(__CLASS__, 'red8_func_add_page_jump'));
			
			add_action('wp_enqueue_scripts', array(__CLASS__, 'red8_func_enqueue_page_jump_scripts'));
			
			add_action('admin_menu', array(__CLASS__, 'red8_func_page_jump_create_menu'));
			
			add_action('admin_init', array(__CLASS__, 'initialize_admin_posts'));
		}
		
		public static function red8_func_page_jump_create_menu() {
			add_submenu_page('red8-functionality-plugin', 'Page Jump', 'Page Jump', 'manage_options', RED8_FUNCTIONALITY_PAGE_JUMP_PLUGIN_NAME, array(__CLASS__, 'red8_func_page_jump_menu'));
		}
		
		public static function red8_func_page_jump_menu() {
			self::red8_func_page_jump_admin_scripts();
			include 'templates/settings-menu.php';
		}
		
		
		public static function red8_func_add_page_jump() {
			echo '<style>.cd-top { background-color: '.get_option(RED8_FUNCTIONALITY_PAGE_JUMP_BG_COLOR, '#000').'; border-radius: '.get_option(RED8_FUNCTIONALITY_PAGE_JUMP_BORDER_RADIUS).'%; } </style><a href="#0" class="cd-top">Top</a>';
		}
		
		
		public static function red8_func_enqueue_page_jump_scripts() {
			wp_enqueue_style( 'red8-func-page-jump', plugins_url('css/style.css', __FILE__) );
			
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'red8-func-page-jump', plugins_url('js/main.js', __FILE__), array('jquery'), '1.0.0', true );
		}
		
		public static function red8_func_page_jump_admin_scripts() {
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'colorpicker-js', plugins_url('colorpicker/js/colorpicker.js', __FILE__), array('jquery'), '', true );
			wp_enqueue_style( 'colorpicker-css', plugins_url('colorpicker/css/colorpicker.css', __FILE__) );
		}
		
		// Admin Hooks
		public static function initialize_admin_posts() {
			add_action('admin_post_update_page_jump_settings', array(__CLASS__, 'update_page_jump_settings')); // If the user is logged in
		}
		
		public static function update_page_jump_settings() {
			if($_POST['page_jump_background_color']) {
				$bg_color = sanitize_text_field($_POST['page_jump_background_color']);
				update_option(RED8_FUNCTIONALITY_PAGE_JUMP_BG_COLOR, $bg_color);
			}
			
			if($_POST['page_jump_border_radius']) {
				$border_radius = intval(esc_attr($_POST['page_jump_border_radius']));
				update_option(RED8_FUNCTIONALITY_PAGE_JUMP_BORDER_RADIUS, $border_radius);
			}
			
			$redirect_url = get_admin_url().'admin.php?page='.RED8_FUNCTIONALITY_PAGE_JUMP_PLUGIN_NAME.'&updated=true';
			wp_redirect($redirect_url);
			exit();
		}
	}
	
	$class['Red8_Page_Jump'] = new Red8_Page_Jump();
}

?>