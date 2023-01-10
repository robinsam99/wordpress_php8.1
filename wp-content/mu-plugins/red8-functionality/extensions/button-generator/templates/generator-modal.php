<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
?>
<script>
	jQuery(document).ready(function($) {
		
		var windowWidthResized;
		var windowWidth = $(window).width();
		
		$(window).resize(function(){
			windowWidthResized = $(window).width();
			
			if(windowWidthResized > 600) {
				$('.wp_buttonGen').parent().width(753);
			} else if(windowWidthResized <= 782) {
				$('.wp_buttonGen').parent().width(windowWidthResized - 50);
				$('.wp_buttonGen').parent().height(1105);
			}
		});
		
		if(windowWidth >= 600) {
			$('.add_button_button').click(function(){
				setTimeout(function(){
					$('.wp_buttonGen').parent().width(753);
				}, 50);
			});
		} else {
			$('.add_button_button').click(function(){
				setTimeout(function(){
					$('.wp_buttonGen').parent().width(windowWidthResized - 50);
					$('.wp_buttonGen').parent().height(1105);
				}, 50);
			});
		}
		
		$('html, body').click(function(e){
			$('.colorpicker').parent().fadeOut(0);
		});
		
		$('#backgroundColorPicker, #textColorPicker, #previewColorPicker, #colorpickerHolder1, #colorpickerHolder2, #colorpickerHolder3, .colorpicker, .colorpicker_hue > div').click(function(e){
			e.stopPropagation();
		});
		
		$('#paddingTopBottom, #paddingLeftRight, #borderRadius').bind('keyup mouseup', function(){
			previewButton();
		});
		
		var backgroundColorPickerInput = $('#backgroundColorPicker');
        var backgroundColor = backgroundColorPickerInput.val();
        var textColorInput = $('#textColorPicker');
        var previewColorInput = $('#previewColorPicker');
        var textColor = textColorInput.val();
        var alignment;
        var external = false;
        var buttonLink;
        
        alignment = $('.alignActive').attr('data-alignment');
        
        $('.BGAlign').click(function(){
	        $('.BGAlign').removeClass('alignActive');
	        $(this).addClass('alignActive');
	        
	        alignment = $('.alignActive').attr('data-alignment');
	        previewButton();
        });
        
        $('#internalLink').change(function(){
			buttonLink = $(this).val();
			if(buttonLink != 'Choose from a post or a page') {
				$('#buttonLink').attr('value', buttonLink);
			} else {
				$('#buttonLink').attr('value', '');
			}
		});
		
		$('#buttonText').change(function(){
			var btnText = $(this).val();
			
			$('.wp_button_generator_button > a').text(btnText);
		});
		
        $('#isExternal').change(function(e){
            e.stopPropagation();
            external = !external;
            
            if(!external) {
	            $('.externalWrap').css('display', 'none');
				$('.newTabWrap').css('display', 'block');
            } else {
	            $('.externalWrap').css('display', 'block');
				$('.newTabWrap').css('display', 'none');
            }
        });
        
        function previewButton() {
	        var newTab = $('#newTab:checked');
        	var isExternal = $('#isExternal:checked');
        	var buttonText = $('#buttonText').val();
        	var backgroundColorPickerInput = $('#backgroundColorPicker');
            var backgroundColor = backgroundColorPickerInput.val();
            var textColorInput = $('#textColorPicker');
            var textColor = $('#textColorPicker').val();
            var paddingTopBottom = $('#paddingTopBottom').val() + 'px';
            var paddingLeftRight = $('#paddingLeftRight').val() + 'px';
            var borderRadius = $('#borderRadius').val() + 'px';
            var alignment = $('.alignActive').attr('data-alignment');
        	
        	if(newTab.length == 0) {
            	var target = "target='_self'";
        	} else {
            	var target = "target='_blank'";
        	}
        	
        	var buttonHtml = "<div class=\"wp_button_generator_button\" style=\"text-align: " + alignment + ";\"><a href=\"" + buttonLink + "\" style=\"padding: " + paddingTopBottom + ' ' + paddingLeftRight + "; color: " + textColor + "; background-color: " + backgroundColor + "; border-radius: " + borderRadius + "; text-decoration: none; display: inline-block; \">" + buttonText + "</a></div>";
        	
        	$('.button_preview').empty();
        	$('.button_preview').append(buttonHtml);
        
        }
		
        function insertButton() {
        	var newTab = $('#newTab:checked');
        	var isExternal = $('#isExternal:checked');
        	var buttonText = $('#buttonText').val();
        	var backgroundColorPickerInput = $('#backgroundColorPicker');
            var backgroundColor = backgroundColorPickerInput.val();
            var textColorInput = $('#textColorPicker');
            var textColor = $('#textColorPicker').val();
            var paddingTopBottom = $('#paddingTopBottom').val() + 'px';
            var paddingLeftRight = $('#paddingLeftRight').val() + 'px';
            var borderRadius = $('#borderRadius').val() + 'px';
            var alignment = $('.alignActive').attr('data-alignment');
            var buttonLink = $('#buttonLink').val();
        	
        	if(newTab.length == 0) {
            	var target = "target='_self'";
        	} else {
            	var target = "target='_blank'";
        	}
        	
        	if(buttonLink.substr(0, 7) != 'http://') {
	        	buttonLink = 'http://' + buttonLink;
        	}
        	
        	var button = '[button alignment="' + alignment + '" link="' + buttonLink + '" target="' + target + '" border_radius="' + borderRadius + '" background_color="' + backgroundColor + '" padding="' + paddingTopBottom + ' ' + paddingLeftRight + '" text_color="' + textColor + '"]' + buttonText + '[/button]';
        	
        	window.send_to_editor(button);
        }
        
        $('.add_button_button').click(function(){
            setTimeout(function(){
	            $('#TB_window').css('overflow-y', 'scroll');
	        }, 500);
        });
        
        $('#backgroundColorPicker').click(function(){
	        $('#colorpickerHolder3').fadeOut(0);
	        $('#colorpickerHolder2').fadeOut(0);
            $('#colorpickerHolder1').fadeIn(500);
        });
        
        $('#textColorPicker').click(function(){
	        $('#colorpickerHolder1').fadeOut(0);
	        $('#colorpickerHolder3').fadeOut(0);
            $('#colorpickerHolder2').fadeIn(500);
        });
        
        $('#previewColorPicker').click(function(){
	       $('#colorpickerHolder1').fadeOut(0);
            $('#colorpickerHolder2').fadeOut(0);
            $('#colorpickerHolder3').fadeIn(500);
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
			onHide: function(colpkr) {
				$(colpkr).fadeOut(0);
				return false;
			},
			onChange: function(hsb, hex, rgb, el) {
				$(backgroundColorPickerInput).val('#' + hex);
				$('#wp_BG_colorPreviewBg').css('background-color', '#' + hex);
				$('.wp_button_generator_button > a').css('background-color', '#' + hex);
			}
		}).bind('keyup', function(){
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
			onShow: function(colpkr) {
				$(colpkr).fadeIn(500);
				return false;	
			},
			onHide: function(colpkr) {
				$(colpkr).fadeOut(0);
				return false;
			},
			onChange: function(hsb, hex, rgb, el) {
				$(textColorInput).val('#' + hex);
				$('#wp_BG_color_previewTxt').css('background-color', '#' + hex);
				$('.wp_button_generator_button > a').css('color', '#' + hex);
			}
		}).bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value.split('#')[1]);
		});
		
		$('#colorpickerHolder3').ColorPicker({
			flat: true,
			onSubmit: function(hsb, hex, rgb, el) {
				$(previewColorInput).val('#' + hex);
				$('#colorpickerHolder3').fadeOut(0);
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value.split('#')[1]);
			},
			onShow: function(colpkr) {
				$(colpkr).fadeIn(500);
				return false;	
			},
			onHide: function(colpkr) {
				$(colpkr).fadeOut(0);
				return false;
			},
			onChange: function(hsb, hex, rgb, el) {
				$(previewColorInput).val('#' + hex);
				$('#wp_BG_color_previewBG').css('background-color', '#' + hex);
				$('.preview_section').css('background-color', '#' + hex);
			}
		}).bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value.split('#')[1]);
		});
		
		$('.addButton').click(function(){
			insertButton();
		});
		
		$('#bg_previewButton').click(function(){
        	previewButton();
    	});
		
	});
	
