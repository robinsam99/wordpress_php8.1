<?php
	
	//Prevents the file from being accesssed directly.
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	if( !class_exists('Sliding_Sidebar') ) {
		
		class Sliding_Sidebar {
		
			function __construct() {
				self::define_constants();
				self::load_hooks();
			}
	
			/**
			* Defines plugin constants
			*/
			public static function define_constants() {
				define('SLIDING_SIDEBAR_PATH', plugins_url( '', __FILE__ ) ); 
				define('SLIDING_SIDEBAR_DIR', plugin_dir_path( __FILE__ ));
				define('SLIDING_SIDEBAR_BASENAME', plugin_basename( __FILE__ ));
				define('SLIDING_SIDEBAR_PLUGIN_NAME', 'sliding-sidebar');
			}
			
			public static function load_hooks() {
				// Backend Scripts
				add_action('admin_enqueue_scripts', array(__CLASS__, 'sliding_sidebar_admin_scripts'));
			}
			
			public static function sliding_sidebar_admin_scripts() {
				// CSS Files
				wp_register_style('sliding-sidebar-admin', SLIDING_SIDEBAR_PATH . '/css/admin.css');
				wp_enqueue_style('sliding-sidebar-admin');
				
				// JS Files
				wp_enqueue_script( 'sliding_sidebar_js', SLIDING_SIDEBAR_PATH . '/js/admin.js', array('jquery'), '', true );
			}
		}
		
		$class['Sliding_Sidebar'] = new Sliding_Sidebar();
	}
?>