<?php
/**
 * Template Name: iFrame Form
 *
 */

get_header('form'); ?>

<div id="join_now">
	<div class="join_top">
		<img src="<?php echo bloginfo('template_url'); ?>/images/rv_silver_logo_icon.png" />
		<p>Sign up for special offers and decorating ideas!</p>
	</div>
	<?php gravity_form( 3, false, false, false, null, true, $tabindex, true ); ?>
</div>

<form id="joinForm" name="joinForm" method="post" action="http://media.peer360.com/iconix/iconixpost.asp">
	<input type="hidden" name="subject" value="Royal Velvet Website Submissions">
	<input type="hidden" name="List__ID" value="1010">
	<input type="hidden" name="Customer__ID" value="BN0mEHbhW1Cm2B2Un4to">
	<input type="hidden" name="Next__URL" value="<?php echo get_bloginfo('home'); ?>/thanks/">
	<input type="hidden" name="lead_source" value="P360_Sub">
	<input type="hidden" name="dob" id="dob" value="">
	<input type="hidden" name="name" id="name" value="">
	<input type="hidden" name="address" id="address" value="">
	<input type="hidden" name="email" id="email" value="">
	<input type="checkbox" name="optin" id="optin" checked="checked" value="yes">
	<input type="checkbox" name="agree" id="agree" value="">
	<input type="submit">
</form>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).bind('gform_confirmation_loaded', function(event, formId) {
			//document.cookie = "form=true; expires=Thu, 18 Dec 2020 12:00:00 UTC";
			if(formId === 3) {
				$('#joinForm').trigger('submit');
			}
		});

		var name = $('#name'),
			email = $('#email'),
			address = $('#address'),
			dob = $('#dob'),
			optin = $('#optin'),
			agree = $('#agree');

		$('#input_3_1').change(function(){
			name.val($(this).val());
		});

		$('#input_3_2').change(function(){
			email.val($(this).val());
		});

		$('#input_3_3').change(function(){
			address.val($(this).val());
		});

		$('#input_3_4').change(function(){
			dob.val($(this).val());
		});

		$('#choice_3_5_1').change(function(){
			if($(this).is(':checked')) {
				optin.val('yes');
			} else {
				optin.val('no');
			}
		});

		$('#choice_3_6_1').change(function(){
			if($(this).is(':checked')) {
				agree.val('yes');
			} else {
				agree.val('no');
			}
		});
	});

</script>

<?php get_footer('form'); ?>
