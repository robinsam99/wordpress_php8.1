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
	
	.colorpicker_hue {
		cursor: crosshair !important;
	}
</style>

<script>
	jQuery(document).ready(function($) {
		
		var backgroundColorPickerInput = $('#page_jump_background_color');
        var backgroundColor = backgroundColorPickerInput.val();
        
        $('#page_jump_background_color').focus(function(){
            $('#colorpickerHolder1').fadeIn(500);
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
	<h2>Page Jump Settings</h2>
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
						<label for="page_jump_background_color">Background Color</label>
					</th>
					<td>
						<input name="page_jump_background_color" type="text" id="page_jump_background_color" value="<?php echo get_option(RED8_FUNCTIONALITY_PAGE_JUMP_BG_COLOR, '#000'); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<td></td>
		            <td><div id="colorpickerHolder1"></div></td>
		        </tr>
		        <tr>
					<th scope="row">
						<label for="page_jump_border_radius">Border Radius (%)</label>
					</th>
					<td>
						<input name="page_jump_border_radius" type="number" id="page_jump_border_radius" min="0" max="100" value="<?php echo get_option(RED8_FUNCTIONALITY_PAGE_JUMP_BORDER_RADIUS, 50); ?>" class="regular-text">
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button('Update', 'primary', 'update_page_jump_settings'); ?>
		<input type="hidden" name="action" value="update_page_jump_settings">
	</form>
</div>