</script>

<?php 
	$defaultBGColor = get_option( 'default_bg_color' );
	$defaultTextColor = get_option( 'default_text_color' );
	$defaultPaddingTopBottom = get_option( 'default_padding_top-bottom' );
	$defaultPaddingLeftRight = get_option( 'default_padding_left-right' );
	$defaultButtonAlignment = get_option( 'default_alignment' );
	$defaultBorderRadius = get_option( 'default_border_radius' );
	$defaultPreviewSectionsColor = '#f0f0f0';
?>

<style>
	.wp_buttonGen {
		margin: 0px !important;
	}
	
	.bg_title_space {
		margin-top: 0px;
		margin-bottom: 15px;
	}
	
	.wp_BG_color_preview {
		height: 25px;
		width: 25px;
		content: '';
		float: left;
		border: 1px solid black;
		top: 1px;
		position: relative;
	}
	
	input[type="text"], input[type="number"] {
		margin-bottom: 10px;
		width: 80%;
	}
	
	.preview_section_controls {
		clear: both;
		content: "";
		display: table;
		margin-top: 98px;
		width: 100%;
	}
	
	.preview_section_controls input[type="text"] {
		width: 60%;
	}
	
	.BG_selects {
		margin-bottom: 10px;
		width: 100% !important;
	}
	
	.left_side {
		width: 48.82117%;
		margin-right: 2.35765%;
		float: left;
		display: block;
	}
	
	.right_side {
		width: 48.82117%;
		margin-right: 0;
		float: left;
		display: block;
	}
	
	.preview_section {
		background-color: #f0f0f0;
		padding: 15px;
	}
	
	.preview_section h3 {
		margin-top: 0px;
	}
	
	.preview_section p {
		margin-bottom: 20px;
	}
	
	.button_options, .button_styles {
		width: 100%;
		display: block;
		clear: both;
	}
	
	.button_options {
		margin-bottom: 20px;
	}
	
	.button_options:after, button_styles:after {
		clear: both;
		content: "";
		display: table;
	}
	
	.add_button_button .dashicons-admin-settings {
		top: 2px;
		position: relative;
	}
	
	#colorpickerHolder1, #colorpickerHolder2, #colorpickerHolder3 {
		margin-top: 10px;
		margin-bottom: 10px;
		display: none;
	}
	
	#colorpickerHolder1 p, #colorpickerHolder2 p, #colorpickerHolder3 p {
		display: inline-block;
		margin: 0;
	}
	
	.colorpicker_hue {
		cursor: crosshair !important;
	}
	
	.newTabLabel, .isExternalLabel {
		display: block !important;
		float: left;
		margin-right: 10px;
	}
	
	#bg_previewButton {
		margin-top: 20px;
	}
	
	#backgroundColorPicker, #textColorPicker, #previewColorPicker {
		float: left;
		margin-right: 5px;
	}
	
	#wp_BG_colorPreviewBg {
		background-color: <?php if($defaultBGColor) { echo $defaultBGColor; } else { echo '#ffffff'; } ?>
	}
	
	#wp_BG_color_previewTxt {
		background-color: <?php if($defaultTextColor) { echo $defaultTextColor; } else { echo '#ffffff'; } ?>
	}
	
	#wp_BG_color_previewBG { 
		background-color: <?php echo $defaultPreviewSectionsColor; ?>
	}
	
	.addButton {
		display: block !important;
		margin-top: 20px !important;
		float: left;
		margin-right: 10px !important;
	}
	
	.BG_button_container {
		width: 100%;
		clear: both;
		display: inline-block;
		margin-top: 0px;
	}
	
	#bg_previewButton {
		float: left;
	}
	
	.alignActive {
		color: red !important;
	}
	
	.BG_align_left {
		font-size: 25px;
		margin-right: 20px;
		height: 25px;
		width: 25px;
	}
	
	.BG_align_center {
		font-size: 25px;
		margin-right: 20px;
		height: 25px;
		width: 25px;
	}
	
	.BG_align_right {
		font-size: 25px;
		height: 25px;
		width: 25px;
	}
	
	@media screen and (max-width: 782px) {
		
		.add_button_button .dashicons-admin-settings {
			top: 6px;
			font-size: 25px;
			left: -6px;
		}
		
	}
	
	@media screen and (max-width: 600px) {
		
		.left_side {
			width: 100%;
			margin-right: 2.35765%;
			float: left;
			display: block;
		}
		
		.right_side {
			width: 100%;
			margin-right: 2.35765%;
			float: left;
			display: block;
		}
		
		.preview_section {
			width: 80%;
		}
		
		.preview_section_controls {
			margin-top: 15px;
		}
		
		.BG_selects {
			width: 80% !important;
		}
		
		.BG_h4 {
			display: inline-block;
		}
		
		#colorpickerHolder1, #colorpickerHolder2, #colorpickerHolder3 {
			margin-top: 60px;
			width: 360px;
		}
		
	}
	
	
