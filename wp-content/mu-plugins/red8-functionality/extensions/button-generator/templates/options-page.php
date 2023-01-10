<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
?>

<style>
	#colorpickerHolder1 {
		margin-top: 10px;
		margin-bottom: 10px;
		display: none;
	}
	
	#colorpickerHolder2 {
		margin-top: 10px;
		margin-bottom: 20px;
		display: none;
	}
	
	.colorpicker_hue {
		cursor: crosshair !important;
	}
</style>

<script>
	jQuery(document).ready(function($) {
		
		var backgroundColorPickerInput = $('#backgroundColorPicker');
        var backgroundColor = backgroundColorPickerInput.val();
        var textColorInput = $('#textColorPicker');
        var textColor = textColorInput.val();
        
        $('#backgroundColorPicker').focus(function(){
            $('#colorpickerHolder1').fadeIn(500);
        });
        
        $('#textColorPicker').focus(function(){
            $('#colorpickerHolder2').fadeIn(500);
        });
		          
		$('#colorpickerHolder1').ColorPicker({
			flat: true,
			onSubmit: function(hsb, hex, rgb, el) {
				$(backgroundColorPickerInput).val('#' + hex);
				$('#colorpickerHolder1').fadeOut(0);
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value.split('#')[1]);
			},
			onChange: function(hsb, hex, rgb, el) {
				$(backgroundColorPickerInput).val('#' + hex);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value.split('#')[1]);
		});
		
		$('#colorpickerHolder2').ColorPicker({
			flat: true,
			onSubmit: function(hsb, hex, rgb, el) {
				$(textColorInput).val('#' + hex);
				$('#colorpickerHolder2').fadeOut(0);
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value.split('#')[1]);
			},
			onChange: function(hsb, hex, rgb, el) {
				$(textColorInput).val('#' + hex);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value.split('#')[1]);
		});
		
		$('input[type="number"], select').change(function(e) {
			window.onbeforeunload = confirmOnPageExit;
		});
		
		$('input[type="text"]').on('input', function(e) {
			window.onbeforeunload = confirmOnPageExit;
		});
	});

	var confirmOnPageExit = function (e) {
	    e = e || window.event;
	
	    var message = 'The changes you made will be lost if you navigate away from this page';
	
	    if (e) {
	        e.returnValue = message;
	    }
	
	    return message;
	};
	
</script>

<div class="wrap">
	<h2>Button Generator Settings</h2>
	<?php if(isset($_GET['updated']) && $_GET['updated'] == 'true') : ?>
		<div class="message updated">
			<p>Settings Saved Successfully</p>
		</div>
	<?php endif; ?>
	<form method="post" action="<?php echo get_admin_url(); ?>admin-post.php" onSubmit="window.onbeforeunload = null;">
		<?php 
			settings_fields( 'wp_button_generator' );
			do_settings_sections( 'wp_button_generator' );
			$defaultBGColor = get_option( 'default_bg_color' );
			$defaultTextColor = get_option( 'default_text_color' );
			$defaultPaddingTopBottom = get_option( 'default_padding_top-bottom' );
			$defaultPaddingLeftRight = get_option( 'default_padding_left-right' );
			$defaultButtonAlignment = get_option( 'default_alignment' );
			$defaultBorderRadius = get_option( 'default_border_radius' );
		?>
		<table>
			<tbody>
				<tr>
		            <td><h3>Default Values</h3></td>
		        </tr>
				<tr>
	            	<td><label>Default Button Background Color</label></td>
					<td><input type="text" id="backgroundColorPicker" name="default_bg_color" value="<?php if($defaultBGColor) { echo $defaultBGColor; } ?>" /></td>
				</tr>
				<tr>
					<td></td>
		            <td><div id="colorpickerHolder1"></div></td>
		        </tr>
				<tr>
		            <td><label>Default Button Text Color</label>
		            <td><input type="text" id="textColorPicker" name="default_text_color" value="<?php if($defaultTextColor) { echo $defaultTextColor; } ?>" /></td>
		        </tr>
		        <tr>
			        <td></td>
		            <td><div id="colorpickerHolder2"></div></td>
		        </tr>
				<tr>
		            <td><label>Default Button Alignment</label>
		            <td><select id="buttonAlignment" name="default_alignment" value="<?php echo $defaultButtonAlignment; ?>">
		                <option value="left" <?php if($defaultButtonAlignment == 'left') { echo 'selected'; } ?>>Left</option>
		                <option value="center" <?php if($defaultButtonAlignment == 'center') { echo 'selected'; } ?>>Center</option>
		                <option value="right" <?php if($defaultButtonAlignment == 'right') { echo 'selected'; } ?>>Right</option>
		            </select></td>
		        </tr>
				<tr>
		            <td><label>Default Border Radius</label></td>
		            <td><input type="number" name="default_border_radius" value="<?php if($defaultBorderRadius) { echo $defaultBorderRadius; } ?>" /></td>
		        </tr>
				<tr>
		            <td><h3>Default Padding Values</h3></td>
		        </tr>
				<tr>
					<td><label>Top/Bottom Value (px)</label></td>
					<td><input type="number" name="default_padding_top-bottom" value="<?php if($defaultPaddingTopBottom) { echo $defaultPaddingTopBottom; } ?>" /></td>
				</tr>
				<tr>
					<td><label>Left/Right Value (px)</label></td>
					<td><input type="number" name="default_padding_left-right" value="<?php if($defaultPaddingLeftRight) { echo $defaultPaddingLeftRight; } ?>" /></td>
				</tr>
    		</tbody>
		</table>
		<?php submit_button('Save Changes', 'primary', 'update_button_settings'); ?>
		<input type="hidden" name="action" value="update_button_settings">
	</form>
</div>