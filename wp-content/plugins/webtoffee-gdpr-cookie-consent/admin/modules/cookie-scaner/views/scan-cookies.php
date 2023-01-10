<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap">
<style type="text/css">
.cli_scanbar{width:100%; box-sizing: border-box; height:auto; float: left; padding:5px 0px;}
.cli_scanlog{width:100%; box-sizing: border-box; height:auto; float: left; padding:10px; background: #fff; display: none;}

.cli_progress_bar{ width:100%; box-sizing: border-box; background: #f1f1f1; height:30px; border-radius:10px; }
.cli_progress_bar_inner{float:left; height:30px; width:0%; background:#0085ba; color: #fff; text-align: center; line-height: 30px; border-radius:10px;}
.cli_progress_action_main{width: 100%; padding: 5px 0px;}
.cli_scanner_ajax_log{ margin-top:5px; height: 225px; overflow:auto;}
.cli_scanlog_bar{width:100%; box-sizing: border-box; height:40px; padding-top:10px; float: left; line-height: 30px;}
.cli_stop_scan{ margin-right: 10px; }
.cli_import_popup{ position: fixed; width:300px; height:150px; background:#fff; border:solid 1px #ccc; z-index: 10; left: 50%; top:0; margin-left:-165px; margin-top:40px; padding: 15px; box-shadow: 0px 2px 2px #ccc; }
.cli_existing_cookie_list{ margin:20px 0px; }
.cli_scanbar_staypage{ display: none; }
</style>
<h2><?php _e('Scan cookies', 'webtoffee-gdpr-cookie-consent'); ?></h2>
<div class="cli_scanbar_staypage"><?php _e('Please do not leave this page until the progress bar reaches 100%', 'webtoffee-gdpr-cookie-consent'); ?></div>
<div class="cli_scanbar">
	<div class="cli_infobox">
	<?php 
	if($last_scan)
	{
		_e('Your last scan at', 'webtoffee-gdpr-cookie-consent');
		echo ' '.date('F j, Y g:i a T',$last_scan['created_at']);
		echo ' <a href="'.$result_page_url.'">';
		_e('View result','webtoffee-gdpr-cookie-consent');
		echo '</a>';	
	}else
	{
		_e('You haven\'t performed a site scan yet.', 'webtoffee-gdpr-cookie-consent');
	}
	?>
	</div>
	<div class="clearfix"></div>
	<a class="button-primary pull-right cli_scan_now"><?php _e('Scan Now', 'webtoffee-gdpr-cookie-consent'); ?></a>
</div>
<?php
	$table_head='<tr>
			<th width="50">#</th>
			<th>'.__('Name','webtoffee-gdpr-cookie-consent').'</th>
			<th>'.__('Type','webtoffee-gdpr-cookie-consent').'</th>
			<th>'.__('Category','webtoffee-gdpr-cookie-consent').'</th>
			<th>'.__('Duration','webtoffee-gdpr-cookie-consent').'</th>
		</tr>';
?>
<div class="clearfix"></div>
<div class="cli_existing_cookie_list">
	<h3><?php _e('Cookie List','webtoffee-gdpr-cookie-consent');?></h3>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<?php echo $table_head;?>
		</thead>
		<tbody id="the-list">
		<?php
		if(isset($cookie_list) && is_array($cookie_list) && count($cookie_list)>0)
		{
			$i=0;
			foreach($cookie_list as $list)
			{
				$custom=get_post_custom($list->ID);
				$category=get_the_terms($list->ID,'cookielawinfo-category');
	            $cookie_type = ( isset ( $custom["_cli_cookie_type"][0] ) ) ? $custom["_cli_cookie_type"][0] : '';
	            $cookie_duration = ( isset ( $custom["_cli_cookie_duration"][0] ) ) ? $custom["_cli_cookie_duration"][0] : '';
				$i++;
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $list->post_title;?></td>
					<td><?php echo $cookie_type;?></td>
					<td><?php 
						$cat_arr=array();
						if($category)
						{
							foreach ($category as $value) 
							{
								$cat_arr[]=$value->name;
							}
							echo implode("<br />",$cat_arr);	
						}
					?></td>
					<td><?php echo $cookie_duration;?></td>
				</tr>
				<?php
			}
		}else
		{
			?>
			<tr class="no-items"><td class="colspanchange" colspan="5"><?php _e('Your cookie list is empty','webtoffee-gdpr-cookie-consent');?></td></tr>
			<?php
		}
		?>
		</tbody>
		<tfoot>
			<?php echo $table_head;?>
		</tfoot>
	</table>
</div>

</div>