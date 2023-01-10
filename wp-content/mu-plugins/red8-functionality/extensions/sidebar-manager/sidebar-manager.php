<?php

	if ( ! defined( 'ABSPATH' ) ) { 
    	die; // Exit if accessed directly
	}
	
	if( !class_exists('Red8_Sidebar_Manager') ) {
		
		class Red8_Sidebar_Manager {
		
			function __construct() {
				self::define_constants();
				self::load_hooks();
			}
			
			// Defines plugin constants
			public static function define_constants() {
				define('RED8_SIDEBAR_MANAGER_PATH', plugins_url( ' ', __FILE__ ) ); 
				define('RED8_SIDEBAR_MANAGER_BASENAME', plugin_basename( __FILE__ ));
				define('RED8_SIDEBAR_MANAGER_OPTION_GROUP', 'sidebar_manager_options');
				define('RED8_SIDEBAR_MANAGER_PLUGIN_NAME', 'sidebar_manager');
				define('RED8_SIDEBAR_INCREMENT', 'sidebar_manager_incrementer');
				define('RED8_SIDEBAR_HAS_SIDEBAR', '_sidebar_manager_has_sidebar');
				define('RED8_SIDEBAR_META_VALUE', '_sidebar_manager_current_sidebar');
				define('RED8_SIDEBAR_DEFAULT_SIDEBAR', 'sidebar_manager_default_sidebar_id');
			}
			
			public static function enqueue_styles() {
				wp_enqueue_style(
					'sidebar-manager-admin',
					RED8_SIDEBAR_MANAGER_PATH.'/assets/css/admin.css',
					array(), VERSION
				);
			}
			
			public static function enqueue_scripts() {
				wp_enqueue_script(
					'sidebar-manager-admin',
					RED8_SIDEBAR_MANAGER_PATH.'/assets/js/admin.js',
					array('jquery'), VERSION
				);
			}
			
			public static function load_hooks() {
				add_action('admin_init', array(__CLASS__, 'sidebar_manager_actions'));
				
				add_action('admin_init', array(__CLASS__, 'sidebar_manager_settings'));
				
				add_action('admin_menu', array(__CLASS__, 'sidebar_manager_create_menu'));
				
				add_action('init', array(__CLASS__, 'register_custom_sidebar') );
				
				add_action( 'add_meta_boxes', array(__CLASS__, 'sidebar_manager_add_meta_box') );
				
				add_action( 'save_post', array(__CLASS__, 'sidebar_manager_save_meta_box_data') );
			}

			/*************************************************
			 * Admin Area
			**************************************************/
			
			public static function sidebar_manager_create_menu() {
				add_submenu_page('red8-functionality-plugin', "Sidebar Manager", "Sidebar Manager", 'manage_options', RED8_SIDEBAR_MANAGER_PLUGIN_NAME, array(__CLASS__, 'sidebar_manager_page'));
			}
			
			public static function sidebar_manager_page() {
				self::enqueue_styles();
				self::enqueue_scripts();
				
				if(isset($_GET['id'])) {
					include 'templates/edit-sidebar.php';
				} else if(isset($_GET['add'])) {
					include 'templates/add-sidebar.php';
				} else {
					include 'templates/view-all-sidebars.php';
				}
			}
			
			
			/**
			 * Adds a box to the main column on the Post and Page edit screens.
			 */
			public static function sidebar_manager_add_meta_box() {
				
				$screens = apply_filters('sidebar_manager_page_types', array());
			
				$screens[] = 'post';
				$screens[] = 'page';
				
				$cpt_objects = unserialize(get_option('cpt_creator_options'));
				if($cpt_objects) {
					foreach($cpt_objects as $cpt) {
						$screens[] = str_replace(" ", "-", strtolower($cpt->post_type_name));
					}
				}
			
				foreach ( $screens as $screen ) {
			
					add_meta_box(
						'sidebar_manager_section',
						__( 'Sidebar Manager', 'sidebar_manager' ),
						array(__CLASS__, 'sidebar_manager_meta_box_callback'),
						$screen,
						'side',
						'low'
					);
				}
			}
			
			
			public static function sidebar_manager_meta_box_callback($post) {
				// Add a nonce field so we can check for it later.
				wp_nonce_field( 'sidebar_manager_save_meta_box_data', 'sidebar_manager_meta_box_nonce' );
				
				$has_sidebar = get_post_meta($post->ID, RED8_SIDEBAR_HAS_SIDEBAR, true);
				$checked = '';
				if($has_sidebar) {
					$checked = 'checked="checked"';
				}
				
				echo '<div calss="inside">';
				echo '<p><strong>Has Sidebar?</strong></p>';
				echo '<input type="checkbox" name="'.RED8_SIDEBAR_HAS_SIDEBAR.'" '.$checked.' />';
				
				$current_sidebar = get_post_meta($post->ID, RED8_SIDEBAR_META_VALUE, true);
				
				global $wp_registered_sidebars;
				
				echo '<p><strong>Post/Page Sidebar</strong></p>';
				echo '<select name="'.RED8_SIDEBAR_META_VALUE.'"><option value="">Default</option>';
				if ($wp_registered_sidebars) {
				
					foreach($wp_registered_sidebars as $key => $sidebar) {
						$selected = '';
						if($current_sidebar == $sidebar['id']) {
							$selected = 'selected="selected"';
						}
						echo '<option value="'.$sidebar['id'].'"'.$selected.'>'.$sidebar['name'].'</option>';
					}
					
				}
				echo '</select></div>';
			}
			
			
			public static function sidebar_manager_save_meta_box_data($post_id) {
				// Check if our nonce is set.
				if ( ! isset( $_POST['sidebar_manager_meta_box_nonce'] ) ) {
					return;
				}
			
				// Verify that the nonce is valid.
				if ( ! wp_verify_nonce( $_POST['sidebar_manager_meta_box_nonce'], 'sidebar_manager_save_meta_box_data' ) ) {
					return;
				}
			
				// If this is an autosave, our form has not been submitted, so we don't want to do anything.
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
					return;
				}
			
				// Check the user's permissions.
				if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			
					if ( ! current_user_can( 'edit_page', $post_id ) ) {
						return;
					}
			
				} else {
			
					if ( ! current_user_can( 'edit_post', $post_id ) ) {
						return;
					}
				}
			
				// Get sidebar
				$has_sidebar = isset($_POST[RED8_SIDEBAR_HAS_SIDEBAR]) ? 1 : 0;
			
				// Update the meta field in the database.
				update_post_meta( $post_id, RED8_SIDEBAR_HAS_SIDEBAR, $has_sidebar );
				
				
				
				// Make sure that it is set.
				if ( ! isset( $_POST[RED8_SIDEBAR_META_VALUE] ) ) {
					return;
				}
			
				// Get sidebar
				$sidebar_id = esc_attr( $_POST[RED8_SIDEBAR_META_VALUE] );
			
				// Update the meta field in the database.
				update_post_meta( $post_id, RED8_SIDEBAR_META_VALUE, $sidebar_id );
			}
						
			
			public static function sidebar_manager_settings() {
				add_action('admin_post_add_new_sidebar', array(__CLASS__, 'add_new_sidebar'));
				add_action('admin_post_update_sidebar', array(__CLASS__, 'update_sidebar'));
				add_action('admin_post_delete_sidebar', array(__CLASS__, 'delete_sidebar'));
				add_action('admin_post_update_default_sidebar', array(__CLASS__, 'update_default_sidebar'));
			}
			
			public static function register_custom_sidebar() {
				$sidebars = unserialize(get_option(RED8_SIDEBAR_MANAGER_OPTION_GROUP));
				
				if ($sidebars) {
					
					$current_theme = wp_get_theme();
				
					foreach($sidebars as $sidebar) {
											
						register_sidebar( array(
							'name'          => __( esc_attr($sidebar->name), $current_theme->get('Template') ),
							'id'            => esc_attr($sidebar->sidebar_id),
							'description' 	=> esc_attr($sidebar->description),
							'class'  		=> esc_attr($sidebar->sidebar_class),
							'before_widget' => html_entity_decode(esc_attr($sidebar->before_widget), ENT_QUOTES, 'cp1252'),
							'after_widget'  => html_entity_decode(esc_attr($sidebar->after_widget), ENT_QUOTES, 'cp1252'),
							'before_title'  => html_entity_decode(esc_attr($sidebar->before_title), ENT_QUOTES, 'cp1252'),
							'after_title'   => html_entity_decode(esc_attr($sidebar->after_title), ENT_QUOTES, 'cp1252'),
						) );
					}
				}
			}

			
			public static function add_new_sidebar() {
			
				$sidebars = unserialize(get_option(RED8_SIDEBAR_MANAGER_OPTION_GROUP));
				$id = 1;
				
				if (get_option(RED8_SIDEBAR_INCREMENT)) {
					$id = intval(get_option(RED8_SIDEBAR_INCREMENT)) + 1;
				}
				update_option(RED8_SIDEBAR_INCREMENT, $id);
				
				$sidebar = new Red8_Sidebar();
				$sidebar->id = $id;
				$sidebar->name = sanitize_text_field($_POST['sidebar_name']);
				$sidebar->sidebar_id = sanitize_text_field($_POST['sidebar_id']);
				$sidebar->description = sanitize_text_field($_POST['sidebar_description']);
				$sidebar->sidebar_class = sanitize_text_field($_POST['sidebar_class']);
				$sidebar->before_widget = stripslashes(esc_attr($_POST['before_widget']));
				$sidebar->after_widget = stripslashes(esc_attr($_POST['after_widget']));
				$sidebar->before_title = stripslashes(esc_attr($_POST['before_title']));
				$sidebar->after_title = stripslashes(esc_attr($_POST['after_title']));
				
				$sidebars[] = $sidebar;
				update_option(RED8_SIDEBAR_MANAGER_OPTION_GROUP, serialize($sidebars));

				wp_redirect( get_admin_url() . 'admin.php?page=' .RED8_SIDEBAR_MANAGER_PLUGIN_NAME. '&msg=add_new' );
				exit();
				
			}//end add_new_Cpt function
			
			public static function update_sidebar() {
				$sidebars = unserialize(get_option(RED8_SIDEBAR_MANAGER_OPTION_GROUP));
				$current_sidebar = NULL;
				$unique_id = $_POST['id'];
				$i = 0;
				
				if($sidebars) {
					
					foreach($sidebars as $sidebar) {

						if($sidebar->id == $unique_id) {
							$current_sidebar = $sidebar;
							break;
						}
						$i++;
					}
				}

				if ($current_sidebar) {
					$current_sidebar->id = $unique_id;
					$current_sidebar->name = sanitize_text_field($_POST['sidebar_name']);
					$current_sidebar->sidebar_id = sanitize_text_field($_POST['sidebar_id']);
					$current_sidebar->description = sanitize_text_field($_POST['sidebar_description']);
					$current_sidebar->sidebar_class = sanitize_text_field($_POST['sidebar_class']);
					$current_sidebar->before_widget = stripslashes(esc_attr($_POST['before_widget']));
					$current_sidebar->after_widget = stripslashes(esc_attr($_POST['after_widget']));
					$current_sidebar->before_title = stripslashes(esc_attr($_POST['before_title']));
					$current_sidebar->after_title = stripslashes(esc_attr($_POST['after_title']));
					$sidebars[$i] = $current_sidebar;
					update_option(RED8_SIDEBAR_MANAGER_OPTION_GROUP, serialize($sidebars));
				}
				
				$sidebar_id = '';
				if($current_sidebar) {
					$sidebar_id = '&id='.$current_sidebar->id;
				}
				
				wp_redirect( get_admin_url() . 'admin.php?page='.RED8_SIDEBAR_MANAGER_PLUGIN_NAME.'&msg=update_sidebar' );
				exit();
			}
			
			public static function delete_sidebar() {

				$sidebars = unserialize(get_option(RED8_SIDEBAR_MANAGER_OPTION_GROUP));
				$current_sidebar = get_option(RED8_SIDEBAR_DEFAULT_SIDEBAR, '');
				$id = $_GET['key'];
				$i = 0;

				if($sidebars) {
			
					foreach($sidebars as $sidebar) {

						if($sidebar->id == $id) {
							if($sidebar->sidebar_id == $current_sidebar) {
								delete_option(RED8_SIDEBAR_DEFAULT_SIDEBAR);
							}
							
							break;
						}
						$i++;
					}
					
					if (count($sidebars) > 1) {
						unset($sidebars[$i]);
						update_option( RED8_SIDEBAR_MANAGER_OPTION_GROUP, serialize($sidebars) );
						wp_redirect( get_admin_url() . 'admin.php?page='.RED8_SIDEBAR_MANAGER_PLUGIN_NAME.'&msg=delete_sidebar' );
						exit();
					} else {
						unset($sidebars[$i]);
						delete_option( RED8_SIDEBAR_MANAGER_OPTION_GROUP, serialize($sidebars) );
						delete_option(RED8_SIDEBAR_INCREMENT);
						wp_redirect( get_admin_url() . 'admin.php?page='.RED8_SIDEBAR_MANAGER_PLUGIN_NAME.'&msg=delete_sidebar' );
						exit();
					}
				}
			}
			
			public static function update_default_sidebar() {
				if($_POST[RED8_SIDEBAR_DEFAULT_SIDEBAR]) {
					$default_sidebar = esc_attr($_POST[RED8_SIDEBAR_DEFAULT_SIDEBAR]);
					update_option(RED8_SIDEBAR_DEFAULT_SIDEBAR, $default_sidebar);
				}
				
				wp_redirect( get_admin_url() . 'admin.php?page='.RED8_SIDEBAR_MANAGER_PLUGIN_NAME.'&msg=update_default' );
				exit();
			}
			
			public static function sidebar_manager_actions(){
				
				if ( isset( $_GET['action'] ) && $_GET['action'] == 'delete_sidebar' ) {
					self::delete_sidebar();
				}
			}
			
		} //end class Red8_Sidebar_Manager
		
		 $class['Red8_Sidebar_Manager'] = new Red8_Sidebar_Manager();
		
	} // end 'if class exists'
	

	if (!class_exists('Red8_Sidebar')) {
	
		class Red8_Sidebar {
			
			//options
			public $id;
			public $sidebar_id;
			public $name;
			public $description;
			public $sidebar_class;
			public $before_widget;
			public $after_widget;
			public $before_title;
			public $after_title;
		
			function __construct() {
				
			}
		} 
	}