</style>

<div id="select_button_attributes" style="display:none; overflow-y: scroll;">
    <div class="wrap wp_buttonGen">
		<div class="left_side">
			<div class="button_options">
				<h3>Button Options</h3>
				<div class="left_side">
					<h4>Enter a custom URL</h4>
					<input class="externalWrap" type="text" id="buttonLink" value="" />
					<h4>Button Text</h4>
					<input type="text" id="buttonText" value="Preview" />
				</div>
				<div class="right_side">
					<h4>OR Link to existing content</h4>
					<select class="newTabWrap BG_selects" id="internalLink" value="">
						<option>Choose from a post or a page</option>
						<option disabled>--- Posts ---</option>
						<?php
							$args = array(
								'post_type' => 'post',
								'posts_per_page' => -1,
								'orderby' => 'title',
								'order' => 'ASC'
							);
						
							$posts = new WP_Query($args);
						
							while( $posts->have_posts() ) : $posts->the_post();
						?>
							<option value="<?php the_permalink(); ?>"><?php the_title(); ?></option>
						<?php endwhile; ?>
							<option disabled>--- Pages ---</option>
						<?php
							$args = array(
								'post_type' => 'page',
								'posts_per_page' => -1,
								'orderby' => 'title',
								'order' => 'ASC'
							);
						
							$pages = new WP_Query($args);
						
							while( $pages->have_posts() ) : $pages->the_post();
						?>
							<option value="<?php the_permalink(); ?>"><?php the_title(); ?></option>
						<?php endwhile; ?>
					</select>
					<h4>Open in new tab/window</h4>
					<input id="newTab" type="checkbox" />
				</div>
			</div>
			<div class="button_styles">
				<h3>Button Styles</h3>
				<div class="left_side">
					<h4>Background Color</h4>
					<input type="text" id="backgroundColorPicker" value="<?php if($defaultBGColor) { echo $defaultBGColor; } ?>" />
					<div id="wp_BG_colorPreviewBg" class="wp_BG_color_preview"></div>
					<div id="colorpickerHolder1">
						<p>Click away from color picker to close.</p>
					</div>
					<h4 class="BG_h4">Padding Top / Bottom</h4>
					<input type="number" id="paddingTopBottom" value="<?php if($defaultPaddingTopBottom) { echo $defaultPaddingTopBottom; } ?>" />
					<h4>Border Radius</h4>
					<input id="borderRadius" type="number" name="default_border_radius" value="<?php if($defaultBorderRadius) { echo $defaultBorderRadius; } ?>" />
				</div>
				<div class="right_side">
					<h4>Text Color</h4>
					<input type="text" id="textColorPicker" value="<?php if($defaultTextColor) { echo $defaultTextColor; } ?>" />
					<div id="wp_BG_color_previewTxt" class="wp_BG_color_preview"></div>
					<div id="colorpickerHolder2">
						<p>Click away from color picker to close.</p>
					</div>
					<h4 class="BG_h4">Padding Left / Right</h4>
					<input type="number" id="paddingLeftRight" value="<?php if($defaultPaddingLeftRight) { echo $defaultPaddingLeftRight; } ?>" />
					<h4>Button Alignment</h4>
					<div class="button_alignment">
						<div data-alignment="left" class="BGAlign <?php if($defaultButtonAlignment === 'left') { echo 'alignActive'; } ?> BG_align_left dashicons dashicons-editor-alignleft"></div>
						<div data-alignment="center" class="BGAlign <?php if($defaultButtonAlignment === 'center') { echo 'alignActive'; } ?> BG_align_center dashicons dashicons-editor-aligncenter"></div>
						<div data-alignment="right" class="BGAlign <?php if($defaultButtonAlignment === 'right') { echo 'alignActive'; } ?> BG_align_right dashicons dashicons-editor-alignright"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="right_side">
			<div class="preview_section">
				<h3>Preview Button</h3>
				<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Curabitur blandit tempus porttitor.</p>
				<div class="button_preview">
					<div class="wp_button_generator_button" style="text-align: <?php echo $defaultButtonAlignment; ?>;">
						<a href="#" style="padding: <?php echo $defaultPaddingTopBottom; ?>px <?php echo $defaultPaddingLeftRight; ?>px; color: <?php echo $defaultTextColor; ?>; background-color: <?php echo $defaultBGColor; ?>; border-radius: <?php echo $defaultBorderRadius; ?>px; text-decoration: none; display: inline-block;">Preview</a>
					</div>
				</div>
			</div>
			<div class="preview_section_controls">
				<h4>Preview Background Color</h4>
				<input type="text" id="previewColorPicker" value="<?php echo $defaultPreviewSectionsColor; ?>" />
				<div id="wp_BG_color_previewBG" class="wp_BG_color_preview"></div>
				<div id="colorpickerHolder3">
					<p>Click away from color picker to close.</p>
				</div>
			</div>
		</div>
		<div class="BG_button_container">
			<input type="button" class="addButton button button-primary" value="Insert Button" />
		</div>
    </div>
</div>