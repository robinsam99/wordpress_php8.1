<?php
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
	
	if( !class_exists('Filter_Pro_Search_Widget') ) {		
		// Filter Pro Search Widget
		class Filter_Pro_Search_Widget extends WP_Widget {
			
			function __construct() {
				parent::__construct(
					'filter_pro_plugin_widget', // Base ID
					'Filter Pro Search', // Name
					array('description' => 'Adds a search bar that you can filter by post types and taxonomy') // Args
				);
			}
			
			public function widget($args, $instance) {
				extract($args);
				 
				echo $before_widget;
				 
				echo '<div class="filter_pro_search_widget">';
				if($instance['title']) {
					echo '<h3 class="widget-title">'.$instance['title'].'</h3>';
				}
				echo '<form method="get" id="searchform" class="searchform" action="'.esc_url( home_url( '/' ) ).'" role="search">';
				
				if($instance['taxonomies'] != 'filter_pro_none') {
					$tax = array($instance['taxonomies']);
					$args = array();
					$terms = get_terms($tax, $args);
					if($terms) {
						echo '<h4>'.ucfirst(strtolower($instance['taxonomies'])).'</h4>';
						echo '<select name="term">';
						echo '<option value="">All</option>';
						foreach($terms as $term) {
							echo "<option value=\"".$term->slug."\">".$term->name."</option>";
						}
						echo '</select>';
					}
				}
				echo '<input type="search" class="field" name="s" value="'.esc_attr( get_search_query() ).'" id="s" placeholder="'.esc_attr_x( 'Search &hellip;', 'placeholder', 'boiler' ).'">';
				echo '<input type="hidden" name="post_type" value="'.$instance['post_type'].'">';
				if($instance['taxonomies'] != 'filter_pro_none') {
					echo '<input type="hidden" name="taxonomy" value="'.$instance['taxonomies'].'">';
				}
				echo '</form>';
				echo '</div>';
				 
				echo $after_widget;
			}
			
			public function update( $new_instance, $old_instance ) {
			    $instance = $old_instance;
			 
			    //Strip tags from title and name to remove HTML
			    $instance['title'] = strip_tags( $new_instance['title'] );
			    $instance['post_type'] = strip_tags( $new_instance['post_type'] );
			    $instance['taxonomies'] = strip_tags( $new_instance['taxonomies'] );
			 
			    return $instance;
			}
			
			public function form($instance) {
				$defaults = array( 'title' => 'Filter Pro Search', 'post_type' => 'post', 'taxonomies' => 'category');
				$instance = wp_parse_args( (array) $instance, $defaults ); 
				
				?>
				<div class="filter_pro_widget_wrapper">
					<p>
					    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
					    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
					</p>
					
					<p>
					    <label for="<?php echo $this->get_field_id( 'post_type' ); ?>">Post Type</label>
					    <select id="filter_pro_widget_post_types" name="<?php echo $this->get_field_name( 'post_type' ); ?>" style="display: block; width: 100%;">
						    <?php $post_types = get_post_types(array('public' => true), 'objects'); ?>
						    <?php echo $instance['post_type']; ?>
							<?php foreach($post_types as $post_type) { ?>
								<option value="<?php echo $post_type->name; ?>" <?php if($instance['post_type'] == $post_type->name || ($post_type->name == 'post' && !$instance['post_type'])) { echo 'selected="selected"'; } ?>><?php echo $post_type->labels->name; ?></option>
							<?php } ?>
					    </select>
					</p>
					 
					<p>
					    <label for="<?php echo $this->get_field_id( 'taxonomies' ); ?>">Taxonomies</label>
					    <select id="filter_pro_widget_taxonomies" name="<?php echo $this->get_field_name( 'taxonomies' ); ?>" style="display: block; width: 100%;">
						    <option value="filter_pro_none">None</option>
						    <?php 
							    $post_types = array('post');
							    if($instance['post_type']) {
								    $post_types = $instance['post_type'];
							    }
							    $taxonomies = get_object_taxonomies($post_types, 'objects'); 
							?>
							<?php foreach($taxonomies as $taxonomy) { ?>
								<option value="<?php echo $taxonomy->name; ?>" <?php if($instance['taxonomies'] == $taxonomy->name) { echo 'selected="selected"'; } ?>><?php echo $taxonomy->labels->name; ?></option>
							<?php } ?>
					    </select>
					</p>
				</div>
				<?php
			}
		}
		
		$class['Filter_Pro_Search_Widget'] = new Filter_Pro_Search_Widget();
	}
?>