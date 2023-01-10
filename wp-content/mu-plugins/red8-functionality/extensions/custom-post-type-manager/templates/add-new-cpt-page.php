<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>

<?php 
	if(isset($_GET['id'])) {
		$postID = $_GET['id'];
		require (plugin_dir_path(__FILE__ ) . 'edit-cpt-page.php');
	} else {
?>

	
<div class="ez_cpt_creator wrap">
	<h2><?php esc_attr_e( 'Add A Custom Post Type', 'wp_admin_style' ); ?></h2>
	
	<div class="name_error form-invalid"><?php esc_attr_e( 'You must enter a Name', 'wp_admin_style' ); ?></div>
	
	<div id="col-container">
		<form method="post" name="new_cpt_form" id="new_cpt_form" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
			<div id="col-right">
				<div class="col-wrap">
					<h3><?php esc_attr_e( 'Options', 'wp_admin_style' ); ?></h3><br>
					<table>
						<tbody>
							<tr>
								<td><label class="icon_label" for="select_icon">Admin Menu Icon:</label></td>
								<td>
									<div class="input_wrap menu_icon">
										<input class="icon_text" type="text" size="36" name="select_icon" value="" />
										<input name="select_icon" class="button select_icon_button" type="button" value="Select Icon" /> or 
										<input name="upload_icon" class="button upload_icon_button" type="button" value="Upload Icon" /><br>
										<span>(Note: If uploading icon, size must not be larger than 16px x 16px)</span>
									</div>
								</td>
							</tr>	
							<tr>
								<div class="dashicon_picker_container">
									<ul class="dashicon_picker_list" /></ul>
								</div>
							</tr>
							<tr>
								<td><label for="description" class="single_line_label">Description:</label></td>
								<td><textarea name="description" value=""></textarea></td>
							</tr>
							<tr>
								<td><label for="supports[]" class="single_line_label">Supports:</label></td>
								<td>
									<div class="input_wrap">
										<ul>
											<li><input name="supports[]" type="checkbox" value="title" />title</li>
											<li><input name="supports[]" type="checkbox" value="editor" />editor</li>
											<li><input name="supports[]" type="checkbox" value="author" />author</li>
											<li><input name="supports[]" type="checkbox" value="thumbnail" />thumbnail</li>
											<li><input name="supports[]" type="checkbox" value="excerpt" />excerpt</li>
											<li><input name="supports[]" type="checkbox" value="trackbacks" />trackbacks</li>
										</ul>
										<ul>
											<li><input name="supports[]" type="checkbox" value="customFields" />custom fields</li>
											<li><input name="supports[]" type="checkbox" value="comments" />comments</li>
											<li><input name="supports[]" type="checkbox" value="revisions" />revisions</li>
											<li><input name="supports[]" type="checkbox" value="pageAttributes"/>page attributes</li>
											<li><input name="supports[]" type="checkbox" value="postFormats" />post formats</li>
										</ul>
									</div>
								</td>
							</tr>
							<tr>
								<td><label for="taxonomies" class="single_line_label">Taxonomies:</label></td>
								<td><input name="taxonomies" type="text" /></td>
							</tr>
							<tr>
								<td><label for="menu_position" class="single_line_label">Menu Position:</label></td>
								<td>
									<select name="menu_position">
										<option value="5">5 - below Posts</option>
										<option value="10">10 - below Media</option>
										<option value="15">15 - below Links</option>
										<option value="20">20 - below Pages</option>
										<option value="25" selected="true">25 - below comments</option>
										<option value="60">60 - below first separator</option>
										<option value="65">65 - below Plugins</option>
										<option value="70">70 - below Users</option>
										<option value="75">75 - below Tools</option>
										<option value="80">80 - below Settings</option>
										<option value="100">100 - below second separator</option>
									</select>
								</td>
							</tr>
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
								<td><label for="show_in_menu" class="single_line_label">Show In Menu:</label></td>
								<td>
									<select name="show_in_menu">
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
								<td><label for="publicly_queryable" class="single_line_label">Publicly Queryable:</label></td>
								<td>
									<select name="publicly_queryable">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="exclude_from_search" class="single_line_label">Exclude From Search:</label></td>
								<td>
									<select name="exclude_from_search">
										<option value="1">True</option>
										<option value="0" selected="selected">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="has_archive" class="single_line_label">Has Archive:</label></td>
								<td>
									<select name="has_archive">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
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
								<td><label for="can_export" class="single_line_label">Can Export:</label></td>
								<td>
									<select name="can_export">
										<option value="1" selected="selected">True</option>
										<option value="0">False</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><label for="capability_type" class="single_line_label">Capability Type:</label></td>
								<td>
									<select name="capability_type">
										<option value="page">Page</option>
										<option value="post" selected="selected">Post</option>
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
								<td><label for="post_type_name" class="single_line_label">Post Type Name:<sup>*</sup></label></td>
								<td><input id="post_type_name" name="post_type_name" class="required_name" type="text" value=""  /><td>
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
								<td><label for="name_admin_bar" class="single_line_label">Name Admin Bar:</label></td>
								<td><input id="name_admin_bar" name="name_admin_bar" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="all_items" class="single_line_label">All Items:</label></td>
								<td><input id="all_items" name="all_items" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="add_new" class="single_line_label">Add New:</label></td>
								<td><input id="add_new" name="add_new" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="add_new_item" class="single_line_label">Add New Item:</label></td>
								<td><input id="add_new_item" name="add_new_item" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="edit_item" class="single_line_label">Edit Item:</label></td>
								<td><input id="edit_item" name="edit_item" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="new_item" class="single_line_label">New Item:</label></td>
								<td><input id="new_item" name="new_item" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="view_item" class="single_line_label">View Item:</label></td>
								<td><input id="view_item" name="view_item" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="search_items" class="single_line_label">Search Items:</label></td>
								<td><input id="search_items" name="search_items" type="text" value="" /></td>
							</tr>
							<tr>
								<td><label for="not_found" class="single_line_label">Not Found:</label></td>
								<td><input id="not_found" name="not_found" type="text" /></td>
							</tr>
							<tr>
								<td><label for="not_found_in_trash" class="single_line_label">Not Found In Trash:</label></td>
								<td><input id="not_found_in_trash" name="not_found_in_trash" type="text" value=""/></td>
							</tr>
							<tr>
								<td><label for="parent_item_colon" class="single_line_label">Parent Item Colon:</label></td>
								<td><input id="parent_item_colon" name="parent_item_colon" type="text" value=""/></td>
							</tr>
						</tbody>
					</table><!-- end 'inside' -->
					
					<h2><?php esc_attr_e( 'Archive Options', 'wp_admin_style' ); ?></h2><br>
	            	<table>
						<tbody>
							<tr>
								<td><label for="archive_layout" class="single_line_label">Archive Style:</label></td>
			                    <td>
				                    <select name="archive_layout">
										<option value="grid" selected="selected" ?>Grid</option>
										<option value="list">List</option>
			                    	</select>
			                    </td>
							</tr>
							<tr>
			                    <td><label for="grid_columns" class="single_line_label">Grid Columns:</label></td>
				                <td>
					                <select name="grid_columns">
										<option value="one">1</option>
										<option value="two">2</option>
										<option value="three" selected="selected">3</option>
										<option value="four">4</option>
										<option value="five">5</option>
										<option value="six">6</option>
										<option value="seven">7</option>
										<option value="eight">8</option>
										<option value="nine">9</option>
										<option value="ten">10</option>
										<option value="eleven">11</option>
										<option value="twelve">12</option>
			                    	</select>
					            </td>
							</tr>
							<tr>
			                    <td><label for="has_sidebar" class="single_line_label">Has Sidebar?:</label></td>
				                <td><input name="has_sidebar" type="checkbox" value="1" checked="checked"/></td>
							</tr>
							<tr>     
			                    <td><label for="filter_taxonomy" class="single_line_label">Filter Taxonomy:</label></td>
			                    <td><input name="filter_taxonomy" type="text" value=""/></td>
							</tr>
							<tr>
			                    <td><label for="rewrite_slug" class="single_line_label">Rewrite Slug:</label>
			                    <td><input name="rewrite_slug" type="text" value=""/><br>
			                </tr>
						</tbody>
	            	</table>
				</div><!-- end 'col-wrap' -->
			</div><!-- end 'col-left' -->
			<div class="button_wrap">
				<?php submit_button('Add New CPT', 'primary', 'add_new_cpt'); ?>
				<input type="hidden" name="action" value="add_new_cpt"/>
			</div>
		</form>
	</div><!-- end 'col-container' -->					
</div><!-- end 'wrap' -->

<?php } ?>
