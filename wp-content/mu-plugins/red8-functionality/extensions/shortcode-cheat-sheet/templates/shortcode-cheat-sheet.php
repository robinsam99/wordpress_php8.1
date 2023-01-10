<?php 
	if ( ! defined( 'ABSPATH' ) ) { 
    	exit; // Exit if accessed directly
	}
?>
<div id="select_shortcode" style="display:none; overflow-y: scroll;">
    <div class="wrap">
		<?php 
			global $shortcode_tags;
			if($shortcode_tags) {
		?>
		<ul>
		<?php foreach($shortcode_tags as $key => $shortcode) { ?>
			<li><a href="#" class="insert_shortcode">[<?php echo $key; ?>]</a></li>
		<?php } ?>
		<ul>
		<?php 
			}
		?>
    </div>
</div>