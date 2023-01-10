<div class="shortcode_row">
	<h4>Generated Shortcode:</h4><input type="text" class="generated_shortcode"/><button class="button" type="button" id="add_filter_pro_shortcode" style="display: none;">Add To Content</button>
</div>
<div class="shortcode_row filter_pro_sc_post_types">
	<p>Post Types:</p>
	<select name="post_types" size="7" multiple>
	<?php $post_types = get_post_types(array('public' => true), 'objects'); ?>
	<?php foreach($post_types as $post_type) { ?>
		<option value="<?php echo $post_type->name; ?>" <?php if($post_type->name == 'post') { echo 'checked="checked"'; } ?>><?php echo $post_type->labels->name; ?></option>
	<?php } ?>
	</select>
</div>
<div class="shortcode_row filter_pro_sc_taxonomies">
	<p>Taxonomies:</p>
	<select id="filter_pro_taxonomies" size="7" multiple>
		<?php $taxonomies = get_object_taxonomies(array('post'), 'objects'); ?>
		<?php foreach($taxonomies as $taxonomy) { ?>
			<option value="<?php echo $taxonomy->name; ?>"><?php echo $taxonomy->labels->name; ?></option>
		<?php } ?>
	</select>
</div>
<div class="shortcode_row filter_pro_sc_style">
	<p>Style:</p>
	<label><input type="radio" name="style" value="radio" checked="checked">Radio Buttons</label>
	<label><input type="radio" name="style" value="select">Select Dropdown</label>
	<label><input type="radio" name="style" value="checkbox">Checkboxes</label>
</div>
<div class="shortcode_row filter_pro_sc_terms">
	<p>Excluded Terms:</p>
	<select id="excluded_terms" size="10" style="display: none;" multiple></select>
</div>
<div class="shortcode_row filter_pro_sc_orderby">
	<p>Orderby:</p>
	<select name="orderby">
		<option value="none">None</option>
		<option value="ID">Post ID</option>
		<option value="author">Author</option>
		<option value="title" selected="selected">Title</option>
		<option value="name">Name</option>
		<option value="type">Type</option>
		<option value="date">Date</option>
		<option value="modified">Modified</option>
		<option value="parent">Parent</option>
		<option value="rand">Random</option>
		<option value="comment_count">Comment Count</option>
		<option value="menu_order">Menu Order</option>
		<option value="meta_value">Meta Value</option>
		<option value="meta_value_num">Meta Value Num</option>
		<option value="post__in">Post__In</option>
	</select>
</div>
<div class="shortcode_row filter_pro_sc_order">
	<p>Order:</p>
	<select name="order">
		<option value="ASC" selected="selected">Ascending</option>
		<option value="DESC">Descending</option>
	</select>
</div>
<div class="shortcode_row filter_pro_sc_number">
	<p>Number of Posts:</p>
	<input type="number" name="number" value="10" min="-1"/>
</div>
<div class="shortcode_row filter_pro_sc_lmt">
	<p>Load More Text:</p>
	<input type="text" name="load_more_text" value="Load More Posts"/>
</div>
<div class="shortcode_row filter_pro_filter_id">
	<p>Filter ID: (No whitespaces)</p>
	<input type="text" name="filter_id" />
</div>
<?php submit_button('Create Shortcode', 'primary', 'create_shortcode_button'); ?>