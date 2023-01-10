<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>

	
<div class="sidebar_manager_wrap wrap">
	<h2><?php esc_attr_e( 'Add A Sidebar', 'wp_admin_style' ); ?></h2>
	
	<div class="name_error form-invalid"><?php esc_attr_e( 'You must enter a Name', 'wp_admin_style' ); ?></div>

	<form method="post" id="new_sidebar_form" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
		<table>
			<tbody>
				<tr>
					<td><label for="sidebar_name" class="single_line_label">Name:<sup>*</sup></label></td>
					<td><input id="sidebar_name" name="sidebar_name" class="required_name" type="text" value=""  /><td>
				</tr>
				<tr>
					<td><label for="sidebar_id" class="single_line_label">Sidebar ID:</label></td>
					<td><input id="sidebar_id" name="sidebar_id" type="text" value=""/></td>
				</tr>
				<tr>
					<td><label for="sidebar_description" class="single_line_label">Description:</label></td>
					<td><input id="sidebar_description" name="sidebar_description" type="text" value=""/></td>
				</tr>
				<tr>
					<td><label for="sidebar_class" class="single_line_label">Class:</label></td>
					<td><input id="sidebar_class" name="sidebar_class" type="text" value=""/></td>
				</tr>
				<tr>
					<td><label for="before_widget" class="single_line_label">Before Widget:</label></td>
					<td><input id="before_widget" name="before_widget" type="text" value='<aside id="%1$s" class="widget %2$s">'/></td>
				</tr>
				<tr>
					<td><label for="after_widget" class="single_line_label">After Widget:</label></td>
					<td><input id="after_widget" name="after_widget" type="text" value='</aside>'/></td>
				</tr>
				<tr>
					<td><label for="before_title" class="single_line_label">Before Title:</label></td>
					<td><input id="before_title" name="before_title" type="text" value='<h2 class="widget-title">'/></td>
				</tr>
				<tr>
					<td><label for="after_title" class="single_line_label">After Title:</label></td>
					<td><input id="after_title" name="after_title" type="text" value='</h2>'/></td>
				</tr>
			</tbody>
		</table><!-- end 'inside' -->
		<div class="button_wrap">
			<?php submit_button('Add New', 'primary', 'add_new_sidebar'); ?>
			<input type="hidden" name="action" value="add_new_sidebar"/>
		</div>
	</form>				
</div><!-- end 'wrap' -->
