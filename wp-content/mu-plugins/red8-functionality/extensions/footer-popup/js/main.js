jQuery(document).ready(function($) {
	var popup = $('.red8_func_footer_popup'),
	    extra = 500; // In case you want to trigger it a bit sooner than exactly at the bottom.
	
	popup.css({ opacity: '0', display: 'none' });
	
	$(window).scroll(function() {
	       
	   var scrolledLength = ( $(window).height() + extra ) + $(window).scrollTop(),
	       documentHeight = $(document).height();
	        
	   if( scrolledLength >= documentHeight ) {
	       
	       popup
	          .addClass('open').css('display', 'block')
	          .stop().animate({ bottom: '0', opacity: '1' }, 300);
	
	   } 
	});
	
	$('.red8_func_popup_close_btn').click(function(){
		popup.removeClass('open');
		popup.stop().animate({ bottom: '-100', opacity: '0' }, 300);
		popup.remove();
	});
	
	$('.red8_func_mobile_popup_close_btn').click(function(){
		popup.removeClass('open');
		popup.stop().animate({ bottom: '-100', opacity: '0' }, 300);
		popup.remove();
	});
});