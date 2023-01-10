<?php
/**
* Plugin Name: Red8 Google Maps
* Plugin URI: null
* Description: Embeds maps using Google Maps API
* Version: 1.0.0
* Author: Red8 Interactive
* Author URI: http://red8interactive.com
* License: GPL2
*/

/*
	Copyright 2015 Red8 Interactive  (email : james@red8interactive.com)

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

//Prevents the file from being accesssed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'R8_Maps' ) ) {

	class R8_Maps {

		function __construct() {
			self::define_constants();
			self::load_hooks();
		}

		public static function define_constants() {

			if(!defined('R8_MAPS_PLUGIN_PATH')) {
				define('R8_MAPS_PLUGIN_PATH', plugins_url('', __FILE__) );
			}

			if(!defined('R8_CURRENT_PAGE')) {
				define('R8_CURRENT_PAGE', basename($_SERVER['PHP_SELF']));
			}

		}

		public static function load_hooks() {

			//Actions
			add_action( 'init', array( __CLASS__, 'register_R8_Maps_CPT' ) );
			add_action( 'manage_maps_posts_custom_column', array(__CLASS__, 'shortcode_table_row_content' ), 10, 2 );
			add_action( 'plugins_loaded', array( __CLASS__, 'add_maps_shortcode' ) );
			add_action( 'init', array( __CLASS__, 'add_map_fields' ) );

			//Filters
			add_filter( 'manage_maps_posts_columns', array(__CLASS__, 'add_shortcode_table_row'), 10 );
		}

		//Checks if the page is a new or existing post/page page
		public static function page_is_map_edit() {
	        $is_map_edit_page = in_array(R8_CURRENT_PAGE, array('post.php', 'page.php', 'page-new.php', 'post-new.php'));

	        if(isset($_GET['post'])) {
		        $postID = $_GET['post'];

		        if($is_map_edit_page && get_post_type($postID) === 'maps') {

		        	$add_geocoding_files = apply_filters("add_geocoding_files", $is_map_edit_page);

					return $add_geocoding_files;
				}
			}
	    }


		//Register Maps CPT
		public static function register_R8_Maps_CPT() {
			$labels = array(
				'name' 				=> ( 'Maps' ),
				'singular_name' 	=> ( 'Maps' ),
				'add_new' 			=> ( 'Add New Map' ),
				'add_new_item' 		=> ( 'Add New Map' ),
				'edit_item' 		=> ( 'Edit Map' ),
				'new_item' 			=> ( 'New Map' ),
				'view_item' 		=> ( 'View Map' ),
				'search_items' 		=> ( 'Search Maps' ),
				'not_found' 		=> ( 'No Maps found' ),
				'not_found_in_trash'=> ( 'No Maps found in Trash' ),
				'parent_item_colon' => ( 'Parent Map:' ),
				'menu_name' 		=> ( 'Maps' ),
			);
			$args = array(
				'labels' 			=> $labels,
				'hierarchical' 		=> false,
				'description' 		=> 'My Maps',
				'supports' 			=> array( 'title', 'editor', 'author', 'revisions', 'map_shortcode'),
				'taxonomies' 		=> array( 'press-type' ),
				'public' 			=> false,
				'show_ui' 			=> true,
				'show_in_menu' 		=> true,
				'menu_icon'			=> 'dashicons-location-alt',
				'menu_position' 	=> 3,
				'hierarchical' 		=> false,
				'show_in_nav_menus' => true,
				'publicly_queryable'=> true,
				'exclude_from_search'=> false,
				'has_archive' 		=> false,
				'query_var' 		=> false,
				'can_export' 		=> true,
				'capability_type' 	=> 'post'
			);
			register_post_type( 'maps', $args );
		}

		public static function add_shortcode_table_row($defaults) {


			if(!in_array('map_shortcode', $defaults)) {
				$defaults['map_shortcode'] = 'Map Shortcode';
				return $defaults;
			}

		}

		public static function shortcode_table_row_content($column_name, $post_ID) {

			if($column_name == 'map_shortcode') {

				echo '[r8gmaps id="' . $post_ID .'"]';

			}

		}

		public static function add_maps_shortcode() {

			function add_map_shortcode($atts, $content=null) {

				extract(shortcode_atts(array(
					'id' => 'null'
				), $atts));

				static $i = 0;
				$j = 0;
				$i++;
				$rows = get_field('markers', $id);
				$markerCount = count($rows);
				$markerArray = array();

				if(have_rows('markers', $id)) :
					while(have_rows('markers', $id)) : the_row();

						$latitude = get_sub_field('latitude', $id);
						$longitude = get_sub_field('longitude', $id);
						$markerTitle = get_sub_field('marker_title', $id);
						$markerContent = get_sub_field('marker_content', $id);


						$markerArray[$j]['latitude'] = $latitude;
						$markerArray[$j]['longitude'] = $longitude;
						$markerArray[$j]['marker_title'] = $markerTitle;
						$markerArray[$j]['marker_content'] = $markerContent;

						$j++;

					endwhile;
				endif;

				$markerJSON = json_encode($markerArray);

				//Dimension vars
				$map_width = get_field('map_width', $id) ? get_field('map_width', $id) : '500px';
				$map_height = get_field('map_height', $id) ? get_field('map_height', $id) : '500px';

				//Location vars
				$main_lat = get_field('latitude', $id);
				$main_long = get_field('longitude', $id);
				$map_zoom = get_field('map_zoom', $id);


				$return_message = '<script src="https://maps.googleapis.com/maps/api/js"></script>';
				$return_message .= "<div id=\"r8_map_$i\" style=\"width: " . $map_width . "; height: " . $map_height . ";\"></div>";
				$return_message .= '<script type="text/javascript">';
				$return_message .= "if(markers == null) { var markers = new Array(); } markers[$i] = $markerJSON, currentMapNum = $i;";
				$return_message .= "var map, infowindow, marker;
									function initMap() {
										map = new google.maps.Map(document.getElementById(\"r8_map_$i\"),
										{center: {lat:". $main_lat .", lng: ". $main_long ."},zoom: ". $map_zoom ."});
									";
				$return_message .= "var initialMarker = new google.maps.Marker({
									    position: {lat:". get_field('latitude', $id) .", lng: ". get_field('longitude', $id) ."},
									    map: map,
									});";
				$return_message .= "infowindow = new google.maps.InfoWindow({content: '...'});";
				$return_message .= "function setMarkers(map, marker, currentMapNum) {";
				$return_message .= "for(var k = 0; k < markers[currentMapNum].length; k++) {
										var address = '<div id=\"content\">'+'<div id=\"siteNotice\">'+'</div>'+'<h3>'+markers[currentMapNum][k].marker_title+'</h3>'+
													  '<div id=\"bodyContent\">'+'<p>'+markers[currentMapNum][k].marker_content+'</p>'+'</div>'+'</div>';
										marker = new google.maps.Marker({
											position: new google.maps.LatLng(markers[currentMapNum][k].latitude, markers[currentMapNum][k].longitude),
											map: map,
											labelContent: markers[currentMapNum][k].marker_content,
											labelAnchor: new google.maps.Point(60, 20),
											title: markers[currentMapNum][k].marker_title,
											address: address
										});
										google.maps.event.addListener(marker, 'click', function(){
											infowindow.setContent(this.address);
											infowindow.open(map,this);
										});
									}";
				$return_message .= "}";
				$return_message .= "setMarkers(map, marker, currentMapNum);";
				$return_message .= "}";
				$return_message .= 'initMap();';
				$return_message .= '</script>';

				return $return_message;

			}

			if( shortcode_exists( 'add_map_shortcode' ) ) {
				return;
			} else {
				add_shortcode( 'r8gmaps', 'add_map_shortcode' );
			}

		}

		public static function add_map_fields() {

			if(self::page_is_map_edit()) {
				wp_enqueue_script( 'maps_api', 'http://maps.google.com/maps/api/js?sensor=true', false, '3');
				wp_enqueue_script( 'r8gmaps_geocode', R8_MAPS_PLUGIN_PATH . '/js/geocode.js', array('jquery'), '', true );
			}

			if( function_exists('acf_add_local_field_group') ):

				acf_add_local_field_group(array (
					'key' => 'group_55e4792236001',
					'title' => 'Map Fields',
					'fields' => array (
						array (
							'key' => 'field_55e484dd7eaca',
							'label' => 'Map Dimensions',
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'placement' => 'top',
							'endpoint' => 0,
						),
						array (
							'key' => 'field_55e484ed7eacb',
							'label' => 'Map Width',
							'name' => 'map_width',
							'type' => 'text',
							'instructions' => 'Specify px or % as well. (Defaults to 500px if none set)',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55e485f07eacc',
							'label' => 'Map Height',
							'name' => 'map_height',
							'type' => 'text',
							'instructions' => 'Specify px or % as well. (Defaults to 500px if none set)',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55e4772dbeed1',
							'label' => 'Location',
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'placement' => 'top',
							'endpoint' => 0,
						),
						array (
							'key' => 'field_55e607ba3c9f2',
							'label' => 'Address',
							'name' => 'address',
							'type' => 'text',
							'instructions' => 'Enter an Address, then press "Geocode" to populate Lat, Long fields.',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => 90,
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '<input class="r8gmaps_geocode button button-primary" type="button" value="Geocode" style="line-height: 20px; height: 20px;" />',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55e4775fbeed2',
							'label' => 'Latitude',
							'name' => 'latitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'gmap_latitude',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55e47782beed3',
							'label' => 'Longitude',
							'name' => 'longitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => 'gmap_longitude',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
							'readonly' => 0,
							'disabled' => 0,
						),
						array (
							'key' => 'field_55e477abbeed4',
							'label' => 'Map Zoom',
							'name' => 'map_zoom',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
								5 => 5,
								6 => 6,
								7 => 7,
								8 => 8,
								9 => 9,
								10 => 10,
								11 => 11,
								12 => 12,
								13 => 13,
								14 => 14,
								15 => 15,
								16 => 16,
								17 => 17,
								18 => 18,
							),
							'default_value' => array (
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'disabled' => 0,
							'readonly' => 0,
						),
						array (
							'key' => 'field_55e48465beeda',
							'label' => 'Additional Markers',
							'name' => '',
							'type' => 'tab',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'placement' => 'top',
							'endpoint' => 0,
						),
						array (
							'key' => 'field_55e47865beed5',
							'label' => 'Markers',
							'name' => 'markers',
							'type' => 'repeater',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'min' => '',
							'max' => '',
							'layout' => 'row',
							'button_label' => 'Add Marker',
							'sub_fields' => array (
								array (
									'key' => 'field_55e60ff520478',
									'label' => 'Marker Address',
									'name' => 'marker_address',
									'type' => 'text',
									'instructions' => 'Enter an Address, then press "Geocode" to populate Lat, Long fields.',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array (
										'width' => 95,
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '<input class="r8gmaps_geocode button button-primary" type="button" value="Geocode" style="line-height: 20px; height: 20px;" />',
									'maxlength' => '',
									'readonly' => 0,
									'disabled' => 0,
								),
								array (
									'key' => 'field_55e47876beed6',
									'label' => 'Latitude',
									'name' => 'latitude',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array (
										'width' => '',
										'class' => 'gmap_latitude',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
									'readonly' => 0,
									'disabled' => 0,
								),
								array (
									'key' => 'field_55e478c1beed7',
									'label' => 'Longitude',
									'name' => 'longitude',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array (
										'width' => '',
										'class' => 'gmap_longitude',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
									'readonly' => 0,
									'disabled' => 0,
								),
								array (
									'key' => 'field_55e478c8beed8',
									'label' => 'Marker Title',
									'name' => 'marker_title',
									'type' => 'text',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array (
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'prepend' => '',
									'append' => '',
									'maxlength' => '',
									'readonly' => 0,
									'disabled' => 0,
								),
								array (
									'key' => 'field_55e478d1beed9',
									'label' => 'Marker Content',
									'name' => 'marker_content',
									'type' => 'textarea',
									'instructions' => '',
									'required' => 0,
									'conditional_logic' => 0,
									'wrapper' => array (
										'width' => '',
										'class' => '',
										'id' => '',
									),
									'default_value' => '',
									'placeholder' => '',
									'maxlength' => '',
									'rows' => '',
									'new_lines' => 'br',
									'readonly' => 0,
									'disabled' => 0,
								),
							),
						),
					),
					'location' => array (
						array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'maps',
							),
						),
					),
					'menu_order' => 0,
					'position' => 'normal',
					'style' => 'default',
					'label_placement' => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen' => array (
						0 => 'the_content',
						1 => 'excerpt',
						2 => 'featured_image',
						3 => 'categories',
					),
					'active' => 1,
					'description' => '',
				));
			endif;

		}

	} //End Class

	$R8_Maps = new R8_Maps();

} //End class_exists
