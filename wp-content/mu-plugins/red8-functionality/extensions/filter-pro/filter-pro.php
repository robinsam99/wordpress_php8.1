<?php
	
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
	
	if( !class_exists('Filter_Pro_Plugin') ) {
		
		class Filter_Pro_Plugin {
			
			function __construct() {
				self::define_constants();
				self::load_hooks();
			}
	
			/*************************
			* Defines plugin constants
			**************************/
			public static function define_constants() {
				define('FILTER_PRO_PLUGIN_PATH', plugins_url( ' ', __FILE__ ) ); 
				define('FILTER_PRO_PLUGIN_BASENAME', plugin_basename( __FILE__ ));
				define('FILTER_PRO_PLUGIN_RESULTS_FORMAT', 'filter_pro_plugin_results_format');
				define('FILTER_PRO_PLUGIN_NAME', 'filter-pro');
			}
			
			/*************************
			* Load hooks
			**************************/
			public static function load_hooks() {
				// Scripts
				add_action('wp_enqueue_scripts', array(__CLASS__, 'filter_pro_plugin_scripts')); 													// Enqueue our frontend scripts
				add_action('admin_enqueue_scripts', array(__CLASS__, 'filter_pro_plugin_widget_admin_scripts'));									// Enqueue our admin scripts
				
				// Admin settings Page
				add_action('admin_menu', array(__CLASS__, 'filter_pro_settings_menu')); 															// Create a settings page
				add_action('admin_post_update_filter_pro_settings', array(__CLASS__, 'update_filter_pro_settings'));								// Function for saving our settings
				
				// Shortcode
				add_shortcode('filter_pro', array(__CLASS__, 'register_filter_pro_shortcode')); 													// Register our shortcode
				
				// Widget
				add_action( 'widgets_init', array(__CLASS__, 'filter_pro_search_widget') ); 														// Register our widget
				
				// Meta box
				add_action('add_meta_boxes', array(__CLASS__, 'filter_pro_plugin_meta_box'));														// Add our metabox to post page
				
				// AJAX Hooks
				add_action('wp_ajax_load_filtered_results', array(__CLASS__, 'load_filtered_results')); 											// If the user is logged in
				add_action('wp_ajax_nopriv_load_filtered_results', array(__CLASS__, 'load_filtered_results')); 										// If the user in not logged in
				add_action( 'wp_ajax_filter_pro_shortcode_get_taxonomies', array(__CLASS__, 'filter_pro_shortcode_get_taxonomies') );				// Our AJAX hook for JS
				add_action( 'wp_ajax_filter_pro_shortcode_get_terms', array(__CLASS__, 'filter_pro_shortcode_get_terms') );							// Our AJAX hook for JS
				
				// Activation hook
				register_activation_hook( __FILE__, array(__CLASS__, 'filter_pro_plugin_activate') );
			}
			
			
			// Activation hook
			public static function filter_pro_plugin_activate() {
				
				// Install our default results format
				$filter_pro_results_format = get_option(FILTER_PRO_PLUGIN_RESULTS_FORMAT);
				if(!$filter_pro_results_format || $filter_pro_results_format == '') {
					$filter_pro_results_format = stripcslashes('<div class="filtered_post"><h3><a href="[filter_pro_permalink]">[filter_pro_title]</a></h3>[filter_pro_content]</div>');
					update_option(FILTER_PRO_PLUGIN_RESULTS_FORMAT, $filter_pro_results_format);
				}
			}



			/******************************
			*	
			* Admin Functions
			*
			*******************************/
			
			// Widget function
			public static function filter_pro_search_widget() {
				register_widget('Filter_Pro_Search_Widget');
			}
			
			// Meta box function
			public static function filter_pro_plugin_meta_box() {
				// Add the metabox to any post or page type
				$screens = array('post', 'page');
				
				// Adding a meta box for our shortcode generator
				foreach($screens as $screen) {
					add_meta_box(
						'filter_pro_plugin_meta_box',
						'Filter Pro Shortcode Generator',
						array(__CLASS__, 'filter_pro_plugin_add_meta_box'),
						$screen	
					);
				}
			}
			
			// Add Meta box
			public static function filter_pro_plugin_add_meta_box() {
				// Enqueue our scripts and echo out the content for our metabox
				self::filter_pro_plugin_admin_scripts();
				echo '<div class="filter_pro_wrap">';
				include_once 'templates/filter-pro-plugin-generate-shortcode.php';
				echo '</div>';
			}

			// Create admin settings menu
			public static function filter_pro_settings_menu() {
				add_submenu_page('red8-functionality-plugin', 'Filter Pro Plugin', 'Filter Pro Plugin', 'manage_options', FILTER_PRO_PLUGIN_NAME, array(__CLASS__, 'filter_pro_settings_page'));
			}
			
			// Admin Tabs
			public static function filter_pro_plugin_admin_tabs( $current = 'settings' ) {
				// Display our tabs with the correct one selected
				$tabs = array('settings' => 'Settings', 'generate' => 'Generate Shortcode');
				echo '<h2 style="font-size: 22px; margin: 10px 0 20px;">Filter Pro Plugin</h2>';
				echo '<h2 class="nav-tab-wrapper" style="margin-bottom: 30px;">';
				foreach($tabs as $tab => $name) {
					$class = ($tab == $current) ? ' nav-tab-active' : '';
					echo "<a class='nav-tab$class' href='?page=".FILTER_PRO_PLUGIN_NAME."&tab=$tab'>$name</a>";
				}
				echo '</h2>';
			}
			
			// Create content for settings page
			public static function filter_pro_settings_page() {
				self::filter_pro_plugin_admin_scripts();
				$filter_pro_results_format = get_option(FILTER_PRO_PLUGIN_RESULTS_FORMAT);
				
				?>
				<div class="wrap filter_pro_wrap filter_pro_settings">
					<?php 
				
						// Figure out which tab we need to display
						$pagenow = 'settings';
						if(isset($_GET['tab'])) {
							self::filter_pro_plugin_admin_tabs($_GET['tab']);
							$pagenow = $_GET['tab']; 
						} else {
							self::filter_pro_plugin_admin_tabs('settings'); 
							$pagenow = 'settings';
						}
				
						if($pagenow == 'settings') {
							// Display settings page
							include_once('templates/filter-pro-plugin-settings.php');
						} elseif($pagenow == 'generate') {
							// Display Generate Shortcode page
							include_once('templates/filter-pro-plugin-generate-shortcode.php');
						}
					?>
				</div>
				<?php
			}
			
			// Get taxonomies
			public static function filter_pro_shortcode_get_taxonomies() {
				$post_types = (isset($_POST['post_types'])) ? $_POST['post_types'] : null;
				$terms = (isset($_POST['terms'])) ? filter_var($_POST['terms'], FILTER_VALIDATE_BOOLEAN) : true;
		
				ob_start();
				
				if(!$terms) {
					echo '<option value="filter_pro_none">None</option>';
				}
				if($post_types) {		
					$taxonomies = get_object_taxonomies($post_types, 'objects');
					if($taxonomies) {
						foreach($taxonomies as $taxonomy) { 
							echo '<option value="'.$taxonomy->name.'">'.$taxonomy->labels->name.'</option>';
						}
					}
				}
				
				echo ob_get_clean();
				die();
			}
			
			// Get taxonomy terms
			public static function filter_pro_shortcode_get_terms() {
				$taxonomies = (isset($_POST['taxonomies'])) ? $_POST['taxonomies'] : null;
				
				ob_start();
				
				if($taxonomies) {
					$terms = get_terms($taxonomies, array());
					if(!empty($terms) && !is_wp_error($terms)) {
						foreach($terms as $term) {
							echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
						}
					}
				}
				
				echo ob_get_clean();
				die();
			}
			
			// Function to update admin settings
			public static function update_filter_pro_settings() {
				// Check to make sure our POST variable is there
				if($_POST[FILTER_PRO_PLUGIN_RESULTS_FORMAT]) {
					$filter_pro_results_format = stripcslashes(esc_textarea($_POST[FILTER_PRO_PLUGIN_RESULTS_FORMAT]));						// Get our content from the textarea
					update_option(FILTER_PRO_PLUGIN_RESULTS_FORMAT, $filter_pro_results_format);											// Update our option in the database
				}
				
				wp_redirect(get_admin_url().'admin.php?page='.FILTER_PRO_PLUGIN_NAME);										// Redirect back to the correct page
				exit();
			}
			
			
			
			
			
			/******************************
			*	
			* Scripts
			*
			*******************************/
			
			// Enqueue Admin Scripts
			public static function filter_pro_plugin_admin_scripts() {
				// Our CSS and JS for admin screens
				wp_register_style('filter-pro-admin', plugins_url('/css/admin.css', __FILE__));
				wp_enqueue_style('filter-pro-admin');
				
				wp_enqueue_script( 'jquery' , array(), '', true );
				wp_enqueue_script( 'filter-pro-plugin-admin-js', plugins_url('/js/admin.min.js', __FILE__), array('jquery'), '', true );
				wp_localize_script( 'filter-pro-plugin-admin-js', 'ajaxObject', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'plugin_url' => plugins_url('', __FILE__)));
			}
			
			// Enqueue Frontend Scripts
			public static function filter_pro_plugin_scripts() {
				// Our CSS and JS for frontend screens
				wp_register_style('filter-pro-plugin', plugins_url('/css/frontend.css', __FILE__));
				wp_enqueue_style('filter-pro-plugin');
				
				wp_enqueue_script( 'jquery' , array(), '', true );
				wp_enqueue_script( 'filter-pro-plugin-js', plugins_url('/js/frontend.min.js', __FILE__), array('jquery'), '', true );
				wp_localize_script( 'filter-pro-plugin-js', 'ajaxObject', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'plugin_url' => plugins_url('', __FILE__)));
			}
			
			public static function filter_pro_plugin_widget_admin_scripts($hook) {
				// Enqueue our admin JS for the widgets page
				if('widgets.php' != $hook) {
					return;
				}
				wp_enqueue_script( 'jquery' , array(), '', true );
				wp_enqueue_script( 'filter-pro-plugin-admin-js', plugins_url('/js/admin.min.js', __FILE__), array('jquery'), '', true );
				wp_localize_script( 'filter-pro-plugin-admin-js', 'ajaxObject', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'plugin_url' => plugins_url('', __FILE__)));
			}
			
			
			/******************************
			*	
			* Shortcode
			*
			*******************************/
			
			// Creates shortcode
			public static function register_filter_pro_shortcode($atts, $content = null) {
				extract (shortcode_atts(array(
					'filter_id' => null,
					'post_types' => 'post',
					'taxonomies' => 'category',
					'style' => 'radio',
					'excluded_terms' => null,
					'orderby' => 'title',
					'order' => 'ASC',
					'number' => 10,
					'load_more_text' => 'Load More Posts',
				), $atts));
				
				$shortcode_string = "<div class=\"filter_pro_page\"><input type=\"hidden\" id=\"filter_posts_post_type\" value=\"$post_types\"><input type=\"hidden\" id=\"filter_posts_posts_per_page\" value=\"$number\"><input type=\"hidden\" id=\"filter_posts_orderby\" value=\"$orderby\"><input type=\"hidden\" id=\"filter_posts_order\" value=\"$order\"><input type=\"hidden\" id=\"filter_posts_load_more_text\" value=\"$load_more_text\">";
				if($filter_id) {
					$shortcode_string .= "<input type=\"hidden\" id=\"filter_posts_filter_id\" value=\"$filter_id\">";
				}
				
				if($taxonomies) {
					$shortcode_string .= "<div class=\"filters\">";
					
					$taxonomy_array = explode(',', $taxonomies);  													// Put our comma sepearted taxonomies into an array for easy traversal
					foreach($taxonomy_array as $taxonomy) {
						$taxonomy = str_replace(' ', '', $taxonomy);   												// Get rid of any whitespace
						$tax = array($taxonomy);
						$args = array();
						if($excluded_terms) {
							$excluded_terms_array = array();
							$term_array = explode(',', $excluded_terms);											// Get any of our excluded terms and place them in an array
							foreach($term_array as $excluded_term) {
								$excluded_term = str_replace(' ', '', $excluded_term);
								if(is_int($excluded_term)) {														// If the excluded term is an integer, we can assume its the ID for that term
									$excluded_terms_array[] = $excluded_term;
								} else {																			// Otherwise, we can assume its the slug
									$term = get_term_by('slug', $excluded_term, $taxonomy);							// Get the ID from the slug
									if($term) {
										$excluded_terms_array[] = $term->term_id;
									}
								}
							}
							$args['exclude'] = $excluded_terms_array;    											// Included our excluded terms in the arguements
						}
						$terms = get_terms($tax, $args);															// Get our taxonomy terms
						if($terms) :
							if($style == 'select') {																// Display it in dropdown form
								$shortcode_string .= "<h3>".strtoupper($taxonomy)."</h3><select class=\"select_filter\" name=\"$taxonomy\"><option value=\"none\">All</option>";
								foreach($terms as $term) :
									$shortcode_string .= "<option value=\"".$term->slug."\">".$term->name."</option>";
								endforeach;
								$shortcode_string .= "</select>";
							} else if($style == 'checkbox') {														// Display checkboxes
								$shortcode_string .= "<h3>".strtoupper($taxonomy)."</h3><ul class=\"checkbox_filter\">";
								foreach($terms as $term) :
									$shortcode_string .= "<li><input type=\"checkbox\" name=\"$taxonomy\" value=\"".$term->slug."\"><label>".$term->name."</label></li>";
								endforeach;
								$shortcode_string .= "</ul>";
							} else {																				// Display radio buttons
								$shortcode_string .= "<h3>".strtoupper($taxonomy)."</h3><ul class=\"radio_filter\"><li><input type=\"radio\" name=\"$taxonomy\" value=\"none\"><label>All</label></li>";
								foreach($terms as $term) :
									$shortcode_string .= "<li><input type=\"radio\" name=\"$taxonomy\" value=\"".$term->slug."\"><label>".$term->name."</label></li>";
								endforeach;
								$shortcode_string .= "</ul>";
							}
						endif;
					}
					
					$shortcode_string .= "</div>"; // closing .filters
				}
				
				$shortcode_string .= "<div id=\"filtered_posts\"></div></div>";										// Close our shortcode container
				return $shortcode_string;																			// Return our shortcode's HTML
			}
			
			
			
			
			
			/******************************
			*	
			* AJAX functions
			*
			*******************************/
			
			// AJAX function to load results
			public static function load_filtered_results() {
				// Get all post variables
				$paged = (isset($_POST['paged'])) ? intval(esc_attr($_POST['paged'])) : 1;											// The page for our query to get the correct posts
				$filters = (isset($_POST['filters'])) ? $_POST['filters'] : null;													// Get the filters from our shortcode
				$post_type = (isset($_POST['post_type'])) ? esc_attr($_POST['post_type']) : 'post';									// Get the post types from our shortcode
				$number = (isset($_POST['ppp'])) ? intval(esc_attr($_POST['ppp'])) : 10;											// Get the number of posts to show from our shortcode
				$orderby = (isset($_POST['orderby'])) ? esc_attr($_POST['orderby']) : 'title';										// Get the orderby from our shortcode
				$order = (isset($_POST['order'])) ? esc_attr($_POST['order']) : 'ASC';												// Get the order from our shortcode
				$excluded_posts = (isset($_POST['excluded_posts'])) ? esc_attr($_POST['excluded_posts']) : null;					// Get any excluded posts if we're using orderby=RAND
				$load_more_text = (isset($_POST['load_more_text'])) ? esc_attr($_POST['load_more_text']) : 'Load More Posts';		// Get the load more text for our button
				$filter_id = (isset($_POST['filter_id'])) ? esc_attr($_POST['filter_id']) : null;									// Get the filter id if its set
				
				ob_start();
				
				// Get our posts type in an array
				$post_types = array();
				$post_type_array = explode(',', $post_type);
				foreach($post_type_array as $pt) {
					$pt = str_replace(' ', '', $pt);
					$post_types[] = $pt;
				}
				
				
				// Construct our arguements array
				$args = array (
					'post_type' => $post_types,
					'post_status' => 'publish',
					'posts_per_page' => $number,
					'orderby' => $orderby,
					'order' => $order,
				);
				
				if($orderby != 'rand') {
					$args['paged'] = $paged;
				}
				
				// Add any filters we have to our arguement array
				if($filters) {
					foreach($filters as $key => $value) {
						$args['tax_query'][] = array(
							'taxonomy' => $key,
							'field' => 'slug',
							'terms' => $value	
						);
					}
				}
				
				
				// Add our excluded posts to the arguement array
				if($excluded_posts) {
					$posts_to_exclude = array();
					foreach($excluded_posts as $excluded_post) {
						$post_id = url_to_postid($excluded_post);
						$posts_to_exclude[] = $post_id;
					}
					$args['post__not_in'] = $posts_to_exclude;
				}
				
				// Get our default display format from the database
				$filter_pro_results_format = html_entity_decode(esc_attr(get_option(FILTER_PRO_PLUGIN_RESULTS_FORMAT)), ENT_QUOTES, 'cp1252');
				
				// Get our posts that we need to display
				$filtered_posts = new WP_Query($args);
				
				if ( $filtered_posts->have_posts() ) {
				
					if($paged == 1) {
						if($filtered_posts->found_posts == 1) {
							$results_count = "<p class=\"results_number\">".$filtered_posts->found_posts." Result</p>";
							if($filter_id) {
								echo apply_filters('filter_pro_result_count_'.$filter_id, $results_count);
							} else {
								echo apply_filters('filter_pro_result_count', $results_count);
							}
						} else {
							$results_count = "<p class=\"results_number\">".$filtered_posts->found_posts." Results</p>";
							if($filter_id) {
								echo apply_filters('filter_pro_result_count_'.$filter_id, $results_count);
							} else {
								echo apply_filters('filter_pro_result_count', $results_count);
							}
						}
					}
			
					while( $filtered_posts->have_posts() ) : $filtered_posts->the_post();
				
						if($filter_pro_results_format) {
							// Replace our predefined options with their corresponding information
							$filter_result = $filter_pro_results_format;
							$filter_result = str_replace('[filter_pro_id]', get_the_ID(), $filter_result);
							$filter_result = str_replace('[filter_pro_thumbnail]', get_the_post_thumbnail(get_the_ID()), $filter_result);
							$filter_result = str_replace('[filter_pro_permalink]', get_the_permalink(), $filter_result);
							$filter_result = str_replace('[filter_pro_title]', get_the_title(), $filter_result);
							$filter_result = str_replace('[filter_pro_content]', get_the_content(), $filter_result);
							$filter_result = str_replace('[filter_pro_content_trimmed]', wp_trim_words(get_the_content(), 55, '...'), $filter_result);
							$filter_result = str_replace('[filter_pro_excerpt]', get_the_excerpt(), $filter_result);
							$filter_result = str_replace('[filter_pro_author]', get_the_author(), $filter_result);
							$filter_result = str_replace('[filter_pro_author_link]', get_the_author_link(), $filter_result);
						} else {
							$filter_result = "<div class=\"filtered_post\"><h3><a href=\"".get_the_permalink()."\">".get_the_title()."</a></h3>".wp_trim_words(get_the_content(), 55, '...')."</div>";
						}
						
						// Give user the option to use their own format by using a filter
						if($filter_id) {
							echo apply_filters('filter_pro_html_'.$filter_id, $filter_result);
						} else {
							echo apply_filters('filter_pro_html', $filter_result);
						}
				
					endwhile;
				
					// If there are more posts, the add the load more link
					if($filtered_posts->found_posts > ($number*$paged) && $number != -1) {
						$load_more_button = "<a class=\"load_more_results\" href=\"#\">$load_more_text</a>";
						if($filter_id) {
							echo apply_filters('filter_pro_load_more_'.$filter_id, $load_more_button);
						} else {
							echo apply_filters('filter_pro_load_more', $load_more_button);
						}
					}
				
				} else {
					
					// We didn't get any results, tell the user that
					if($paged == 1) {
						$load_more_button = "<p class=\"results_number\">No Results</p>";
						if($filter_id) {
							echo apply_filters('filter_pro_load_more_'.$filter_id, $load_more_button);
						} else {
							echo apply_filters('filter_pro_load_more', $load_more_button);
						}
					}
				
				} 
				wp_reset_postdata();
				
				// Display our results
				echo ob_get_clean();
				die();
			}
		}
			
		$class['Filter_Pro_Plugin'] = new Filter_Pro_Plugin();
	}
	
	// Require our widget for use
	require_once 'includes/filter-pro-search-widget.php';
?>