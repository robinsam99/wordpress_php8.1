<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
?>

<div class="wrap">
	<h2>Speed Bump Settings</h2>
	<?php if(isset($_GET['updated']) && $_GET['updated'] == 'true') : ?>
		<div class="message updated">
			<p>Settings Saved Successfully</p>
		</div>
	<?php endif; ?>
	<form method="post" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="speed_bump_title">Title</label>
					</th>
					<td>
						<input name="speed_bump_title" type="text" id="speed_bump_title" value="<?php echo get_option(WP_SPEED_BUMP_TITLE); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="speed_bump_title">Text</label>
					</th>
					<td>
						<textarea  name="speed_bump_text" id="speed_bump_text" style="width: 25em;" rows="6"><?php echo get_option(WP_SPEED_BUMP_TEXT); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="speed_bump_title">Positive Button Title</label>
					</th>
					<td>
						<input name="speed_bump_agree" type="text" id="speed_bump_agree" value="<?php echo get_option(WP_SPEED_BUMP_OK_TITLE); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="speed_bump_title">Negative Button Title</label>
					</th>
					<td>
						<input name="speed_bump_cancel" type="text" id="speed_bump_cancel" value="<?php echo get_option(WP_SPEED_BUMP_CANCEL_TITLE); ?>" class="regular-text">
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button('Update', 'primary', 'update_speed_bump_settings'); ?>
		<input type="hidden" name="action" value="update_speed_bump_settings">
	</form>
</div>