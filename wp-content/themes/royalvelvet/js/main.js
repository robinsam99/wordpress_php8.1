jQuery(document).ready(function($) {

	$('.menu_fancybox').children('a').addClass('fancybox');
	$('.fancybox').fancybox();

	$('.fancybox').click(function() {
		if(!$('html').hasClass('fancybox-lock')) {
			$('html').addClass('fancybox-lock');
		} else {
			$('html').removeClass('fancybox-lock');
		}
	});

	$(document).bind('gform_post_render', function(){
		$('.gchoice_3_6_1').children('label').html('I accept the <a href="/terms-and-conditions" target="_blank">Terms of use</a> and read the <a href="http://royalvelvet.com/privacy-policy" target="_blank">Privacy Policy</a>.');
	});

	if($('.gchoice_3_6_1').length) {
		$('.gchoice_3_6_1').children('label').html('I accept the <a href="/terms-and-conditions" target="_blank">Terms of use</a> and read the <a href="http://royalvelvet.com/privacy-policy" target="_blank">Privacy Policy</a>.');
	}


	/************************
	* Mobile menu hamburger *
	*************************/

	$('.hamburger_button').click(function(e) {
		e.preventDefault();
		if ( $('html').hasClass('mm-opened') ) {
			$('html').removeClass('mm-opened');
			$('body').removeClass('mm-opened');
		} else {
			$('html').addClass('mm-opened');
			$('body').addClass('mm-opened');
		}
	});

	$(window).resize(function () {
		var width = $(window).width();
		if (width >768) {
			$('html').removeClass('mm-opened');
			$('body').removeClass('mm-opened');
		}
	});

	/******************
	* Homepage Swiper *
	*******************/
	var paginationClicked = false;
	var homepageSwiper = new Swiper ('.swiper-container', {
	    direction: 'horizontal',
	    loop: true,
		speed: 1000,
		autoplay: 2500,
		paginationClickable: true,
	    pagination: '.swiper-pagination',
	    nextButton: '.swiper-button-next',
	    prevButton: '.swiper-button-prev'
	});

	//Stop autoplay when mouse enters the swiper
	$('.home_slider').on('mouseenter', function() {
		homepageSwiper.stopAutoplay();
	});

	//Start autoplay when mouse leaves the swiper
	$('.home_slider').on('mouseleave', function() {
		//Only start autoplay if pagination wasn't clicked
		if(!paginationClicked) {
			homepageSwiper.startAutoplay();
		}
	});

	//Stop autoplay when pagination is clicked
	$('.home_slider .swiper-container .swiper-pagination-bullet').live('click', function() {
		paginationClicked = true;
		homepageSwiper.stopAutoplay();
	});


	//** Move product image on mobile for single product page **//
	if($('.product_image').length) {
		$('.product_image').appendAround();
	}

	if($('.shop_jcp').length) {
    	$('.shop_jcp').appendAround();
  	}

	/******************
	* Tracking Scripts *
	*******************/

	$('.header_menu li a, .mobile_menu li a').on('click', function(e) {
		e.preventDefault();
		__gaTracker('send', 'event', {
			eventCategory: 'Menu Ribbon',
			eventAction: 'Click',
			eventLabel: e.target.innerHTML,
		});
		if (e.target.target === '_blank') {
			window.open(e.target.href, '_blank');
		} else {
			window.location = e.target.href;
		}
	});

	$('.footer_menu li a').on('click', function(e) {
		e.preventDefault();
		__gaTracker('send', 'event', {
			eventCategory: 'Site Info',
			eventAction: 'Click',
			eventLabel: e.target.innerHTML,
		});
		if (e.target.target === '_blank') {
			window.open(e.target.href, '_blank');
		} else {
			window.location = e.target.href;
		}
	});

	$('input#choice_3_5_1').on('click', function(e) {
		__gaTracker('send', 'event', {
			eventCategory: 'Join Detail',
			eventAction: 'Click',
			eventLabel: 'Opt-in',
		});
	});

	$('input#choice_3_6_1').on('click', function(e) {
		__gaTracker('send', 'event', {
			eventCategory: 'Join Detail',
			eventAction: 'Click',
			eventLabel: 'Accept Terms',
		});
	});

	$('input#gform_submit_button_3').on('click', function(e) {
		__gaTracker('send', 'event', {
			eventCategory: 'Join Detail',
			eventAction: 'Click',
			eventLabel: 'Submit',
		});
	});

	$('.share span').live('click', function(e) {
		e.preventDefault();
		__gaTracker('send', 'event', {
			eventCategory: 'Tips Detail: Social Share',
			eventAction: 'Click',
			eventLabel: 'Pinterest',
		});
	});

	$('.media-box-container a').live('click', function(e) {
		var title = $(this).data('title');
		__gaTracker('send', 'event', {
			eventCategory: 'Home Page: All',
			eventAction: 'Click',
			eventLabel: title,
		});
	});

	/******************
	* End Tracking Scripts *
	*******************/

});
