<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>

<?php			
	$sidebars = unserialize(get_option(RED8_SIDEBAR_MANAGER_OPTION_GROUP));

	foreach($sidebars as $sidebar) :
	
		if ($sidebar->id == $_GET['id']) :
?>
			<div class="sidebar_manager_wrap wrap">
				
				<div class="name_error form-invalid"><?php esc_attr_e( 'You must enter a Name', 'wp_admin_style' ); ?></div>
			
				<form method="post" id="update_sidebar_form" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
					<h3><?php esc_attr_e( 'Sidebar Options', 'wp_admin_style' ); ?></h3>
					<table>
						<tbody>
							<tr>
								<td><label for="sidebar_name" class="single_line_label">Name:<sup>*</sup></label></td>
								<td><input id="sidebar_name" name="sidebar_name" class="required_name" type="text" value="<?php echo $sidebar->name; ?>"  /><td>
							</tr>
							<tr>
								<td><label for="sidebar_id" class="single_line_label">Sidebar ID:</label></td>
								<td><input id="sidebar_id" name="sidebar_id" type="text" value="<?php echo $sidebar->sidebar_id; ?>"/></td>
							</tr>
							<tr>
								<td><label for="sidebar_description" class="single_line_label">Description:</label></td>
								<td><input id="sidebar_description" name="sidebar_description" type="text" value="<?php echo $sidebar->description; ?>"/></td>
							</tr>
							<tr>
								<td><label for="sidebar_class" class="single_line_label">Class:</label></td>
								<td><input id="sidebar_class" name="sidebar_class" type="text" value="<?php echo $sidebar->sidebar_class; ?>"/></td>
							</tr>
							<tr>
								<td><label for="before_widget" class="single_line_label">Before Widget:</label></td>
								<td><input id="before_widget" name="before_widget" type="text" value="<?php echo esc_attr($sidebar->before_widget); ?>"/></td>
							</tr>
							<tr>
								<td><label for="after_widget" class="single_line_label">After Widget:</label></td>
								<td><input id="after_widget" name="after_widget" type="text" value="<?php echo esc_attr($sidebar->after_widget); ?>"/></td>
							</tr>
							<tr>
								<td><label for="before_title" class="single_line_label">Before Title:</label></td>
								<td><input id="before_title" name="before_title" type="text" value="<?php echo esc_attr($sidebar->before_title); ?>"/></td>
							</tr>
							<tr>
								<td><label for="after_title" class="single_line_label">After Title:</label></td>
								<td><input id="after_title" name="after_title" type="text" value="<?php echo esc_attr($sidebar->after_title); ?>"/></td>
							</tr>
						</tbody>
					</table><!-- end 'inside' -->
					<div class="button_wrap">
						<?php submit_button('Update', 'primary', 'update_sidebar'); ?>
						<input type="hidden" name="action" value="update_sidebar"/>
						<input type="hidden" name="id" value="<?php echo $sidebar->id; ?>"/>
					</div>
				</form>				
			</div><!-- end 'wrap' -->
<?php 
		endif;
	endforeach;
?>