jQuery(document).ready(function($) {
		
	$(".acf-field-object-gravity-forms-field .acf-field-radio[data-name='return_format'] input[type=\"radio\"]").each(function(e) {
		if($(this).is(':checked')) {
			var fieldID = $(this).attr('name').replace('acf_fields[', '').replace('][return_format]', '');
			if($(this).val() == 'id') {
				hideFormOptions(fieldID);
			} else {
				showFormOptions(fieldID);
			}
		}
	});
	
	$(".acf-field-object-gravity-forms-field .acf-field-radio[data-name='return_format'] input[type=\"radio\"]").change(function(e) {
		var fieldID = $(this).attr('name').replace('acf_fields[', '').replace('][return_format]', '');
		
		if(this.value == 'id') {
			hideFormOptions(fieldID);
		} else {
			showFormOptions(fieldID);
		}
	});
	
	function hideFormOptions(fieldID) {
		$(".acf-field-object-gravity-forms-field[data-id='"+fieldID+"'] .acf-field-radio[data-name='show_title']").css('display', 'none');
		$(".acf-field-object-gravity-forms-field[data-id='"+fieldID+"'] .acf-field-radio[data-name='show_description']").css('display', 'none');
		$(".acf-field-object-gravity-forms-field[data-id='"+fieldID+"'] .acf-field-radio[data-name='should_ajax']").css('display', 'none');
	}
	
	function showFormOptions(fieldID) {
		$(".acf-field-object-gravity-forms-field[data-id='"+fieldID+"'] .acf-field-radio[data-name='show_title']").css('display', 'table-row');
		$(".acf-field-object-gravity-forms-field[data-id='"+fieldID+"'] .acf-field-radio[data-name='show_description']").css('display', 'table-row');
		$(".acf-field-object-gravity-forms-field[data-id='"+fieldID+"'] .acf-field-radio[data-name='should_ajax']").css('display', 'table-row');
	}
});