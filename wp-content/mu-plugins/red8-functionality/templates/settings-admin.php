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
					<label for="<?php echo RED8_FUNCTIONALITY_SHOW_NOTIFICATIONS; ?>">Show Notifications</label>
				</th>
				<td>
					<?php $show_notifications = get_option(RED8_FUNCTIONALITY_SHOW_NOTIFICATIONS, 1); ?>
					<input name="<?php echo RED8_FUNCTIONALITY_SHOW_NOTIFICATIONS; ?>" type="checkbox" id="<?php echo RED8_FUNCTIONALITY_SHOW_NOTIFICATIONS; ?>" value="1" <?php if($show_notifications == 1) { echo 'checked="checked"'; } ?>><span style="margin-left: 20px; font-size: 0.8em;">*Uncheck this box if you do not want to receive notices on the admin dashboard</span>
				</td>
			</tr>
		</tbody>
	</table>
	<?php submit_button('Save Settings', 'primary', 'update_red8_functionality_settings'); ?>
	<input type="hidden" name="action" value="update_red8_functionality_settings">
</form>