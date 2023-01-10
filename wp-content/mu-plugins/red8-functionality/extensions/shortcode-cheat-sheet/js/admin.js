jQuery(document).ready(function($) {
	$('a.insert_shortcode').click(function(e) {
		e.preventDefault();
		window.send_to_editor($(this).text());
	});
});