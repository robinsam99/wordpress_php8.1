<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
?>
<form method="post" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="<?php echo RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATE_STATUS; ?>">Auto Update Status</label>
				</th>
				<td>
					<select name="<?php echo RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATE_STATUS; ?>" id="red8_func_plugin_auto_update">
						<?php $update_status = get_option(RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATE_STATUS, 'individual'); ?>
						<option value="individual" <?php if($update_status == 'individual') { echo 'selected="selected"'; } ?>>Individual</option>
						<option value="on" <?php if($update_status == 'on') { echo 'selected="selected"'; } ?>>All On</option>
						<option value="off" <?php if($update_status == 'off') { echo 'selected="selected"'; } ?>>All Off</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<table class="widefat fixed individual_plugin_update_settings" cellspacing="0" <?php if($update_status != 'individual') { echo 'style="display: none;"'; } ?>>
	    <thead>
		    <tr>
	            <th id="plugin_name" class="manage-column column-plugin_name" scope="col">Plugin Name</th>
	            <th id="plugin_auto_update" class="manage-column column-plugin_auto_update" scope="col">Auto Updates? <a href="#" class="red8_func_auto_update_toggle">Toggle All</a></th>
	            <th id="plugin_active" class="manage-column column-plugin_active" scope="col">Plugin Active</th>
		    </tr>
	    </thead>
	    <tfoot>
		    <tr>
	            <th class="manage-column column-plugin_name" scope="col">Plugin Name</th>
	            <th class="manage-column column-plugin_auto_update" scope="col">Auto Updates? <a href="#" class="red8_func_auto_update_toggle">Toggle All</a></th>
	            <th class="manage-column column-plugin_active" scope="col">Plugin Active</th>
		    </tr>
	    </tfoot>
	    <tbody>
		    <?php 
			    $alternate = true; 
			    $auto_updates = unserialize(get_option(RED8_FUNCTIONALITY_PLUGIN_AUTO_UPDATES)); 
			    
			    if ( ! function_exists( 'get_plugins' ) ) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}
				
				$all_plugins = get_plugins();
			?>
			<?php foreach($all_plugins as $key => $plugin) { ?>
				<?php 
					$slug_array = explode('/', $key); 
					$slug = $slug_array[0]; 
					$auto_update = false;
					if($auto_updates && is_array($auto_updates)) {
						$auto_update = in_array($slug, $auto_updates);
					} 
					
					$plugin_active = is_plugin_active($key);
				?>
				<tr class="<?php if($alternate) { echo 'alternate'; } ?>">
	            	<td class="column-plugin_name"><?php echo $plugin['Name']; ?></td>
	            	<td class="column-plugin_auto_update" style="padding-left: 80px;">
		            	<input type="checkbox" name="plugin_auto_updates[]" value="<?php echo $slug; ?>" <?php if($auto_update) { echo 'checked="checked"'; } ?>/>
		            </td>
		            <td class="column-plugin_active">
			            <?php if($plugin_active) : ?>
			            	<p style="color: green; margin: 0;">Active</p>
			            <?php else : ?>
			            	<p style="color: red; margin: 0">Deactive</p>
			            <?php endif; ?>
		            </td>
	        	</tr>
			<?php $alternate = !$alternate; } ?>
	    </tbody>
	</table>
	<?php submit_button('Save Settings', 'primary', 'update_red8_functionality_update_settings'); ?>
	<input type="hidden" name="action" value="update_red8_functionality_update_settings">
</form>