jQuery(document).ready(function($) {
	
	$('#speed_bump_text').change(function(e) {
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