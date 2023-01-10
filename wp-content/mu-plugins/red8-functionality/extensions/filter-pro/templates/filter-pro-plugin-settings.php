<form method="post" action="<?php echo get_admin_url(); ?>admin-post.php">
	<div class="form_fields">
		<label for="<?php echo FILTER_PRO_PLUGIN_RESULTS_FORMAT; ?>">Results Format:</label>
		<textarea rows="10" cols="60" name="<?php echo FILTER_PRO_PLUGIN_RESULTS_FORMAT; ?>" id="<?php echo FILTER_PRO_PLUGIN_RESULTS_FORMAT; ?>" style="font-weight: normal;"><?php echo $filter_pro_results_format; ?></textarea>
	</div>
	<div class="available_shortcodes">
		<h3>Available Items</h3>
		<p>Click each link to add it to the "Results Format" text area.</p>
		<ul>
			<li><a href="#">[filter_pro_id]</a> - Inserts the post's ID</li>
			<li><a href="#">[filter_pro_thumbnail]</a> - Inserts the post's thumbnail image</li>
			<li><a href="#">[filter_pro_permalink]</a> - Inserts the post's permalink</li>
			<li><a href="#">[filter_pro_title]</a> - Inserts the post's title</li>
			<li><a href="#">[filter_pro_content]</a> - Inserts the post's content</li>
			<li><a href="#">[filter_pro_content_trimmed]</a> - Inserts the post's content trimmed to 55 words</li>
			<li><a href="#">[filter_pro_excerpt]</a> - Inserts the post's excerpt</li>
			<li><a href="#">[filter_pro_author]</a> - Inserts the post's author</li>
			<li><a href="#">[filter_pro_author_link]</a> - Inserts the post's author with a link</li>
		</ul>
		<h3>Customization</h3>
		<p>Looking for more customization? Know a little code? Use the supplied filter hook, like so - add_filter("filter_pro_html", "function"), to fully customize what returns for each post.</p>
		<p>Or if you add a "filter_id" to your shortcode, you can add a filter for just that shortcode. So, instead of add_filter("filter_pro_html", "function"), you would use add_filter("filter_pro_html_$filter_id", "function"). This allows you to use multiple shortcodes across your site, with each of them having unique styles.</p>
	</div>
	<?php submit_button('Update Settings', 'primary', 'update_filter_pro_settings'); ?>
	<input type="hidden" name="action" value="update_filter_pro_settings">
</form>