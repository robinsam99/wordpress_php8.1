<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>

<?php 
	if(isset($_GET['id'])) {
		$postID = $_GET['id'];
		require (plugin_dir_path(__FILE__ ) . 'edit-tax-page.php');
	} else {
?>


<div class="ez_cpt_creator wrap">
	<h2><?php esc_attr_e( 'Add A Taxonomy', 'wp_admin_style' ); ?></h2>
	
	<div class="name_error form-invalid"><?php esc_attr_e( 'You must enter a Name', 'wp_admin_style' ); ?></div>
	<div class="checkbox_error form-invalid"><?php esc_attr_e( 'You must select a Post Type', 'wp_admin_style' ); ?></div>
	
	<div id="col-container">
		<form method="post" name="new_tax_form" id="new_tax_form" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
			<div id="col-right">
				<div class="col-wrap">
					<h3><?php esc_attr_e( 'Options', 'wp_admin_style' ); ?></h3>
					<table>
						<tbody>
							<tr>
								<td><label for="hierarchical" class="single_line_label">Hierarchical:</label></td>
								<td>
									<select name="hierarchical">
										<option value="1" selected="selected">True</option>	
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="public" class="single_line_label">Public:</label></td>
								<td>
									<select name="public">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="show_ui" class="single_line_label">Show UI:</label></td>
								<td>
									<select name="show_ui">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="show_in_nav_menus" class="single_line_label">Show In Nav Menus:</label></td>
								<td>
									<select name="show_in_nav_menus">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="show_tagcloud" class="single_line_label">Show TagCloud:</label></td>
								<td>
									<select name="show_tagcloud">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="quick_edit" class="single_line_label">Show In Quick Edit:</label></td>
								<td>
									<select name="quick_edit">
										<option value="1">True</option>
										<option value="0" selected="selected">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="meta_box" class="single_line_label">Meta Box Call Back:</label></td>
								<td><input name="meta_box" type="text" value=""/></td>
							</tr>	
							<tr>
								<td><label for="query_var" class="single_line_label">Query Var:</label></td>
								<td>
									<select name="query_var">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="admin_column" class="single_line_label">Show Admin Column:</label></td>
								<td>
									<select name="admin_column">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="count_callback" class="single_line_label">Update Count Callback:</label></td>
								<td><input name="count_callback" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="rewrite" class="single_line_label">Rewrite:</label>
								<td><input name="rewrite" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="capabilities" class="single_line_label">Capabilities:</label></td>
								<td><input name="capabilities" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="sort" class="single_line_label">Sort:</label>
								<td>
									<select name="sort">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="builtin" class="single_line_label">Builtin:</label></td>
								<td>
									<select name="builtin">
										<option value="1">True</option>
										<option value="0" selected="selected">False</option>
									</select>
								</td>
							</tr>
						</tbody>
					</table><!-- end 'inside' -->
				</div><!-- end 'col-wrap' -->
			</div><!-- end 'col-right' -->
			<div id="col-left">
				<div class="col-wrap">
					<h3><?php esc_attr_e( 'Labels', 'wp_admin_style' ); ?></h3>
					<table>
						<tbody>
							<tr>
								<?php $cpt_objects = unserialize(get_option(CPT_CREATOR_OPTION_GROUP)); ?>
								
								<?php 
									$builtin_cpts = get_post_types( array(
										), 'object'
									);
								?>
		
								<td><label for="post_types[]" class="single_line_label">Attach Post Type(s):<sup>*</sup></label></td>
								<td><div class="input_wrap taxonomy">	
									<?php if ($cpt_objects || $builtin_cpts) : ?>
										<ul>
										<?php if($cpt_objects) : ?>
											<?php foreach($cpt_objects as $cpt_object) : ?>
												<li><input name="post_types[]" type="checkbox" value="<?php echo str_replace(" ", "-", strtolower($cpt_object->post_type_name)); ?>" /><?php echo $cpt_object->post_type_name; ?></li>
											<?php endforeach; ?>
										<?php endif; ?>
										<?php if($builtin_cpts) : ?>
											<?php foreach($builtin_cpts as $builtin) : ?>
												<li><input name="post_types[]" type="checkbox" value="<?php esc_attr_e($builtin->name, 'wp_admin_style'); ?>" /><?php esc_attr_e( $builtin->label, 'wp_admin_style' ); ?></li>
											<?php endforeach; ?>
										<?php endif; ?>
										</ul>
									<?php else : ?>
										<p>There are no Post Types</p>
									<?php endif; ?>
								</div></td>
							</tr>
							<tr>
								<td><label for="tax_name" class="single_line_label">Taxonomy Name:<sup>*</sup></label></td>
								<td><input id="tax_name" name="tax_name" type="text" class="required_name" value=""  /></td>
							</tr>
							<tr>	
								<td><label for="singular_name" class="single_line_label">Singular name:</label></td>
								<td><input id="singular_name" name="singular_name" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="menu_name" class="single_line_label">Menu Name:</label></td>
								<td><input id="menu_name" name="menu_name" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="all_items" class="single_line_label">All Items:</label></td>
								<td><input id="all_items" name="all_items" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="edit_item" class="single_line_label">Edit Item:</label></td>
								<td><input id="edit_item" name="edit_item" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="view_item" class="single_line_label">View Item:</label></td>
								<td><input id="view_item" name="view_item" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="update_item" class="single_line_label">Update Item:</label></td>
								<td><input id="update_item" name="update_item" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="add_new_item" class="single_line_label">Add New Item:</label></td>
								<td><input id="add_new_item" name="add_new_item" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="new_item_name" class="single_line_label">New Item Name:</label></td>
								<td><input id="new_item_name" name="new_item_name" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="parent_item" class="single_line_label">Parent Item:</label></td>
								<td><input id="parent_item" name="parent_item" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="parent_item_colon" class="single_line_label">Parent Item Colon:</label></td>
								<td><input id="parent_item_colon" name="parent_item_colon" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="search_items" class="single_line_label">Search Items:</label></td>
								<td><input id="search_items" name="search_items" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="popular_items" class="single_line_label">Popular Items:</label></td>
								<td><input id="popular_items" name="popular_items" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="separate_items_with_commas" class="single_line_label">Separate Items With Commas:</label></td>
								<td><input id="separate_items_with_commas" name="separate_items_with_commas" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="add_or_remove_items" class="single_line_label">Add or Remove Items:</label></td>
								<td><input id="add_or_remove_items" name="add_or_remove_items" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="choose_from_most_used" class="single_line_label">Choose From Most Used:</label></td>
								<td><input id="choose_from_most_used" name="choose_from_most_used" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="not_found" class="single_line_label">Not Found:</label></td>
								<td><input id="not_found" name="not_found" type="text" /></td>
							</tr>
						</tbody>
					</table><!-- end 'inside' -->
				</div><!-- end 'col-wrap' -->
			</div><!-- end 'col-left' -->
			<div class="button_wrap">
				<?php submit_button('Add New Taxonomy', 'primary', 'add_new_tax'); ?>
				<input type="hidden" name="action" value="add_new_tax"/>
			</div>
		</form>
	</div><!-- end 'col-container' -->					
</div><!-- end 'wrap' -->

<?php } ?>
