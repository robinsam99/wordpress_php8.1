<?php
	/**
	* Plugin Name: Red8 Functionality Plugin
	* Plugin URI: http://red8interactive.com
	* Description: A functionality plugin for Red8 websites
	* Version: 0.5
	* Author: Red8 Interactive
	* Author URI: http://red8interactive.com
	* License: GPL2
	*/
 
	/*  
		Copyright 2014 Red8 Interactive  (email : james@red8interactive.com) 
	
		This program is free software; you can redistribute it and/or
		modify it under the terms of the GNU General Public License
		as published by the Free Software Foundation; either version 2
		of the License, or (at your option) any later version.
		
		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.
		
		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	*/
	
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
	
	if( !class_exists('Red8_Functionality') ) {
		
		class Red8_Functionality {
			
			private static $red8_functionality_error_message = null;
			private static $extensions = null;
		
			function __construct() {
				self::define_constants();
				self::load_extensions_hooks();
				self::activate_extension_plugins();
			}
	
			
			//Defines plugin constants
			public static function define_constants() {
				define('RED8_FUNCTIONALITY_PATH', plugins_url( ' ', __FILE__ ) ); 
				define('RED8_FUNCTIONALITY_BASENAME', plugin_basename( __FILE__ ));
				define('RED8_FUNCTIONALITY_EXTENSION_INFO', 'extensions/info.php');
				define('RED8_FUNCTIONALITY_PLUGIN_NAME', 'red8-functionality-plugin');
				define('RED8_FUNCTIONALITY_SHOW_NOTIFICATIONS', 'red8-functionality-show-notifications');
				define('RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATES', 'red8-functionality-plugin-auto-updates');
				define('RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATE_STATUS', 'red8-functionality-plugin-auto-update-status');
			}
			
			
			// Load our hooks for the extensions portion
			public static function load_extensions_hooks() {
				
				// Add our admin settings page
				add_action('admin_menu', array(__CLASS__, 'red8_func_create_menu'));
				
				// Update our settings when save button is pressed
				add_action('admin_post_update_red8_functionality_extensions', array(__CLASS__, 'update_red8_functionality_extensions')); 
				add_action('admin_post_update_red8_functionality_settings', array(__CLASS__, 'update_red8_functionality_settings')); 
				add_action('admin_post_update_red8_functionality_update_settings', array(__CLASS__, 'update_red8_functionality_update_settings')); 
				
				add_action('admin_init', array(__CLASS__, 'red8_func_check_for_notices'));
				
				$update_status = get_option(RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATE_STATUS, 'individual');

				if($update_status == 'on') {
					add_filter( 'auto_update_plugin', '__return_true' );
				} else if($update_status == 'off') {
					add_filter( 'auto_update_plugin', '__return_false' );
				} else {
					add_filter( 'auto_update_plugin', array(__CLASS__, 'red8_func_auto_update_plugins'), 10, 2 );
				}
			}
			
			
			public static function red8_func_auto_update_plugins( $update, $item ) {
				// Array of plugin slugs to always auto-update
			    $plugins = unserialize(get_option(RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATES)); 
			    if($plugins && is_array($plugins) && in_array( $item->slug, $plugins )) {
					return true; // Always update plugins in this array
			    } else {
			    	return $update;
			    }
			}
			
			
			public static function get_extension_info() {
				self::$extensions = include(RED8_FUNCTIONALITY_EXTENSION_INFO);
			}
			
			public static function activate_extension_plugins() {
				if(!self::$extensions) {
					self::get_extension_info();
				}
				
				foreach(self::$extensions as $extension) {
					$is_active = get_option($extension['option_name'], 0);
					$can_run = true;
					$notice_name = $extension['notice_name'];
					if($notice_name) {
						$can_run = self::can_plugin_run($extension);
					}
					
					if($extension['name'] == 'filter_pro') {
						$current_theme = wp_get_theme();
						if($current_theme->get('Template') == 'red8-base') {
							$is_active = 0;
						}
					} else if($extension['name'] == 'footer_popup' || $extension['name'] == 'yoast_acf') {
						$is_active = 0;
					}
					
					if($is_active == 1 && $can_run) {
						include_once 'extensions/'.$extension['file'];
					} else {
						update_option($extension['option_name'], 0);
					}
				}
			}
			
			public static function can_plugin_run($extension) {
				$notice_name = $extension['notice_name'];
				$notice_message = $extension['notice_message'];
				
				$plugin_active = true;
				if($notice_name) {
					$active_plugins_list = get_option('active_plugins');
					
					$plugin_active = false;
					$plugins_active = false;
					if($notice_name) {
						if(is_array($notice_name)) {
							$plugins_active = true;
							foreach($notice_name as $nn) {
								if($nn == 'advanced-custom-fields-pro/acf.php') {
									$is_active = true;	
								} else {
									$is_active = in_array($nn, $active_plugins_list);
								}
								if(!$is_active) {
									$plugins_active = false;
									break;
								}
							}
						} else {
							if($notice_name == 'advanced-custom-fields-pro/acf.php') {
								$plugin_active = true;	
							} else {
								$plugin_active = in_array($notice_name, $active_plugins_list);
							}
						}
					}
				}
				
				return ($plugin_active || $plugins_active);
			}
			
			public static function red8_func_check_for_notices() {
				$show_notifications = get_option(RED8_FUNCTIONALITY_SHOW_NOTIFICATIONS, 1);
				
				if($show_notifications == 1) {
					if(!self::$extensions) {
						self::get_extension_info();
					}
					
					foreach(self::$extensions as $extension) {
						$is_active = get_option($extension['option_name'], 0);
						if($is_active != 1) {
							$plugin_active = self::can_plugin_run($extension);
							
							$notice_name = $extension['notice_name'];
							$notice_message = $extension['notice_message'];
							
							$is_dismissing = false;
							if(isset($_GET['dismiss_extension'])) {
								$dismess_extension = esc_attr($_GET['dismiss_extension']);
								if($dismess_extension == $extension['name']) {
									$is_dismissing = true;
								}
							}
							
							if($plugin_active && $notice_name && get_user_meta(get_current_user_id(), $extension['dismiss_title'], true) != 1 && !$is_dismissing && $extension['name'] != 'yoast_acf') {
								$message = '<p>'.$notice_message.' <a href="'.get_admin_url().'admin.php?page='.RED8_FUNCTIONALITY_PLUGIN_NAME.'">Red8 Functionality Settings</a> | <a href="'.get_admin_url().'admin.php?page='.RED8_FUNCTIONALITY_PLUGIN_NAME.'&dismiss_extension='.$extension['name'].'">Dismiss Notice</a></p>';
								if(self::$red8_functionality_error_message) {
									self::$red8_functionality_error_message .= '<br>'.$message;
								} else {
									self::$red8_functionality_error_message = $message;
								}
							}
						}
					}
					
					if(self::$red8_functionality_error_message) {
						add_action('admin_notices', array(__CLASS__, 'red8_func_admin_header_notices'));
					}
				}
			}
			
			public static function red8_func_admin_header_notices() {
				?>
				<div class="update-nag">
					<?php echo self::$red8_functionality_error_message; ?>
				</div>
				<?php
			}
			
			public static function red8_func_dismiss_admin_notice($dismiss_extension) {
				update_user_meta(get_current_user_id(), $dismiss_extension, 1);
			}
			
			
			
			
			/**************************************************
			*
			* Extensions Plugin functions
			*
			**************************************************/
			
			// Create our admin screen
			public static function red8_func_create_menu() {
				//add_options_page('Red8 Functionality', 'Red8 Functionality', 'manage_options', __FILE__, array(__CLASS__, 'red8_func_settings_page'));
				add_menu_page('Red8 Functionality', 'Red8 Plugins', 'manage_options', 'red8-functionality-plugin', array(__CLASS__, 'red8_func_settings_page'), plugin_dir_url( __FILE__ ).'menu-page-icon.ico');
				add_submenu_page('red8-functionality-plugin', 'Red8 Functionality', 'Red8 Plugins', 'manage_options', 'red8-functionality-plugin', array(__CLASS__, 'red8_func_settings_page'));
			}
			
			// Tabs
			public static function red8_func_admin_tabs( $current = 'extensions' ) {
				$tabs = array('extensions' => 'Extensions', 'updates' => 'Auto Updates', 'settings' => 'Settings');
				echo '<h2>Red8 Functionality Plugin</h2>';
				echo '<h2 class="nav-tab-wrapper" style="margin-bottom: 20px;">';
				foreach($tabs as $tab => $name) {
					$class = ($tab == $current) ? ' nav-tab-active' : '';
					echo "<a class='nav-tab$class' href='?page=".RED8_FUNCTIONALITY_PLUGIN_NAME."&tab=$tab'>$name</a>";
				}
				echo '</h2>';
			}
			
			// Show our admin screen
			public static function red8_func_settings_page() {
				self::red8_func_admin_scripts();
				
				// Get our extensions info
				if(!self::$extensions) {
					self::get_extension_info();
				}
				
				if(isset($_GET['dismiss_extension'])) {
					$extension_name = esc_attr($_GET['dismiss_extension']);
					foreach(self::$extensions as $extension) {
						if($extension['name'] == $extension_name) {
							self::red8_func_dismiss_admin_notice($extension['dismiss_title']);
						}
					}
				}
				
				?>
				<div class="wrap">
					
					<?php if(isset($_GET['updated']) && $_GET['updated'] == 'true') : ?>
						<div class="message updated">
							<p>Settings Saved Successfully</p>
						</div>
					<?php endif; ?>
					
					<?php 
						global $pagenow;

						if(isset($_GET['tab'])) {
							self::red8_func_admin_tabs($_GET['tab']);
							$pagenow = $_GET['tab']; 
						} else {
							self::red8_func_admin_tabs('extensions'); 
							$pagenow = 'extensions';
						}
						
						if($pagenow == 'extensions') {
							include 'templates/extensions-admin.php';
						} else if($pagenow == 'updates') {
							include 'templates/updates-admin.php';
						} else {
							include 'templates/settings-admin.php';
						}
					?>
					
				</div>
				<?php
			}
			
			// Save our extension settings
			public static function update_red8_functionality_extensions() {
				if(!self::$extensions) {
					self::get_extension_info();
				}
				
				foreach(self::$extensions as $extension) {
					$is_active = 0;
					$current_status = get_option($extension['option_name'], 0);
					if($_POST[$extension['option_title']] && self::can_plugin_run($extension)) {
						$is_active = 1;
					}
					if($is_active != $current_status) {
						update_user_meta(get_current_user_id(), $extension['dismiss_title'], 0);
					}
					update_option($extension['option_name'], $is_active);
				}
				
				$redirect_url = get_admin_url().'admin.php?page='.RED8_FUNCTIONALITY_PLUGIN_NAME.'&updated=true';
				wp_redirect($redirect_url);
				exit();
			}
			
			// Save our plugin update settings
			public static function update_red8_functionality_update_settings() {
				$status = 'individual';
				$update_status = esc_attr($_POST[RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATE_STATUS]);
				if($update_status == 'individual') {
					$update_array = array();				
					foreach($_POST['plugin_auto_updates'] as $key => $value) {
						$update_array[] = esc_attr($value);
					}
					
					update_option(RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATES, serialize($update_array));
				} else if($update_status == 'off') {
					$status = 'off';
				} else if($update_status == 'on') {
					$status = 'on';
				}
				
				update_option(RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATE_STATUS, $status);
				
				$redirect_url = get_admin_url().'admin.php?page='.RED8_FUNCTIONALITY_PLUGIN_NAME.'&tab=updates&updated=true';
				wp_redirect($redirect_url);
				exit();
			}
			
			
			// Save our plugin settings
			public static function update_red8_functionality_settings() {
				$show_notifications = 0;
				if($_POST[RED8_FUNCTIONALITY_SHOW_NOTIFICATIONS]) {
					$show_notifications = 1;
				}
				update_option(RED8_FUNCTIONALITY_SHOW_NOTIFICATIONS, $show_notifications);
				
				$redirect_url = get_admin_url().'admin.php?page='.RED8_FUNCTIONALITY_PLUGIN_NAME.'&tab=settings&updated=true';
				wp_redirect($redirect_url);
				exit();
			}
			
			// Our Admin Scripts
			public static function red8_func_admin_scripts() {
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'red8-functionality-plugin', RED8_FUNCTIONALITY_PATH . 'js/main.js', array('jquery'), '', true );
			}
		}

		$class['Red8_Functionality'] = new Red8_Functionality();
	}
?>