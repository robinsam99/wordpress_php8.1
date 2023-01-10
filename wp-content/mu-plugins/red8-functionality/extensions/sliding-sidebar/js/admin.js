jQuery(document).ready(function($) {
	
	if($('#post-body #postbox-container-1').length) {
		$('#post-body #post-body-content').append('<button class="slide_sidebar_button button" type="button">Open Sidebar</button>');
		
		$('#post-body').addClass('closed_sidebar');
		var hiddenSidebar = true;
		
		$('#post-body #post-body-content').on('click', '.slide_sidebar_button', function(e) {
			e.preventDefault();
			
			if(hiddenSidebar) {
				$('#post-body').animate({
					'margin-right': '300px'
				}, 400, function() {
					$(window).scrollTop($(window).scrollTop()+1);
					$('#post-body').removeClass('closed_sidebar');
					$('#post-body #post-body-content .slide_sidebar_button').text('Close Sidebar');
					$('#post-body #post-body-content .slide_sidebar_button').addClass('open');
				});
			} else {
				$('#post-body').animate({
					'margin-right': '0'
				}, 400, function() {
					$(window).scrollTop($(window).scrollTop()+1);
					$('#post-body').addClass('closed_sidebar');
					$('#post-body #post-body-content .slide_sidebar_button').text('Open Sidebar');
					$('#post-body #post-body-content .slide_sidebar_button').removeClass('open');
				});
			}
			
			hiddenSidebar = !hiddenSidebar;
		});
	}
});