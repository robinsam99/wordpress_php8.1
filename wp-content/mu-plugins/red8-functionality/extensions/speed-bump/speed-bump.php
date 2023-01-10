<?php
	
	//Prevents the file from being accesssed directly.
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	if( !class_exists('Speed_Bump') ) {
		
		class Speed_Bump {
		
			function __construct() {
				self::define_constants();
				self::load_hooks();
				self::create_shortcodes();
			}
	
			/**
			* Defines plugin constants
			*/
			public static function define_constants() {
				define('SPEED_BUMP_PATH', plugins_url( '', __FILE__ ) ); 
				define('SPEED_BUMP_DIR', plugin_dir_path( __FILE__ ));
				define('SPEED_BUMP_BASENAME', plugin_basename( __FILE__ ));
				define('SPEED_BUMP_PLUGIN_NAME', 'speed-bump');
				
				define('WP_SPEED_BUMP_OPTION_GROUP', 'speed_bump_options' );
				define('WP_SPEED_BUMP_TITLE', 'speed_bump_title' );
				define('WP_SPEED_BUMP_TEXT', 'speed_bump_text' );
				define('WP_SPEED_BUMP_OK_TITLE', 'speed_bump_ok_title' );
				define('WP_SPEED_BUMP_CANCEL_TITLE', 'speed_bump_cancel_title' );
			}
			
			public static function load_hooks() {
				// Setup Shortcode and TinyMCE button
				add_action( 'init', array(__CLASS__, 'speed_bump_buttons') );
				
				// Admin Menu
				add_action('admin_menu', array(__CLASS__, 'speed_bump_create_menu'));
				add_action('admin_init', array(__CLASS__, 'initialize_admin_posts'));
				
				// Admin Popup
				add_action( 'admin_footer', array(__CLASS__, 'speed_bump_admin_popup')); 
				
				// Footer HTML Content
				add_action( 'wp_footer', array(__CLASS__, 'add_popup_content'));
				
				// Frontend Scripts
				add_action( 'wp_enqueue_scripts', array(__CLASS__, 'frontend_scripts'));
				
				// Backend Scripts
				add_action('admin_enqueue_scripts', array(__CLASS__, 'speed_bump_admin_scripts'));
			}
			
			
			// Admin Menu
			public static function speed_bump_create_menu() {
				add_submenu_page('red8-functionality-plugin', 'Speed Bump', 'Speed Bump', 'manage_options', SPEED_BUMP_PLUGIN_NAME, array(__CLASS__, 'speed_bump_admin_menu'));
				add_action('admin_init', array(__CLASS__, 'register_speed_bump_settings'));
			}
			
			public static function speed_bump_admin_menu() {
				self::speed_bump_options_scripts();
				
				include 'templates/options-page.php';
			}
			
			public static function register_speed_bump_settings() {
				register_setting( WP_SPEED_BUMP_OPTION_GROUP, WP_SPEED_BUMP_TITLE, 'sanitize_text_field' );
				register_setting( WP_SPEED_BUMP_OPTION_GROUP, WP_SPEED_BUMP_TEXT, 'esc_textarea' );
				register_setting( WP_SPEED_BUMP_OPTION_GROUP, WP_SPEED_BUMP_OK_TITLE, 'sanitize_text_field' );
				register_setting( WP_SPEED_BUMP_OPTION_GROUP, WP_SPEED_BUMP_CANCEL_TITLE, 'sanitize_text_field' );
			}
			
			// Admin Hooks
			public static function initialize_admin_posts() {
				add_action('admin_post_update_speed_bump_settings', array(__CLASS__, 'update_speed_bump_settings')); // If the user is logged in
			}
			
			public static function update_speed_bump_settings() {
				if($_POST['speed_bump_title']) {
					$speed_bump_title = sanitize_text_field($_POST['speed_bump_title']);
					update_option(WP_SPEED_BUMP_TITLE, $speed_bump_title);
				}
				
				if($_POST['speed_bump_text']) {
					$speed_bump_text = esc_textarea($_POST['speed_bump_text']);
					update_option(WP_SPEED_BUMP_TEXT, $speed_bump_text);
				}
				
				if($_POST['speed_bump_agree']) {
					$speed_bump_ok_title = sanitize_text_field($_POST['speed_bump_agree']);
					update_option(WP_SPEED_BUMP_OK_TITLE, $speed_bump_ok_title);
				}
				
				if($_POST['speed_bump_cancel']) {
					$speed_bump_canel_title = sanitize_text_field($_POST['speed_bump_cancel']);
					update_option(WP_SPEED_BUMP_CANCEL_TITLE, $speed_bump_canel_title);
				}
				
				$redirect_url = get_admin_url().'admin.php?page='.SPEED_BUMP_PLUGIN_NAME.'&updated=true';
				wp_redirect($redirect_url);
				exit();
			}
			
			
			
			
			// TinyMCE Button
			public static function speed_bump_buttons() {
			    add_filter( "mce_external_plugins", array(__CLASS__, "speed_bump_add_buttons") );
			    add_filter( 'mce_buttons', array(__CLASS__, 'speed_bump_register_buttons') );
			}
			
			public static function speed_bump_add_buttons( $plugin_array ) {
			    $plugin_array['speed_bump'] = SPEED_BUMP_PATH . '/js/speed-bump-plugin.js';
			    return $plugin_array;
			}
			
			public static function speed_bump_register_buttons( $buttons ) {
			    array_push( $buttons, 'speedbump' ); // dropcap', 'recentposts
			    return $buttons;
			}
			
			
			
			// Shortcode
			public static function create_shortcodes() {
				add_shortcode('speed_bump', array(__CLASS__, 'speed_bump_link'));
			}
			
			public static function speed_bump_link($atts, $content = null){
				extract (shortcode_atts(array(
					'link' => 'null',
				), $atts));
				
				return '<a class="alert" href="#alert" data-link="'.$link.'">'.$content.'</a>';
			}
			
			
			
			// HTML Popup Content
			public static function add_popup_content() {
				?>
					<div id="alert">
						<div class="alert_content">
							<img src="<?php echo bloginfo('template_url'); ?>/images/logo.png" />
							<p><?php echo get_option(WP_SPEED_BUMP_TITLE); ?></p>
							<p><?php echo get_option(WP_SPEED_BUMP_TEXT); ?></p>
							<div class="alert_buttons">
								<a class="cancel" href="#"><?php echo get_option(WP_SPEED_BUMP_CANCEL_TITLE); ?></a>
								<a id="continue" class="gradient" href="#"><?php echo get_option(WP_SPEED_BUMP_OK_TITLE); ?></a>
							</div>
						</div>
					</div>
				<?php
			}
			
			public static function frontend_scripts() {
				// CSS Files
				wp_register_style('speed-bump-frontend', SPEED_BUMP_PATH . '/css/frontend.css');
				wp_enqueue_style('speed-bump-frontend');
				
				wp_enqueue_style( 'fancybox', SPEED_BUMP_PATH . '/js/fancybox/jquery.fancybox.css');
				
				
				// JS Files
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'speed_bump_js', SPEED_BUMP_PATH . '/js/frontend.js', array('jquery'), '', true );
				wp_enqueue_script( 'fancybox', SPEED_BUMP_PATH . '/js/fancybox/jquery.fancybox.pack.js', array('jquery'), '', true );
			}
			
			public static function speed_bump_admin_scripts() {
				// CSS Files
				wp_register_style('speed-bump-admin', SPEED_BUMP_PATH . '/css/admin.css');
				wp_enqueue_style('speed-bump-admin');
				
				// JS Files
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'speed_bump_admin_js', SPEED_BUMP_PATH . '/js/admin.js', array('jquery'), '', true );
			}
			
			public static function speed_bump_options_scripts() {
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'speed_bump_admin_js', SPEED_BUMP_PATH . '/js/settings.js', array('jquery'), '', true );
			}
			
			public static function speed_bump_admin_popup() {
				?>
				<div id="speed_bump_content" style="display:none;">
					<div class="sb_content">
						<div class="sb_content_row">
							<span>URL</span>
					    	<input type="text" id="speed_bump_url" value="http://">
						</div>
						<div class="sb_content_row">
					    	<span>Title</span>
							<input type="text" id="speed_bump_title" value="">
						</div>
						<div class="sb_content_row">
							<span>Open in new tab</span>
							<input type="checkbox" id="speed_bump_target" value="yes">
						</div>
					</div>
				    <div class="speed_bump_toolbar">
						<div class="speed_bump_toolbar_primary">
							<a href="#" id="add_speed_bump_button" class="button button-primary button-large">Add Speed Bump Link</a>
						</div>
					</div>
				</div>
				<?php
			}
		}
		
		$class['Speed_Bump'] = new Speed_Bump();
	}
?>