<?php

//Products post type
function register_cpt_products() {
	$labels = array(
		'name' 				=> ( 'Products' ),
		'singular_name' 	=> ( 'Products' ),
		'add_new' 			=> ( 'Add New Product' ),
		'add_new_item' 		=> ( 'Add New Product' ),
		'edit_item' 		=> ( 'Edit Product' ),
		'new_item' 			=> ( 'New Product' ),
		'view_item' 		=> ( 'View Product' ),
		'search_items' 		=> ( 'Search Product' ),
		'not_found' 		=> ( 'No Product found' ),
		'not_found_in_trash'=> ( 'No Product found in Trash' ),
		'parent_item_colon' => ( 'Parent Product:' ),
		'menu_name' 		=> ( 'Products' ),
	);
	$args = array(
		'labels' 			=> $labels,
		'hierarchical' 		=> true,
		'description' 		=> 'My Product',
		'supports' 			=> array( 'title', 'editor', 'thumbnail' , 'excerpt', 'author', 'revisions'),
		'taxonomies' 		=> array( 'color', 'pattern', 'room', 'set' ),
		'public' 			=> true,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'menu_icon'			=> 'dashicons-products',
		'menu_position' 	=> 6,
		'hierarchical' 		=> true,
		'show_in_nav_menus' => true,
		'publicly_queryable'=> true,
		'exclude_from_search'=> false,
		'rewrite'			=> array('with_front' => false),
		'has_archive' 		=> true,
		'query_var' 		=> true,
		'can_export' 		=> true,
		'capability_type' 	=> 'post'
	);
	register_post_type( 'products', $args );
}
add_action( 'init', 'register_cpt_products' );

//Products taxonomies

add_action( 'init', 'create_color_tax' );
function create_color_tax() {
	register_taxonomy(
		'color',
		'products',
		array(
			'label' => __( 'Color' ),
			'rewrite' => array( 'slug' => 'color' ),
			'hierarchical' => true
		)
	);
}

add_action( 'init', 'create_pattern_tax' );
function create_pattern_tax() {
	register_taxonomy(
		'pattern',
		'products',
		array(
			'label' => __( 'Pattern' ),
			'rewrite' => array( 'slug' => 'pattern' ),
			'hierarchical' => true
		)
	);
}

add_action( 'init', 'create_room_tax' );
function create_room_tax() {
	register_taxonomy(
		'room',
		'products',
		array(
			'label' => __( 'Room' ),
			'rewrite' => array( 'slug' => 'room' ),
			'hierarchical' => true
		)
	);
}

add_action( 'init', 'create_set_tax' );
function create_set_tax() {
	register_taxonomy(
		'set',
		'products',
		array(
			'label' => __( 'Set' ),
			'rewrite' => array( 'slug' => 'set' ),
			'hierarchical' => true
		)
	);
}
