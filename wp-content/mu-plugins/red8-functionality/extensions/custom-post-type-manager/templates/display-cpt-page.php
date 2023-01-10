<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>
<div class="display_ez_cpt_page wrap">
	<h2>
		<?php esc_attr_e( 'Custom Post Types', 'wp_admin_style' ); ?>
		<a class="button-primary add_new_button" href="<?php echo admin_url('admin.php?page=add-new-custom-post-type'); ?>">Add New</a>
	</h2>
	
	<?php if (isset( $_GET['msg'] )) : ?>
		<?php if ($_GET['msg'] == 'del_cpt') : ?>
			<div class="message updated">
				<p>Post Type Has Been Deleted</p>
			</div>
		<?php elseif ($_GET['msg'] == 'update_cpt') :  ?>
			<div class="message updated">
				<p>Post Type Has Been Updated</p>
			</div>
		<?php elseif ($_GET['msg'] == 'add_new') :  ?>
			<div class="message updated">
				<p>Post Type Has Been Added</p>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	
	<h3>CPT Manager Post Types:</h3>
	<form method="post" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
	<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th><?php esc_attr_e( 'Post Type', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Taxonomies', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Active', 'wp_admin_style' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$current_cpt = unserialize(get_option(CPT_CREATOR_OPTION_GROUP));
				$post_type_names = array();
				$count = 0;
				if ($current_cpt) {
					foreach($current_cpt as $cpt) :
					
					$post_type_names[] = $cpt->post_type_name;
					$del_url = admin_url( 'admin.php?page='.CPT_MANAGER_PLUGIN_NAME ). '&action=del_cpt&key=' . $cpt->unique_id;
				?>
						<tr class="<?php if ($count % 2 == 0) { echo 'alternate'; } ?>">
							<td>
								<label for="tablecell">
									<?php esc_attr_e($cpt->post_type_name, 'wp_admin_style'); ?>
									<input type="hidden" name="edit_cpt" value="<?php $cpt->unique_id; ?>"/>
								</label><br>
								<div class="edit_wrap">
									<a href="<?php echo admin_url('admin.php?page=add-new-custom-post-type&id='. $cpt->unique_id); ?>">Edit</a><div class="line_break">|</div>
									<a href="<?php echo $del_url; ?>" title="<?php _e('Move this item to the Trash'); ?>"><?php _e('Delete', 'EZ_CPT_Creator'); ?></a>
								</div>
							</td>
							<td>
								<?php esc_attr_e( $cpt->menu_name, 'wp_admin_style' ); ?>
							</td>
							<td>
								<?php 
									$tax_number = 0;
									if($cpt->taxonomies) {
										foreach($cpt->taxonomies as $tax) {
											if($tax_number == 0) {
												echo $tax;
											} else {
												echo ', '.$tax;
											}
											$tax_number++;
										}
									} else {
										echo 'No Taxonomies';
									}
								?>
							</td>
							<td>
								<input type="checkbox" class="activation" name="<?php echo str_replace(" ", "-", strtolower($cpt->post_type_name)); ?>" value="1" <?php if($cpt->is_active == 1) { echo 'checked="checked"'; } ?> onChange="this.form.submit();"/>
							</td>
						</tr>
					<?php $count++; ?>
					<?php endforeach; ?>
				<?php } ?>
				<input type="hidden" name="action" value="update_active_cpts">
		</tbody>
		<tfoot>
			<tr>
				<th><?php esc_attr_e( 'Post Type', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Taxonomies', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Active', 'wp_admin_style' ); ?></th>
			</tr>
		</tfoot>
	</table>
	</form>
	<h3>Post Types Built Into WordPress:</h3>
	<table class="widefat">
		<thead>
			<tr>
				<th><?php esc_attr_e( 'Post Type', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
			</tr>
		</thead>
		<tbody>

			<?php 
				$builtin_cpts = get_post_types( array(
					'_builtin' => true,
					), 'object'
				);
				$count = 0;
				if ($builtin_cpts) {
					foreach($builtin_cpts as $builtin) :
				?>
						<tr class="<?php if ($count % 2 == 0) { echo 'alternate'; } ?>">
							<td>
								<label for="tablecell">
									<?php esc_attr_e($builtin->name, 'wp_admin_style'); ?>

								</label><br>
							</td>
							<td>
								<?php esc_attr_e( $builtin->label, 'wp_admin_style' ); ?>
							</td>
						</tr>
					<?php $count++; ?>
					<?php endforeach; ?>
				<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th><?php esc_attr_e( 'Post Type', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
			</tr>
		</tfoot>
	</table>
</div>
