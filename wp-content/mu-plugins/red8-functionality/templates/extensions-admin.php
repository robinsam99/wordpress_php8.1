<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
?>
<form method="post" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
	<table class="widefat fixed" cellspacing="0">
	    <thead>
		    <tr>
	            <th id="extension_name" class="manage-column column-extension_name" scope="col">Extension Name</th>
	            <th id="extension_description" class="manage-column column-extension_description" scope="col">Description</th>
	            <th id="extension_activated" class="manage-column column-extension_activated" scope="col">Activated?</th>
		    </tr>
	    </thead>
	    <tfoot>
		    <tr>
	            <th class="manage-column column-extension_name" scope="col">Extension Name</th>
	            <th class="manage-column column-extension_description" scope="col">Description</th>
	            <th class="manage-column column-extension_activated" scope="col">Activated</th>
		    </tr>
	    </tfoot>
	    <tbody>
		    <?php $alternate = true; ?>
			<?php foreach(self::$extensions as $extension) { ?>
				<?php $is_active = get_option($extension['option_name'], 0); ?>
				<tr class="<?php if($alternate) { echo 'alternate'; } ?>">
	            	<td class="column-extension_name">
		            	<?php if($extension['admin_page'] && self::can_plugin_run($extension) && $is_active == 1) : ?>
		            		<a href="<?php echo get_admin_url().$extension['admin_page']; ?>">
		            	<?php endif;?>
		            	<?php echo $extension['title']; ?>
		            	<?php if($extension['admin_page'] && self::can_plugin_run($extension) && $is_active == 1) : ?>
		            		</a>
		            	<?php endif;?>
		            </td>
	            	<td class="column-extension_description"><?php echo $extension['description']; ?></td>
	            	<td class="column-extension_activated">
		            	<?php 
			            	if($extension['name'] == 'filter_pro') :
								$current_theme = wp_get_theme();
								if($current_theme->get('Template') == 'red8-base') {
									$is_active = 0;
								}
						?>
							Already Active in Theme
						<?php elseif(!self::can_plugin_run($extension)) : ?>
		            		Required plugin(s) are not active
		            	<?php elseif($extension['name'] == 'footer_popup' || $extension['name'] == 'yoast_acf') : ?>
		            		Coming Soon!
		            	<?php else : ?>
		            		<input type="checkbox" name="<?php echo $extension['option_title']; ?>" value="1" <?php if($is_active == 1) { echo 'checked="checked"'; } ?>/>
		            	<?php endif; ?>
		            </td>
	        	</tr>
			<?php $alternate = !$alternate; } ?>
	    </tbody>
	</table>
	<?php submit_button('Save Settings', 'primary', 'update_red8_functionality_extensions'); ?>
	<input type="hidden" name="action" value="update_red8_functionality_extensions">
</form>