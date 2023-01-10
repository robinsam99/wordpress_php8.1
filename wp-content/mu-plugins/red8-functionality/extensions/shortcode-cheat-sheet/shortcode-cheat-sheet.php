<?php
	
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
	
	if( !class_exists('Shortcode_Cheat_Sheet') ) {
		
		class Shortcode_Cheat_Sheet {
			
			function __construct() {
				self::define_constants();
				self::load_hooks();
			}
	
			/*************************
			* Defines plugin constants
			**************************/
			public static function define_constants() {
				define('SHORTCODE_CHEAT_SHEET_PATH', plugins_url( ' ', __FILE__ ) ); 
				define('SHORTCODE_CHEAT_SHEET_BASENAME', plugin_basename( __FILE__ ));
				define('SHORTCODE_CHEAT_SHEET_NAME', 'shortcode_cheatsheet');
			}
			
			/*************************
			* Load hooks
			**************************/
			public static function load_hooks() {
				
				//adding "Add Button" button on top of wysiwyg
				add_action( 'media_buttons', array(__CLASS__, 'add_shortcode_button' ), 22);
				
				add_action( 'admin_footer',  array(__CLASS__, 'add_mce_popup' ));
			}



			/******************************
			*	
			* Admin Functions
			*
			*******************************/
			
			// Shortcode Button
			public static function add_shortcode_button() {
				// display button matching new UI
	            echo '<style>
	                    .wp-core-ui a.add_button_button{
	                     padding-left: 0.4em;
	                    }
	                 </style>
	                  <a href="#TB_inline?width=480&height=1000&inlineId=select_shortcode" class="thickbox button add_shortcode_button" id="add_shortcode_button" title="' . __("Add Shortcode", 'shortcode_cheatsheet') . '"><span class="dashicons dashicons-editor-code" style="top: 3px; position: relative;"></span> ' . __("Add Shortcode", "shortcode_cheatsheet") . '</a>';
			}
			
			
			public static function add_mce_popup() {
				include 'templates/shortcode-cheat-sheet.php';
			}
			
			// Enqueue Admin Scripts
			public static function shortcode_cheat_sheet_admin_scripts() {
				wp_enqueue_script( 'jquery' , array(), '', true );
				wp_enqueue_script( 'shortcode-cheat-sheet-admin-js', plugins_url('/js/admin.js', __FILE__), array('jquery'), '', true );
			}
		}
			
		$class['Shortcode_Cheat_Sheet'] = new Shortcode_Cheat_Sheet();
	}
?>