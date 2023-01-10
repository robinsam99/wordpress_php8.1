<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>
<div class="display_ez_cpt_page wrap">
	<h2>
		<?php esc_attr_e( 'Sidebar Manager', 'wp_admin_style' ); ?>
		<a class="button-primary add_new_button" href="<?php echo admin_url('admin.php?page='.RED8_SIDEBAR_MANAGER_PLUGIN_NAME.'&add=yes'); ?>">Add New</a>
	</h2>
	
	<?php if (isset( $_GET['msg'] )) : ?>
		<?php if ($_GET['msg'] == 'delete_sidebar') : ?>
			<div class="message updated">
				<p>Sidebar Has Been Deleted</p>
			</div>
		<?php elseif ($_GET['msg'] == 'update_sidebar') :  ?>
			<div class="message updated">
				<p>Sidebar Has Been Updated</p>
			</div>
		<?php elseif ($_GET['msg'] == 'add_new') :  ?>
			<div class="message updated">
				<p>Sidebar Has Been Added</p>
			</div>
		<?php elseif ($_GET['msg'] == 'update_default') :  ?>
			<div class="message updated">
				<p>Default Sidebar Has Been Updated</p>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	
	<h3>Sidebars</h3>
	
	<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th><?php esc_attr_e( 'Sidebar Name', 'wp_admin_style' ); ?></th>
			</tr>
		</thead>
		<tbody>
		
			<?php 
				$sidebars = unserialize(get_option(RED8_SIDEBAR_MANAGER_OPTION_GROUP));
				$count = 0;
				if ($sidebars) {
					foreach($sidebars as $sidebar) :
				?>
						<tr class="<?php if ($count % 2 == 0) { echo 'alternate'; } ?>">
							<td>
								<label for="tablecell">
									<?php esc_attr_e($sidebar->name, 'wp_admin_style'); ?>
									<input type="hidden" name="edit_cpt" value="<?php $sidebar->id; ?>"/>
								</label><br>
								<div class="edit_wrap">
									<a href="<?php echo admin_url('admin.php?page='.RED8_SIDEBAR_MANAGER_PLUGIN_NAME.'&id='. $sidebar->id); ?>">Edit</a> | 
									<a href="<?php echo admin_url( 'admin.php?page='.RED8_SIDEBAR_MANAGER_PLUGIN_NAME. '&action=delete_sidebar&key=' . $sidebar->id ); ?>" title="<?php _e('Move this item to the Trash'); ?>"><?php _e('Delete', 'EZ_CPT_Creator'); ?></a>
								</div>
							</td>
						</tr>
					<?php $count++; ?>
					<?php endforeach; ?>
				<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th><?php esc_attr_e( 'Sidebar Name', 'wp_admin_style' ); ?></th>
			</tr>
		</tfoot>
	</table>
	<br>
	<h3>Default Sidebar</h3>
	<form method="post" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
		<select name="<?php echo RED8_SIDEBAR_DEFAULT_SIDEBAR; ?>">
			<option value="">-- Select a Sidebar --</option>
			<?php 
				//$sidebars = unserialize(get_option(RED8_SIDEBAR_MANAGER_OPTION_GROUP));
				global $wp_registered_sidebars;
				$current_sidebar = get_option(RED8_SIDEBAR_DEFAULT_SIDEBAR, '');
				$count = 0;
				if ($wp_registered_sidebars) {
					foreach($wp_registered_sidebars as $sidebar) :
				?>
						<option value="<?php echo $sidebar['id']; ?>" <?php if($current_sidebar == $sidebar['id']) { echo 'selected="selected"'; } ?>><?php echo $sidebar['name']; ?></option>
					<?php $count++; ?>
					<?php endforeach; ?>
			<?php } ?>
		</select>
		<div class="button_wrap">
			<?php submit_button('Update', 'primary', 'update_default_sidebar'); ?>
			<input type="hidden" name="action" value="update_default_sidebar"/>
		</div>
	</form>
</div>
