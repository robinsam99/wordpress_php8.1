<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
		exit; // Exit if accessed directly
	}

 ?>
<?php 
	//if(isset( $_GET['action'] ) &&  $_GET['action'] == 'del_tax') {
	//	self::delete_tax();
	//}
 ?>
<div class="display_ez_tax_page wrap">
	<h2>
		<?php esc_attr_e( 'Taxonomies', 'wp_admin_style' ); ?>
		<a class="button-primary add_new_button" href="<?php echo admin_url('admin.php?page=add-new-taxonomy'); ?>">Add New</a>
	</h2>
	
	<?php if (isset( $_GET['msg'] ) ) : ?>
		<?php if ($_GET['msg'] == 'del_tax') : ?>
			<div class="message updated">
				<p>Taxonomy Has Been Deleted</p>
			</div>
		<?php elseif ($_GET['msg'] == 'update_tax') : ?>
			<div class="message updated">
				<p>Taxonomy Has Been Updated</p>
			</div>
		<?php elseif ($_GET['msg'] == 'add_new') : ?>
			<div class="message updated">
				<p>Taxonomy Has Been Added</p>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	
	<h3>CPT Manager Taxonomies:</h3>
	
	<form method="post" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th><?php esc_attr_e( 'Taxonomy', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Attached Post Types', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Active', 'wp_admin_style' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$current_tax = unserialize(get_option(CPT_TAX_OPTION_GROUP));
				$count = 0;
				if ($current_tax) :
					foreach($current_tax as $tax) :
	
						if(!$tax->unique_id) {
							if (get_option(TAX_INCREMENT)) {
								$id = intval(get_option(TAX_INCREMENT)) + 1;
							}
							update_option(TAX_INCREMENT, $id);
							
							$tax->unique_id = $id;
							$current_tax[$count] = $tax;
						}
					
						$del_url = admin_url( 'admin.php?page=taxonomies' ) . '&action=del_tax&key=' . $tax->unique_id;
						//$del_url = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($del_url, 'nonce_del_tax') : $del_url;

				?>
						<tr class="<?php if ($count % 2 == 0) { echo 'alternate'; } ?>">
							<td>
								<label for="tablecell">
									<?php esc_attr_e($tax->tax_name, 'wp_admin_style'); ?>
								</label><br>
								<div class="edit_wrap">
									<a href="<?php echo admin_url('admin.php?page=add-new-taxonomy&id='. $tax->unique_id); ?>">Edit</a> |
									<a href="<?php echo $del_url; ?>" title="<?php _e('Move this item to the Trash'); ?>"><?php _e('Delete', 'EZ_CPT_Creator'); ?></a>
									
									<!--<a href="<?php echo admin_url('admin.php?page=taxonomies&delete='. $tax->unique_id) ?>">Delete</a>-->
								</div>
								
							</td>
							<td>
								<?php esc_attr_e( $tax->menu_name, 'wp_admin_style' ); ?>
							</td>
							<td>
								<?php 
									if($tax->post_types) {
										$i = 0;
										$object_count = count($tax->post_types);
										foreach($tax->post_types as $posts) {
											esc_attr_e( $posts, 'wp_admin_style' );
											$i++;
											if($i != $object_count) {
												echo ', ';
											}
										}	
									}
								?>
							</td>
							<td>
								<input type="checkbox" class="activation" name="<?php echo str_replace(" ", "-", strtolower($tax->tax_name)); ?>" value="1" <?php if($tax->is_active == 1) { echo 'checked="checked"'; } ?> onChange="this.form.submit();"/>
							</td>
						</tr>
					<?php $count++; ?>
					<?php endforeach; update_option(CPT_TAX_OPTION_GROUP, serialize($current_tax));?>
				<?php endif; ?>
				<input type="hidden" name="action" value="update_active_taxonomies">
		</tbody>
		<tfoot>
			<tr>
				<th><?php esc_attr_e( 'Taxonomy', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Attached Post Types', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Active', 'wp_admin_style' ); ?></th>
			</tr>
		</tfoot>
	</table>
	</form>
	<h3>Taxonomies Built Into WordPress:</h3>
	<table class="widefat">
		<thead>
			<tr>
				<th><?php esc_attr_e( 'Taxonomy', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Attached Post Types', 'wp_admin_style' ); ?></th>
			</tr>
		</thead>
		<tbody>

			<?php 
				$builtin_cpts = get_taxonomies( array(
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
							<td>
								<?php
									$i = 0;
									$object_count = count($builtin->object_type);
									foreach($builtin->object_type as $object) {
										esc_attr_e( $object, 'wp_admin_style' );
										$i++;
										if($i != $object_count) {
											echo ', ';
										}
									} 
								?>
							</td>
						</tr>
					<?php $count++; ?>
					<?php endforeach; ?>
				<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th><?php esc_attr_e( 'Taxonomy', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Label', 'wp_admin_style' ); ?></th>
				<th><?php esc_attr_e( 'Attached Post Types', 'wp_admin_style' ); ?></th>
			</tr>
		</tfoot>
	</table>
</div>
