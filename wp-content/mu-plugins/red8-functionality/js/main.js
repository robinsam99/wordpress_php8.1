jQuery(document).ready(function($) {

	$('input[type="checkbox"]').change(function(e) {
		window.onbeforeunload = confirmOnPageExit;
	});
	
	$('#red8_func_plugin_auto_update').change(function(e) {
		window.onbeforeunload = confirmOnPageExit;
		
		if(this.value == 'individual') {
			$('.individual_plugin_update_settings').css('display', 'table');
		} else {
			$('.individual_plugin_update_settings').css('display', 'none');
		}
	});
	
	var toggle = false;
	$('.red8_func_auto_update_toggle').click(function(e) {
		e.preventDefault();
		window.onbeforeunload = confirmOnPageExit;
		
		$('.individual_plugin_update_settings input[type="checkbox"]').attr('checked', toggle);
		toggle = !toggle;
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