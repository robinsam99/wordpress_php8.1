<?php
/**
 * boiler functions and definitions
 *
 * @package boiler
 */

if ( ! function_exists( 'boiler_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function boiler_setup() {

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'boiler' ),
		'footer' => __( 'Footer Menu', 'boiler' )
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // boiler_setup
add_action( 'after_setup_theme', 'boiler_setup' );

// add parent class to menu items
add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
function add_menu_parent_class( $items ) {

	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}

	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'parent-item';
		}
	}

	return $items;
}

// Options Pages
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'     => 'Social Media',
        'menu_title'    => 'Social Media'
    ));

}
/* remove some of the header bloat */

// EditURI link
remove_action( 'wp_head', 'rsd_link' );
// windows live writer
remove_action( 'wp_head', 'wlwmanifest_link' );
// index link
remove_action( 'wp_head', 'index_rel_link' );
// previous link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
// start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
// links for adjacent posts
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
// WP version
remove_action( 'wp_head', 'wp_generator' );

// remove pesky injected css for recent comments widget
add_filter( 'wp_head', 'boiler_remove_wp_widget_recent_comments_style', 1 );
// clean up comment styles in the head
add_action('wp_head', 'boiler_remove_recent_comments_style', 1);
// clean up gallery output in wp
add_filter('gallery_style', 'boiler_gallery_style');

// Thumbnail image sizes
// add_image_size( 'thumb-400', 400, 400, true );
add_image_size( 'product-card', 220, 0, false );
add_image_size( 'product-card-list', 1020, 0, false );
add_image_size( 'hero', 1100, 400, false );
add_image_size( 'stylemaker', 185, 230, false );

// remove injected CSS for recent comments widget
function boiler_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function boiler_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function boiler_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/**
 * Register widgetized area and update sidebar with default widgets
 */
function boiler_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'boiler' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'boiler_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function boiler_scripts_styles() {
	// style.css just initializes the theme. This is compiled from /sass
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/css/main.css' );

	wp_enqueue_script( 'jquery' , array(), '', true );

	//Pinterest
	wp_enqueue_script( 'pintrest', '//assets.pinterest.com/js/pinit.js', array(), '', true );

	//Swiper iDangerous
	wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/css/swiper.min.css' );
	wp_enqueue_script( 'swiper-js', get_template_directory_uri() . '/js/vendor/swiper.min.js', array('jquery'), '', true );

	//appendAround
	wp_enqueue_script( 'appendAround-js', get_template_directory_uri() . '/js/vendor/appendAround.js', array('jquery'), '', true );

	//Media Boxes
	if(is_page('Home')) {
		wp_enqueue_script( 'mediaboxes-isotope', get_template_directory_uri() . '/js/vendor/media-boxes/jquery.isotope.min.js', array('jquery'), '', true );
		wp_enqueue_script( 'mediaboxes-imagesLoaded', get_template_directory_uri() . '/js/vendor/media-boxes/jquery.imagesLoaded.min.js', array('jquery'), '', true );
		wp_enqueue_script( 'mediaboxes-transit', get_template_directory_uri() . '/js/vendor/media-boxes/jquery.transit.min.js', array('jquery'), '', true );
		wp_enqueue_script( 'mediaboxes-easing', get_template_directory_uri() . '/js/vendor/media-boxes/jquery.easing.js', array('jquery'), '', true );
		wp_enqueue_script( 'mediaboxes-waypoints', get_template_directory_uri() . '/js/vendor/media-boxes/waypoints.min.js', array('jquery'), '', true );
		wp_enqueue_script( 'mediaboxes-modernizr', get_template_directory_uri() . '/js/vendor/media-boxes/modernizr.custom.min.js', array('jquery'), '', true );
		wp_enqueue_script( 'mediaboxes-magnific-popup', get_template_directory_uri() . '/js/vendor/media-boxes/jquery.magnific-popup.min.js', array('jquery'), '', true );
		wp_enqueue_script( 'mediaboxes', get_template_directory_uri() . '/js/vendor/media-boxes/jquery.mediaBoxes.js', array('jquery'), 'v3', true );
		wp_enqueue_script( 'filter-js', get_template_directory_uri() . '/js/filter.js', array('jquery', ), '', true );
	}

	//Fancybox
	wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/css/jquery.fancybox.css' );
	wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/js/vendor/jquery.fancybox.js', array('jquery'), '', true );


	//Fonts
	wp_enqueue_script( 'fonts', '//fast.fonts.net/jsapi/48fcd98f-addb-420c-95c7-9c2188a4fbaf.js', array(), '', false );

	//wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr-2.6.2.min.js', '2.6.2', true );

	//wp_enqueue_script( 'boiler-plugins', get_template_directory_uri() . '/js/plugins.js', array(), '20120206', true );

	//wp_enqueue_script( 'boiler-main', get_template_directory_uri() . '/js/main.js', array(), '20120205', true );

	// Return concatenated version of JS. If you add a new JS file add it to the concatenation queue in the gruntfile.
	// current files: js/vendor.mordernizr-2.6.2.min.js, js/plugins.js, js/main.js
	wp_enqueue_script( 'boiler-concat', get_template_directory_uri() . '/js/built.min.js', array('jquery'), '', true );

	wp_localize_script( 'boiler-concat', 'ajaxObject', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'themeurl' => get_template_directory_uri() ));

}
add_action( 'wp_enqueue_scripts', 'boiler_scripts_styles' );


