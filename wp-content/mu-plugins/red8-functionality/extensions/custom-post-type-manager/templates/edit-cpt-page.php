<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>
	
<div class="ez_cpt_creator wrap">
	<h2><?php esc_attr_e( 'Update Custom Post Type', 'wp_admin_style' ); ?></h2>
	<div class="name_error form-invalid"><?php esc_attr_e( 'You must enter a Name', 'wp_admin_style' ); ?></div>
	<div id="col-container">
		<form method="post" name="new_cpt_form" id="update_cpt_form" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
			<div id="col-right">
				<div class="col-wrap">
					<h2><?php esc_attr_e( 'Options', 'wp_admin_style' ); ?></h2><br>
					<table>
						<tbody>
					
							<?php			
								$current_cpt = unserialize(get_option(CPT_CREATOR_OPTION_GROUP));
							
								foreach($current_cpt as $cpt_object) :
								
									if ($cpt_object->unique_id == $_GET['id']) :
							?>
									<tr>
										<td><label class="icon_label" for="select_icon">Admin Menu Icon:</label></td>
										<td><div class="input_wrap menu_icon">
											<input class="icon_text" type="text" size="36" name="select_icon" value="<?php echo $cpt_object->menu_icon ?>" />
											<input name="select_icon" class="button select_icon_button" type="button" value="Select Icon" /> or 
											<input name="upload_icon" class="button upload_icon_button" type="button" value="Upload Icon" /><br>
											<span>(Note: If uploading icon, size must not be larger than 16px x 16px)</span>
										</div></td>
									</tr>
									<tr>
										<td><div class="dashicon_picker_container">
											<ul class="dashicon_picker_list" /></ul>
										</div></td>
									</tr>
									<tr>
										<td><label for="description" class="single_line_label">Description:</label></td>
					                    <td><textarea name="description" value="<?php echo $cpt_object->description; ?>"><?php echo $cpt_object->description; ?></textarea></td>
									</tr>
									<tr>
					                    <td><label for="supports[]" class="single_line_label">Supports:</label></td>
										<td><div class="input_wrap">
										
					                    	<?php if(!empty($cpt_object->supports) && is_array($cpt_object->supports)) : ?>
					                    		<?php $array = $cpt_object->supports; ?>
					                    		<ul>
							                    	<li><input name="supports[]" type="checkbox" value="title" <?php if(in_array("title", $array) ) { echo 'checked'; } ?> />title</li>
													<li><input name="supports[]" type="checkbox" value="editor" <?php if(in_array("editor", $array) ) { echo 'checked'; } ?> />editor</li>
													<li><input name="supports[]" type="checkbox" value="author" <?php if(in_array("author", $array) ) { echo 'checked'; } ?> />author</li>
													<li><input name="supports[]" type="checkbox" value="thumbnail" <?php if(in_array("thumbnail", $array) ) { echo 'checked'; } ?> />thumbnail</li>
													<li><input name="supports[]" type="checkbox" value="excerpt" <?php if(in_array("excerpt", $array) ) { echo 'checked'; } ?> />excerpt
													<li><input name="supports[]" type="checkbox" value="trackbacks" <?php if(in_array("trackbacks", $array) ) { echo 'checked'; } ?> />trackbacks</li>
												</ul>
												<ul>
													<li><input name="supports[]" type="checkbox" value="customFields" <?php if(in_array("customFields", $array) ) { echo 'checked'; } ?> />custom fields</li>
													<li><input name="supports[]" type="checkbox" value="comments" <?php if(in_array("comments", $array) ) { echo 'checked'; } ?> />comments</li>
													<li><input name="supports[]" type="checkbox" value="revisions" <?php if(in_array("revisions", $array) ) { echo 'checked'; } ?> />revisions</li>
													<li><input name="supports[]" type="checkbox" value="pageAttributes" <?php if(in_array("pageAttributes", $array) ) { echo 'checked'; } ?> />page attributes</li>
													<li><input name="supports[]" type="checkbox" value="postFormats" <?php if(in_array("postFormats", $array) ) { echo 'checked'; } ?> />post formats</li>
												</ul>
											<?php else : ?>
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
											<?php endif; ?>
										</div></td>
									</tr>
									<tr>
					                    <td><label for="taxonomies" class="single_line_label">Taxonomies:</label>
					                    <td><input name="taxonomies" type="text" value="<?php if($cpt_object->taxonomies) { $tax_number = 0; foreach($cpt_object->taxonomies as $tax) { if($tax_number == 0) { echo $tax; } else { echo ', '.$tax; } $tax_number++; } } ?>"/><br>
					                </tr>
					                <tr>
					                    <td><label for="rewrite_slug" class="single_line_label">Rewrite Slug:</label>
					                    <td><input name="rewrite_slug" type="text" value="<?php if($cpt_object->slug) { echo $cpt_object->slug; } ?>"/><br>
					                </tr>
					                    <div class="column">
											<tr>
							                    <td><label for="menu_position" class="single_line_label">Menu Position:</label></td>
												<td><select name="menu_position">
													<option value="5" <?php if($cpt_object->menu_position == 5) { echo 'selected';} ?>>5 - below Posts</option>
													<option value="10" <?php if($cpt_object->menu_position == 10) { echo 'selected';} ?>>10 - below Media</option>
													<option value="15" <?php if($cpt_object->menu_position == 15) { echo 'selected';} ?>>15 - below Links</option>
													<option value="20" <?php if($cpt_object->menu_position == 20) { echo 'selected';} ?>>20 - below Pages</option>
													<option value="25" <?php if($cpt_object->menu_position == 25) { echo 'selected';} ?>>25 - below comments</option>
													<option value="60" <?php if($cpt_object->menu_position == 60) { echo 'selected';} ?>>60 - below first separator</option>
													<option value="65" <?php if($cpt_object->menu_position == 65) { echo 'selected';} ?>>65 - below Plugins</option>
													<option value="70" <?php if($cpt_object->menu_position == 70) { echo 'selected';} ?>>70 - below Users</option>
													<option value="75" <?php if($cpt_object->menu_position == 75) { echo 'selected';} ?>>75 - below Tools</option>
													<option value="80" <?php if($cpt_object->menu_position == 80) { echo 'selected';} ?>>80 - below Settings</option>
													<option value="100" <?php if($cpt_object->menu_position == 100) { echo 'selected';} ?>>100 - below second separator</option>
												</select></td>
							                </tr>
											<tr>
							                    <td><label for="hierarchical" class="single_line_label">Hierarchical:</label></td>
												<td><select name="hierarchical">
							                      <option value="1" <?php if($cpt_object->hierarchical == true) { echo 'selected'; } ?>>True</option> 
							                      <option value="0" <?php if($cpt_object->hierarchical == false) { echo 'selected'; } ?>>False</option>
							                    </select></td>
							                </tr>
											<tr>    
							                    <td><label for="public" class="single_line_label">Public:</label></td>
							                    <td><select name="public">
							                      <option value="1" <?php if($cpt_object->public_option == true) { echo 'selected'; } ?>>True</option>
							                      <option value="0" <?php if($cpt_object->public_option == false) { echo 'selected'; } ?>>False</option>
							                    </select></td>
							                </tr>
											<tr>    
							                    <td><label for="show_ui" class="single_line_label">Show UI:</label></td>
							                    <td><select name="show_ui">
							                      <option value="1" <?php if($cpt_object->show_ui == true) { echo 'selected';} ?>>True</option>
							                      <option value="0" <?php if($cpt_object->show_ui == false) { echo 'selected';} ?>>False</option>
							                    </select></td>
							                </tr>
											<tr>    
							                    <td><label for="show_in_menu" class="single_line_label">Show In Menu:</label></td>
							                    <td><select name="show_in_menu">
							                      <option value="1" <?php if($cpt_object->show_in_menu == true) { echo 'selected';} ?>>True</option>
							                      <option value="0" <?php if($cpt_object->show_in_menu == false) { echo 'selected';} ?>>False</option>
							                    </select></td>
							                </tr>
											<tr>    
							                    <td><label for="show_in_nav_menus" class="single_line_label">Show In Nav Menus:</label></td>
							                    <td><select name="show_in_nav_menus">
							                      <option value="1" <?php if($cpt_object->show_in_nav_menus == true) { echo 'selected';} ?>>True</option>
							                      <option value="0" <?php if($cpt_object->show_in_nav_menus == false) { echo 'selected';} ?>>False</option>
							                    </select></td>
							                </tr>
					                    </div>
					                    
					                    <div class="column">
											<tr>
							                    <td><label for="publicly_queryable" class="single_line_label">Publicly Queryable:</label></td>
							                    <td><select name="publicly_queryable">
							                      <option value="1" <?php if($cpt_object->publicly_queryable == true) { echo 'selected';} ?>>True</option>
							                      <option value="0" <?php if($cpt_object->publicly_queryable == false) { echo 'selected';} ?>>False</option>
							                    </select></td>
							                </tr>
											<tr>
							                    <td><label for="exclude_from_search" class="single_line_label">Exclude From Search:</label></td>
							                    <td><select name="exclude_from_search">
							                      <option value="1" <?php if($cpt_object->exclude_from_search == true) { echo 'selected';} ?>>True</option>
							                      <option value="0" <?php if($cpt_object->exclude_from_search == false) { echo 'selected';} ?>>False</option>
							                    </select></td>
							                </tr>
											<tr>    
							                    <td><label for="has_archive" class="single_line_label">Has Archive:</label></td>
							                    <td><select name="has_archive">
							                      <option value="1" <?php if($cpt_object->has_archive == true) { echo 'selected';} ?>>True</option>
							                      <option value="0" <?php if($cpt_object->has_archive == false) { echo 'selected';} ?>>False</option>
							                    </select></td>
							                </tr>
											<tr>    
							                    <td><label for="query_var" class="single_line_label">Query Var:</label></td>
							                    <td><select name="query_var">
							                      <option value="1" <?php if($cpt_object->query_var == true) { echo 'selected';} ?>>True</option>
							                      <option value="0" <?php if($cpt_object->query_var == false) { echo 'selected';} ?>>False</option>
							                    </select></td>
							                </tr>
											<tr>    
							                    <td><label for="can_export" class="single_line_label">Can Export:</label></td>
							                    <td><select name="can_export">
							                      <option value="1" <?php if($cpt_object->can_export == true) { echo 'selected';} ?>>True</option>
							                      <option value="0" <?php if($cpt_object->can_export == false) { echo 'selected';} ?>>False</option>
							                    </select></td>
							                </tr>
											<tr>    
							                    <td><label for="capability_type" class="single_line_label">Capability Type:</label></td>
							                    <td><select name="capability_type">
							                      <option value="page" <?php if($cpt_object->capability_type == "page") { echo 'selected';} ?>>Page</option>
							                      <option value="post" <?php if($cpt_object->capability_type == "post") { echo 'selected';} ?>>Post</option>
							                    </select></td>
											</tr>
					                    </div>
									</tr>
								</tbody>
			                  </table><!-- end 'inside' -->
			                </div><!-- end 'col-wrap' -->
			              </div><!-- end 'col-right' -->
			              <div id="col-left">
			                <div class="col-wrap">
			                  <h2><?php esc_attr_e( 'Labels', 'wp_admin_style' ); ?></h2><br>
			                  <table>
							  	<tbody>
								  	<tr>
					                    <td><label for="post_type_name" class="single_line_label">Post Type Name:<sup>*</sup></label></td>
					                    <td><input name="post_type_name" class="required_name" type="text" value="<?php echo $cpt_object->post_type_name; ?>"  /></td>
								  	</tr>
								  	<tr> 
					                    <td><label for="singular_name" class="single_line_label">Singular name:</label></td>
					                    <td><input name="singular_name" type="text" value="<?php echo $cpt_object->singular_name; ?>"/></td>
					                </tr>
								  	<tr>    
					                    <td><label for="menu_name" class="single_line_label">Menu Name:</label></td>
					                    <td><input name="menu_name" type="text" value="<?php echo $cpt_object->menu_name; ?>"/></td>
					                </tr>
					                <tr>
										<td><label for="name_admin_bar" class="single_line_label">Name Admin Bar:</label></td>
										<td><input id="name_admin_bar" name="name_admin_bar" type="text" value="<?php echo $cpt_object->name_admin_bar; ?>"/></td>
									</tr>
									<tr>
										<td><label for="all_items" class="single_line_label">All Items:</label></td>
										<td><input id="all_items" name="all_items" type="text" value="<?php echo $cpt_object->all_items; ?>"/></td>
									</tr>
								  	<tr> 
					                    <td><label for="add_new" class="single_line_label">Add New:</label></td>
					                    <td><input name="add_new" type="text" value="<?php echo $cpt_object->add_new; ?>"/></td>
					                </tr>
								  	<tr> 
					                    <td><label for="add_new_item" class="single_line_label">Add New Item:</label></td>
					                    <td><input name="add_new_item" type="text" value="<?php echo $cpt_object->add_new_item; ?>"/></td>
					                </tr>
								  	<tr> 
					                    <td><label for="edit_item" class="single_line_label">Edit Item:</label></td>
					                    <td><input name="edit_item" type="text" value="<?php echo $cpt_object->edit_item;?>"/></td>
					                </tr>
								  	<tr>     
					                    <td><label for="new_item" class="single_line_label">New Item:</label></td>
					                    <td><input name="new_item" type="text" value="<?php echo $cpt_object->new_item;?>" /></td>
					                </tr>
								  	<tr>     
					                    <td><label for="view_item" class="single_line_label">View Item:</label></td>
					                    <td><input name="view_item" type="text" value="<?php echo $cpt_object->view_item;?>" /></td>
					                </tr>
								  	<tr>     
					                    <td><label for="search_items" class="single_line_label">Search Items:</label></td>
					                    <td><input name="search_items" type="text" value="<?php echo $cpt_object->search_items;?>" /></td>
					                </tr>
								  	<tr>     
					                    <td><label for="not_found" class="single_line_label">Not Found:</label></td>
					                    <td><input name="not_found" type="text" value="<?php echo $cpt_object->not_found;?>" /></td>
					                </tr>
								  	<tr>     
					                    <td><label for="not_found_in_trash" class="single_line_label">Not Found In Trash:</label></td>
					                    <td><input name="not_found_in_trash" type="text" value="<?php echo $cpt_object->not_found_in_trash;?>"/></td>
					                </tr>
								  	<tr>     
					                    <td><label for="parent_item_colon" class="single_line_label">Parent Item Colon:</label></td>
					                    <td><input name="parent_item_colon" type="text" value="<?php echo $cpt_object->parent_item_colon;?>"/></td>
									</tr>
		                    <?php endif; ?>
						<?php endforeach; ?>
							</tbody>
						</table><!-- end 'inside' -->
						
						<h2><?php esc_attr_e( 'Archive Options', 'wp_admin_style' ); ?></h2><br>
		            	<table>
							<tbody>
								<tr>
									<td><label for="archive_layout" class="single_line_label">Archive Style:</label></td>
				                    <td>
					                    <select name="archive_layout">
											<option value="grid" <?php if($cpt_object->archive_layout == 'grid') { echo 'selected'; } ?>>Grid</option>
											<option value="list" <?php if($cpt_object->archive_layout == 'list') { echo 'selected'; } ?>>List</option>
				                    	</select>
				                    </td>
								</tr>
								<tr>
				                    <td><label for="grid_columns" class="single_line_label">Grid Columns:</label></td>
					                <td>
						                <select name="grid_columns">
										<option value="one" <?php if($cpt_object->grid_columns == 'one') { echo 'selected="selected"'; } ?>>1</option>
										<option value="two" <?php if($cpt_object->grid_columns == 'two') { echo 'selected="selected"'; } ?>>2</option>
										<option value="three" <?php if($cpt_object->grid_columns == 'three') { echo 'selected="selected"'; } ?>>3</option>
										<option value="four" <?php if($cpt_object->grid_columns == 'four') { echo 'selected="selected"'; } ?>>4</option>
										<option value="five" <?php if($cpt_object->grid_columns == 'five') { echo 'selected="selected"'; } ?>>5</option>
										<option value="six" <?php if($cpt_object->grid_columns == 'six') { echo 'selected="selected"'; } ?>>6</option>
										<option value="seven" <?php if($cpt_object->grid_columns == 'seven') { echo 'selected="selected"'; } ?>>7</option>
										<option value="eight" <?php if($cpt_object->grid_columns == 'eight') { echo 'selected="selected"'; } ?>>8</option>
										<option value="nine" <?php if($cpt_object->grid_columns == 'nine') { echo 'selected="selected"'; } ?>>9</option>
										<option value="ten" <?php if($cpt_object->grid_columns == 'ten') { echo 'selected="selected"'; } ?>>10</option>
										<option value="eleven" <?php if($cpt_object->grid_columns == 'eleven') { echo 'selected="selected"'; } ?>>11</option>
										<option value="twelve" <?php if($cpt_object->grid_columns == 'twelve') { echo 'selected="selected"'; } ?>>12</option>
			                    	</select>
						            </td>
								</tr>
								<tr>
				                    <td><label for="has_sidebar" class="single_line_label">Has Sidebar?:</label></td>
					                <td><input name="has_sidebar" type="checkbox" value="1" <?php if($cpt_object->has_sidebar == 1) { echo 'checked="checked"'; } ?>/></td>
								</tr>
								<tr>     
				                    <td><label for="filter_taxonomy" class="single_line_label">Filter Taxonomy:</label></td>
				                    <td><input name="filter_taxonomy" type="text" value="<?php echo $cpt_object->filter_taxonomy;?>"/></td>
								</tr>
							</tbody>
		            	</table>
					</div><!-- end 'col-wrap' -->
				</div><!-- end 'col-left' -->
			<div class="button_wrap">
				<?php submit_button('Update', 'primary', 'update_cpt'); ?>
				<input type="hidden" name="action" value="update_cpt"/>
			</div>
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
		</form>
	</div><!-- end 'col-container' -->					
</div><!-- end 'wrap' -->
