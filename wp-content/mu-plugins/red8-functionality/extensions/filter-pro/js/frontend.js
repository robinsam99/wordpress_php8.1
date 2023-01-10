jQuery(document).ready(function($){
		
	if($('.filter_pro_page').length) {
		
		//Ajax loop for filtering
		var loading = false;
		var $filteredContent = $('#filtered_posts');
		var filters = {};
		var post_type = $('.filter_pro_page > #filter_posts_post_type').val();
		var posts_per_page = $('.filter_pro_page > #filter_posts_posts_per_page').val();
		var orderby = $('.filter_pro_page > #filter_posts_orderby').val();
		var order = $('.filter_pro_page > #filter_posts_order').val();
		var load_more_text = $('.filter_pro_page > #filter_posts_load_more_text').val();
		var filter_id = null;
		if($('.filter_pro_page > #filter_posts_filter_id').length) {
			filter_id = $('.filter_pro_page > #filter_posts_filter_id').val();
		}
		var excluded_posts = new Array();
		
		var currentPage = 1;
		var filter_posts = function() {
			var data = {
				'action': 'load_filtered_results',
				'paged' : currentPage,
				'filters': filters,
				'post_type' : post_type,
				'ppp' : posts_per_page,
				'orderby' : orderby,
				'order' : order,
				'excluded_posts' : excluded_posts,
				'load_more_text' : load_more_text,
				'filter_id' : filter_id,
			};
			
			$.ajax({
				type: 'POST',
				url: ajaxObject.ajax_url,
				data: data,
				beforeSend: function() {
					if(currentPage == 1) {
						$filteredContent.empty();
						
						$filteredContent.append('<div id="temp_load" style="text-align:center; margin: 10px 0; width: 100%;"><img style="display: inline-block;" src="'+ajaxObject.plugin_url+'/images/ajax-loader.gif" /></div>'); 
					} else {
						$filteredContent.find('.load_more_results').remove();
						$filteredContent.append('<div id="temp_load" style="text-align:center; margin: 10px 0; width: 100%;"><img style="display: inline-block;" src="'+ajaxObject.plugin_url+'/images/ajax-loader.gif" /></div>'); 
					}
					loading = true;
				},
				success: function(returnData) {
					if(returnData.length){  
						if(currentPage == 1) {
		                    $filteredContent.hide(); 
		                    $filteredContent.append(returnData);
		                    $("#temp_load").remove(); 
		                    $filteredContent.fadeIn(500, function(){
		                        loading = false;  
		                    });
	                    } else {
		                    $filteredContent.append(returnData);  
		                    $("#temp_load").remove(); 
		                    $filteredContent.fadeIn(500, function(){
		                        loading = false;  
		                    });
	                    }
	                    currentPage++;
	                } else {  
		                $("#temp_load").remove(); 
	                    loading = false;
	                } 
				},
				error: function(xhr, textStatus, errorThrown) {
					$("#temp_load").remove(); 
				}
			});
		};
		
		filter_posts();
		
		function get_filters_for_post() {
			if(!loading) {
				filters = {};
				
				$('.filter_pro_page .filters .radio_filter input[type="radio"]').each(function(e) {
					if($(this).is(':checked') && $(this).val() != 'none') {
						filters[$(this).attr('name')] = $(this).val();
					}
				});
				
				$('.filter_pro_page .filters .checkbox_filter input[type="checkbox"]').each(function(e) {
					if($(this).is(':checked')) {
						if(filters[$(this).attr('name')]) {
							var index = filters[$(this).attr('name')].length;
							filters[$(this).attr('name')][index] = $(this).val();
						} else {
							filters[$(this).attr('name')] = new Array($(this).val());
						}
					}
				});
				
				$('.filter_pro_page .filters .select_filter option').each(function(e) {
					if($(this).is(':selected') && $(this).val() != 'none') {
						filters[$(this).parent().attr('name')] = $(this).val();
					}
				});
				
				$('html, body').animate({
					scrollTop: $filteredContent.offset().top-100
				}, 2000);
				
				currentPage = 1;
				filter_posts();
			}
		}
		
		$('.filter_pro_page .filters .radio_filter input[type="radio"]').change(function() {
			get_filters_for_post();
		});
		
		$('.filter_pro_page .filters .checkbox_filter input[type="checkbox"]').change(function() {
			get_filters_for_post();
		});
		
		$('.filter_pro_page .filters .select_filter').change(function() {
			get_filters_for_post();
		});
		
		$('#filtered_posts').on('click', '.load_more_results', function(e) {
			e.preventDefault();
			
			excluded_posts = new Array();
			if(orderby == 'rand') {
				$('#filtered_posts .filtered_post').each(function(e) {
					excluded_posts.push($(this).find('h3 a').attr('href'));
				});
			}
			
			filter_posts();
		});
	}
});