/**
 * Ajax functions for this theme.
 */
 require get_template_directory() . '/inc/ajax-functions.php';

/**
 *  Custom post types for this theme.
 */
 require get_template_directory() . '/inc/post_types.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

// Auto wrap embeds with video container to make video responsive
function wrap_embed_with_div($html, $url, $attr) {
     return '<div class="video_container">' . $html . '</div>';
}

add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);

// Function for adding ACF fields into Yoast SEO check
if ( is_admin() ) { // check to make sure we aren't on the front end
	add_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast');

	function add_custom_to_yoast( $content ) {
		global $post;
		$pid = $post->ID;

		$custom = get_post_custom($pid);
		unset($custom['_yoast_wpseo_focuskw']); // Don't count the keyword in the Yoast field!

		foreach( $custom as $key => $value ) {
			if( substr( $key, 0, 1 ) != '_' && substr( $value[0], -1) != '}' && !is_array($value[0]) && !empty($value[0])) {
			  $custom_content .= $value[0] . ' ';
			}

		}

		$content = $content . ' ' . $custom_content;
		return $content;

		remove_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast'); // don't let WP execute this twice
	}
}

// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );

// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {
	// Define the style_formats array
	$style_formats = array(
		// Each array child is a format with it's own settings
		array(
			'title' => 'Avenir Demi',
			'inline' => 'span',
			'classes' => 'rv_demi',
			'wrapper' => true
		)
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;

}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

//Remove p tags from around images in wysiwyg or 'the_content' filter
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');

function rv_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'rv_login_logo_url' );

// Custom Login Screen
function rv_loginlogo() {
	$image_url = get_template_directory_uri().'/images/logo.png';

    echo '<style type="text/css">
        .login h1 a {
        background-image: url(' . $image_url . ') !important;
        background-size: 100% !important;
        width: 100% !important;
        height: 144px !important;
        }
        </style>';
}
add_action('login_head', 'rv_loginlogo');

add_filter('gform_loaded', 'verify_minimum_age');
function verify_minimum_age($validation_result){

    // retrieve the $form
    $form = $validation_result['form'];

	$form['fields']['5']['label'] = 'I accept the terms of the <a href="http://royalvelvet.com/privacy-policy" target="_blank">Privacy Policy</a> and <a href="/terms-and-conditions" target="_blank">Terms of Use</a>.';

	$validation_result['form'] = $form;
	return $validation_result;
}

/*Custom Date field validation for Contact Form 7*/
add_filter( 'wpcf7_validate_date*', 'custom_date_validation_filter', 20, 2 );

function custom_date_validation_filter( $result, $tag )
{
    $dob = $_POST['date-156'];
    $age = 13;
    
    if(is_string($dob)) {
        $birthday = strtotime($dob);
    }

    if ( 'date-156' == $tag->name ) {
        if(time() - $birthday < $age * 31536000)  {
            $result->invalidate($tag, "Age must be atleast 13 years old to join !" );
        }
    }
    return $result;
}

