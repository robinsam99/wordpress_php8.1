jQuery(document).ready(function($) {
	function speedBump(linkLocation) {
		$('#continue').attr('href', linkLocation);
	}
	
	var linkLocation;
	
	$('.alert').live('click' ,function(e){
		e.preventDefault();
		linkLocation = $(this).attr('data-link');
	});
	
	
	$(".alert").fancybox({
		arrows: false,
		wrapCSS: 'alert',
		autoSize: false,
		width: '550',
		height: '250',
		closeBtn: false,
		afterLoad: function(){
			speedBump(linkLocation);
		}
	});
			
	$('.alert_buttons a').click(function() {
		var alertClass = $(this).attr('id');
		if(alertClass === 'continue') {
			$.fancybox.close();
			window.location = $(this).attr('href');
		} else {
			$.fancybox.close();
		}
	});
});