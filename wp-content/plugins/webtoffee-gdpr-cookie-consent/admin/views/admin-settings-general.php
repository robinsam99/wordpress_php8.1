<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>
<div class="cookie-law-info-tab-content" data-id="<?php echo $target_id;?>">
	<ul class="cli_sub_tab">
		<li style="border-left:none; padding-left: 0px;" data-target="cookie-bar"><a><?php _e('Cookie Bar','webtoffee-gdpr-cookie-consent');?></a></li>
		<li data-target="show-again"><a><?php _e('Show Again Tab','webtoffee-gdpr-cookie-consent');?></a></li>
		<li data-target="other"><a><?php _e('Other','webtoffee-gdpr-cookie-consent');?></a></li>
	</ul>
	<div class="cli_sub_tab_container">		
		<div class="cli_sub_tab_content" data-id="cookie-bar" style="display:block;">
			<h3><?php _e('Cookie Bar','webtoffee-gdpr-cookie-consent');?></h3>
			<table class="form-table">
			    <tr valign="top">
			        <th scope="row" style="width: 260px;"><label for="is_on_field"><?php _e('Cookie Bar is currently:', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="radio" id="is_on_field_yes" name="is_on_field" class="styled cli_bar_on" value="true" <?php echo ( $the_options['is_on'] == true ) ? ' checked="checked"' : ''; ?> /><?php _e('On', 'webtoffee-gdpr-cookie-consent'); ?>
			            <input type="radio" id="is_on_field_no" name="is_on_field" class="styled" value="false" <?php echo ( $the_options['is_on'] == false ) ? ' checked="checked" ' : ''; ?> /><?php _e('Off', 'webtoffee-gdpr-cookie-consent'); ?>
			        </td>
			    </tr>
			    
			    <tr valign="top">
			        <th scope="row"><label for="is_eu_on_field"><?php _e('Show only for EU Countries ( GeoIP )', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="radio" id="is_eu_on_field_yes" name="is_eu_on_field" class="styled" value="true" <?php echo ( $the_options['is_eu_on'] == true ) ? ' checked="checked"' : ''; ?> /> <?php _e('On', 'webtoffee-gdpr-cookie-consent'); ?>
			            <input type="radio" id="is_eu_on_field_no" name="is_eu_on_field" class="styled" value="false" <?php echo ( $the_options['is_eu_on'] == false ) ? ' checked="checked"' : ''; ?> /> <?php _e('Off', 'webtoffee-gdpr-cookie-consent'); ?>                                           
			        </td>
			    </tr>


			    <tr valign="top">
			        <th scope="row"><label for="cookie_bar_as_field"><?php _e('Cookie bar as', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <select name="cookie_bar_as_field" class="vvv_combobox cli_form_toggle" cli_frm_tgl-target="cli_bar_type">
			            	<?php
			            	$cookie_bar_as=$the_options['cookie_bar_as'];
			            	?>
			                <option value="banner" <?php echo $cookie_bar_as=='banner' ? 'selected' : ''; ?>>
			                <?php _e('Banner', 'webtoffee-gdpr-cookie-consent'); ?>
			            	</option>
			                <option value="popup" <?php echo $cookie_bar_as=='popup' ? 'selected' : ''; ?>>
			                <?php _e('Popup', 'webtoffee-gdpr-cookie-consent'); ?>
			            	</option>
			                <option value="widget" <?php echo $cookie_bar_as=='widget' ? 'selected' : ''; ?>>
			                <?php _e('Widget', 'webtoffee-gdpr-cookie-consent'); ?>
			            	</option>
			            </select>
			        </td>
			    </tr>
			    <tr valign="top" cli_frm_tgl-id="cli_bar_type" cli_frm_tgl-val="widget">
				    <th scope="row"><label for="widget_position_field"><?php _e('Position', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
				    <td>
						<?php $widget_position=$the_options['widget_position'];?>
						<select name="widget_position_field" id="widget_position_field" class="vvv_combobox">
							<option value="left" <?php echo $widget_position=='left' ? 'selected' : ''; ?>>Left</option>
							<option value="right" <?php echo $widget_position=='right' ? 'selected' : ''; ?>>Right</option>
						</select>
				    </td>
				</tr>
				<tr valign="top" cli_frm_tgl-id="cli_bar_type" cli_frm_tgl-val="popup">
				    <th scope="row"><label for="popup_overlay_field"><?php _e('Add overlay?', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
				    <td>
				        <input type="radio" id="popup_overlay_field_yes" name="popup_overlay_field" class="styled" value="true" <?php echo ( $the_options['popup_overlay'] == true ) ? ' checked="checked"' : ''; ?> /> <?php _e('Yes', 'webtoffee-gdpr-cookie-consent'); ?>
				        <input type="radio" id="popup_overlay_field_no" name="popup_overlay_field" class="styled" value="false" <?php echo ( $the_options['popup_overlay'] == false ) ? ' checked="checked"' : ''; ?> /> <?php _e('No', 'webtoffee-gdpr-cookie-consent'); ?>
				        <span class="cli_form_help"><?php _e('When the popup is active, an overlay will block the user from browsing the site.', 'webtoffee-gdpr-cookie-consent'); ?></span>
				        <span class="cli_form_er cli_scroll_accept_er"><?php _e('`Accept on scroll` will not work along with this option.', 'webtoffee-gdpr-cookie-consent'); ?></span>
				    </td>
				</tr>
				<tr valign="top" cli_frm_tgl-id="cli_bar_type" cli_frm_tgl-val="banner" cli_frm_tgl-lvl="1">
				    <th scope="row"><label for="notify_position_vertical_field"><?php _e('Cookie Bar will be shown in:', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
				    <td>
				        <select name="notify_position_vertical_field" class="vvv_combobox cli_form_toggle" cli_frm_tgl-target="cli_bar_pos">
				            <?php
				            if ($the_options['notify_position_vertical'] == "top") 
				            {
				                echo '<option value="top" selected="selected">' . __('Header', 'webtoffee-gdpr-cookie-consent') . '</option>';
				                echo '<option value="bottom">' . __('Footer', 'webtoffee-gdpr-cookie-consent') . '</option>';
				            } else {
				                echo '<option value="top">' . __('Header', 'webtoffee-gdpr-cookie-consent') . '</option>';
				                echo '<option value="bottom" selected="selected">' . __('Footer', 'webtoffee-gdpr-cookie-consent') . '</option>';
				            }
				            ?>
				        </select>
				    </td>
				</tr>
				<!-- header_fix code here -->
				<tr valign="top" cli_frm_tgl-id="cli_bar_type" cli_frm_tgl-val="banner" cli_frm_tgl-lvl="1">
					<td colspan="2" style="padding: 0px;">
					<table>
						<tr valign="top" cli_frm_tgl-id="cli_bar_pos" cli_frm_tgl-val="top" cli_frm_tgl-lvl="2">
						    <th scope="row" style="width:260px;">
						    	<label for="header_fix_field"><?php _e('Fix Cookie Bar to Header?', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
						    <td>
						        <input type="radio" id="header_fix_field_yes" name="header_fix_field" class="styled" value="true" <?php echo ( $the_options['header_fix'] == true ) ? ' checked="checked"' : ''; ?> /> <?php _e('Yes', 'webtoffee-gdpr-cookie-consent'); ?>
						        <input type="radio" id="iheader_fix_field_no" name="header_fix_field" class="styled" value="false" <?php echo ( $the_options['header_fix'] == false ) ? ' checked="checked"' : ''; ?> /> <?php _e('No', 'webtoffee-gdpr-cookie-consent'); ?>
						        <span class="cli_form_help"><?php _e('If you select "Header" then you can optionally stick the cookie bar to the header. Will not have any effect if you select "Footer".', 'webtoffee-gdpr-cookie-consent'); ?></span>
						    </td>
						</tr>
					</table>
					</td>
				</tr>
				<!-- /header_fix -->

			    <tr valign="top">
			        <th scope="row"><label for="notify_animate_show_field"><?php _e('On load', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <select name="notify_animate_show_field" class="vvv_combobox">
			                <?php
			                if ($the_options['notify_animate_show'] == true) {
			                    echo '<option value="true" selected="selected">' . __('Animate', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                    echo '<option value="false">' . __('Sticky', 'webtoffee-gdpr-cookie-consent') . '</option>';
							}
							else {
			                    echo '<option value="true">' . __('Animate', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                    echo '<option value="false" selected="selected">' . __('Sticky', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                }
			                ?>
			            </select>
			        </td>
			    </tr>
			    <tr valign="top">
			        <th scope="row"><label for="notify_animate_hide_field"><?php _e('On hide', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <select name="notify_animate_hide_field" class="vvv_combobox">
							<?php
							
			                if ($the_options['notify_animate_hide'] == true) {
			                    echo '<option value="true" selected="selected">' . __('Animate', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                    echo '<option value="false">' . __('Disappear', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                } else {
			                    echo '<option value="true">' . __('Animate', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                    echo '<option value="false" selected="selected">' . __('Disappear', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                }
			                ?>
			            </select>
			        </td>
				</tr>
			    <!-- SHOW ONCE / TIMER -->
			    <tr valign="top">
			        <th scope="row"><label for="show_once_yn_field"><?php _e('Auto-hide(Accept) cookie bar after delay?', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="radio" id="show_once_yn_yes" name="show_once_yn_field" class="styled cli_form_toggle" cli_frm_tgl-target="cli_bar_autohide" value="true" <?php echo ( $the_options['show_once_yn'] == true ) ? ' checked="checked"' : ''; ?> /> <?php _e('Yes', 'webtoffee-gdpr-cookie-consent'); ?>
			            <input type="radio" id="show_once_yn_no" name="show_once_yn_field" class="styled cli_form_toggle" cli_frm_tgl-target="cli_bar_autohide" value="false" <?php echo ( $the_options['show_once_yn'] == false ) ? ' checked="checked"' : ''; ?> /> <?php _e('No', 'webtoffee-gdpr-cookie-consent'); ?>
			        </td>
			    </tr>
			    <tr valign="top" cli_frm_tgl-id="cli_bar_autohide" cli_frm_tgl-val="true">
			        <th scope="row"><label for="show_once_field"><?php _e('Milliseconds until hidden', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="text" name="show_once_field" value="<?php echo $the_options['show_once'] ?>" />
			            <span class="cli_form_help"><?php _e('Specify milliseconds (not seconds)', 'webtoffee-gdpr-cookie-consent'); ?> e.g. 8000 = 8 <?php _e('seconds', 'webtoffee-gdpr-cookie-consent'); ?></span>
			        </td>
			    </tr>
			    <tr valign="top">
			        <th scope="row"><label for="scroll_close_field"><?php _e('Auto-hide cookie bar if the user scrolls ( Accept on Scroll )?', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="radio" id="scroll_close_yes" name="scroll_close_field" class="styled" value="true" <?php echo ( $the_options['scroll_close'] == true ) ? ' checked="checked"' : ''; ?> /> <?php _e('Yes', 'webtoffee-gdpr-cookie-consent'); ?>
			            <input type="radio" id="scroll_close_no" name="scroll_close_field" class="styled" value="false" <?php echo ( $the_options['scroll_close'] == false ) ? ' checked="checked"' : ''; ?> /> <?php _e('No', 'webtoffee-gdpr-cookie-consent'); ?>
			            <span class="cli_form_help" style="margin-top:8px;"><?php _e('As per latest GDPR policies it is required to take an explicit consent for the cookies. Use this option with discretion especially if you serve EU', 'webtoffee-gdpr-cookie-consent'); ?></span>
			            <span class="cli_form_er cli_scroll_accept_er"><?php _e('This option will not work along with `Popup overlay`.', 'webtoffee-gdpr-cookie-consent'); ?></span>
			        </td>
				</tr>
			</table>
		</div>
		<div class="cli_sub_tab_content" data-id="show-again">
			<h3><?php _e('Show Again Tab','webtoffee-gdpr-cookie-consent');?></h3>
			<table class="form-table">
			    <tr valign="top">
			        <th scope="row"><label for="showagain_tab_field"><?php _e('Use Show Again Tab?', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="radio" id="showagain_tab_field_yes" name="showagain_tab_field" class="styled" value="true" <?php echo ( $the_options['showagain_tab'] == true ) ? ' checked="checked"' : ''; ?> /><?php _e('Yes', 'webtoffee-gdpr-cookie-consent'); ?>
			            <input type="radio" id="showagain_tab_field_no" name="showagain_tab_field" class="styled" value="false" <?php echo ( $the_options['showagain_tab'] == false ) ? ' checked="checked" ' : ''; ?> /> <?php _e('No', 'webtoffee-gdpr-cookie-consent'); ?>
			        </td>
			    </tr>
			    
			    <tr valign="top" cli_frm_tgl-id="cli_bar_type" cli_frm_tgl-val="banner" cli_frm_tgl-lvl="0">
			        <th scope="row"><label for="notify_position_horizontal_field"><?php _e('Tab Position', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <select name="notify_position_horizontal_field" class="vvv_combobox">
			                <?php
			                if ($the_options['notify_position_horizontal'] == "right") {
			                    echo '<option value="right" selected="selected">' . __('Right', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                    echo '<option value="left">' . __('Left', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                } else {
			                    echo '<option value="right">' . __('Right', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                    echo '<option value="left" selected="selected">' . __('Left', 'webtoffee-gdpr-cookie-consent') . '</option>';
			                }
			                ?>
			            </select>
			        </td>
			    </tr>

			    <tr valign="top" cli_frm_tgl-id="cli_bar_type" cli_frm_tgl-val="popup" cli_frm_tgl-lvl="0">
			        <th scope="row"><label for="popup_showagain_position_field"><?php _e('Tab Position', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <select name="popup_showagain_position_field" class="vvv_combobox">
			            	<?php
			            	$pp_sa_pos=$the_options['popup_showagain_position'];
			            	?>
			                <option value="bottom-right" <?php echo $pp_sa_pos=='bottom-right' ? 'selected' : ''; ?>>
			                	<?php _e('Bottom Right', 'webtoffee-gdpr-cookie-consent') ?>
			                </option>
			                <option value="bottom-left" <?php echo $pp_sa_pos=='bottom-left' ? 'selected' : ''; ?>>
			                	<?php _e('Bottom Left', 'webtoffee-gdpr-cookie-consent') ?>			                		
			                </option>
			                <option value="top-right" <?php echo $pp_sa_pos=='top-right' ? 'selected' : ''; ?>>
			                	<?php _e('Top Right', 'webtoffee-gdpr-cookie-consent') ?>
			                </option>
			                <option value="top-left" <?php echo $pp_sa_pos=='top-left' ? 'selected' : ''; ?>>
			                	<?php _e('Top Left', 'webtoffee-gdpr-cookie-consent') ?>
			                </option>
			            </select>
			        </td>
			    </tr>


			    <tr valign="top">
			        <th scope="row"><label for="showagain_x_position_field"><?php _e('From Left Margin', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="text" name="showagain_x_position_field" value="<?php echo $the_options['showagain_x_position'] ?>" />
			            <span class="cli_form_help"><?php _e('Specify', 'webtoffee-gdpr-cookie-consent'); ?> px&nbsp;or&nbsp;&#37;, e.g. "100px" or "30%"</span>
			        </td>
			    </tr>
			    <tr valign="top">
			        <th scope="row"><label for="showagain_text"><?php _e('Show More Text', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="text" name="showagain_text_field" value="<?php echo $the_options['showagain_text'] ?>" />
			        </td>
			    </tr>
			</table>
		</div>
		<div class="cli_sub_tab_content" data-id="other">
			<h3><?php _e('Other','webtoffee-gdpr-cookie-consent');?></h3>
			<table class="form-table">
			    <tr valign="top">
			        <th scope="row"><label for="logging_on_field"><?php _e('Enable consent logging', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="radio" id="logging_on_field_yes" name="logging_on_field" class="styled" value="true" <?php echo ( $the_options['logging_on'] == true ) ? ' checked="checked" />' : ' />'; ?> <?php _e('On', 'webtoffee-gdpr-cookie-consent'); ?>
			                   <input type="radio" id="logging_on_field_no" name="logging_on_field" class="styled" value="false" <?php echo ( $the_options['logging_on'] == false ) ? ' checked="checked" ' : ' '; ?> /><?php _e('Off', 'webtoffee-gdpr-cookie-consent'); ?>
			        </td>
			    </tr>
			    <tr valign="top" class="">
			        <th scope="row"><label for="scroll_close_reload_field"><?php _e('Reload after "scroll accept" event?', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <!-- <input type="text" name="scroll_close_reload_field" value="<?php echo $the_options['scroll_close_reload'] ?>" />
			                <span class="cli_form_help">If the user accepts, do you want to reload the page? This feature is mostly for Italian users who have to deal with a very specific interpretation of the cookie law.</span>
			            -->
			            <input type="radio" id="scroll_close_reload_yes" name="scroll_close_reload_field" class="styled" value="true" <?php echo ( $the_options['scroll_close_reload'] == true ) ? ' checked="checked" ' : ' '; ?> /> <?php _e('Yes', 'webtoffee-gdpr-cookie-consent'); ?>
			            <input type="radio" id="scroll_close_reload_no" name="scroll_close_reload_field" class="styled" value="false" <?php echo ( $the_options['scroll_close_reload'] == false ) ? ' checked="checked" ' : ''; ?> /> <?php _e('No', 'webtoffee-gdpr-cookie-consent'); ?>

			        </td>
			    </tr>
			    <tr valign="top">
			        <th scope="row"><label for="accept_close_reload_field"><?php _e('Reload after Accept button click', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="radio" id="accept_close_reload_yes" name="accept_close_reload_field" class="styled" value="true" <?php echo ( $the_options['accept_close_reload'] == true ) ? ' checked="checked" ' : ''; ?> /><?php _e('Yes', 'webtoffee-gdpr-cookie-consent'); ?>
			            <input type="radio" id="accept_close_reload_no" name="accept_close_reload_field" class="styled" value="false" <?php echo ( $the_options['accept_close_reload'] == false ) ? ' checked="checked" ' : ''; ?> /><?php _e('No', 'webtoffee-gdpr-cookie-consent'); ?>
			        </td>
			    </tr>
			    <tr valign="top">
			        <th scope="row"><label for="reject_close_reload_field"><?php _e('Reload after Reject button click', 'webtoffee-gdpr-cookie-consent'); ?></label></th>
			        <td>
			            <input type="radio" id="reject_close_reload_yes" name="reject_close_reload_field" class="styled" value="true" <?php echo ( $the_options['reject_close_reload'] == true ) ? ' checked="checked" ' : ''; ?> /><?php _e('Yes', 'webtoffee-gdpr-cookie-consent'); ?>
			            <input type="radio" id="reject_close_reload_no" name="reject_close_reload_field" class="styled" value="false" <?php echo ( $the_options['reject_close_reload'] == false ) ? ' checked="checked" ' : ''; ?> /><?php _e('No', 'webtoffee-gdpr-cookie-consent'); ?>
			        </td>
			    </tr>
			</table>
		</div>
	</div>
	<?php 
	include "admin-settings-save-button.php";
	?>
</div>