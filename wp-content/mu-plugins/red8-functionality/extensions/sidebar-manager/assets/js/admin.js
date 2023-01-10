jQuery(document).ready(function($) {
	
	$('#update_sidebar_form, #new_sidebar_form').submit(function (e) {
		$('.name_error').hide();
		var valid = validateForm();
		
		if (valid) {	
			return true;
		} else {
			e.preventDefault();
	    	$('.name_error').show();
	    	$("html, body").animate({ scrollTop: 0 });
		}
	});
	
	function validateForm() {
		
		if ($('input.required_name').val() == "") {
			 return false;
		} else {
			 return true;
		}
	}
	
	
	$('#sidebar_name').focusout(function(e) {
		var sidebar_name = $('#sidebar_name').val().toLowerCase();
		sidebar_name = sidebar_name.replace(' ', '-');
		
		if(!$('#sidebar_id').val().length) {
			$('#sidebar_id').val(sidebar_name);
		}
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