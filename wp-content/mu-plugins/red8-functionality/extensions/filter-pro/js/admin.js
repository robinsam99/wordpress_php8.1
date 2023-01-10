jQuery(document).ready(function($) {
	
	// Adding shortcode options to content editor
	$('.filter_pro_wrap .available_shortcodes a').click(function(e) {
		e.preventDefault();
		
		var caretPos = document.getElementById("filter_pro_plugin_results_format").selectionStart;
		var textAreaTxt = $("#filter_pro_plugin_results_format").val();
		var txtToAdd = $(this).text();
		$("#filter_pro_plugin_results_format").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
	});
	
	if($('.filter_pro_settings #add_filter_pro_shortcode').length) {
		$('.filter_pro_settings #add_filter_pro_shortcode').remove();	
	}
	
	
	// Taxonomy posts changes
	var filtered_post_types = new Array();
	$('.filter_pro_sc_post_types').on('change', 'select', function(e) {
		filtered_post_types = new Array();
		$('.filter_pro_sc_post_types option:selected').each(function(e) {
			filtered_post_types.push($(this).val());
		});
		
		get_taxonomies($('.filter_pro_sc_taxonomies #filter_pro_taxonomies'), true);
	});
	
	$('.filter_pro_widget_wrapper').on('change', '#filter_pro_widget_post_types', function(e) {
		filtered_post_types = $(this).val();
		get_taxonomies($(this).parent().parent().find('#filter_pro_widget_taxonomies'), false);
	});
	
	
	// Taxonomy term changes
	var filtered_taxonomies = new Array();
	function change_taxonomy_terms() {
		filtered_taxonomies = new Array();
		$('.filter_pro_sc_taxonomies option:selected').each(function(e) {
			filtered_taxonomies.push($(this).val());
		});
		
		get_tax_terms();
	}

	$('.filter_pro_sc_taxonomies').on('change', 'select', function(e) {
		change_taxonomy_terms();
	});
	
	
	
	// Generate shortcode button
	$('#create_shortcode_button').click(function(e) {
		e.preventDefault();
		
		var post_types = new Array();
		$('.filter_pro_sc_post_types select option:selected').each(function(e) {
			post_types.push($(this).val());
		});
		
		var taxonomies = new Array();
		$('.filter_pro_sc_taxonomies select option:selected').each(function(e) {
			taxonomies.push($(this).val());
		});
		
		var style = $('.filter_pro_sc_style input[type="radio"]:checked').val();
		
		var excluded_terms = new Array();
		$('.filter_pro_sc_terms select option:selected').each(function(e) {
			excluded_terms.push($(this).val());
		});
		var orderby = $('.filter_pro_sc_orderby select option:selected').val();
		var order = $('.filter_pro_sc_order select option:selected').val();
		var number = $('.filter_pro_sc_number input[type="number"]').val();
		var load_more_text = $('.filter_pro_sc_lmt input[type="text"]').val();
		var filter_id = $('.filter_pro_filter_id input[type="text"]').val();
		filter_id = filter_id.replace(' ', '_');
		
		var shortcode_text = "[filter_pro";
		
		if(post_types.length) {
			var post_type_string = '';
			for(var i = 0; i < post_types.length; i++) {
				if(i == (post_types.length-1)) {
					post_type_string += post_types[i];	
				} else {
					post_type_string += post_types[i]+', ';
				}
			}
			shortcode_text += ' post_types="'+post_type_string+'"';
		}
		
		if(taxonomies.length) {
			var taxonomies_string = '';
			for(var i = 0; i < taxonomies.length; i++) {
				if(i == (taxonomies.length-1)) {
					taxonomies_string += taxonomies[i];	
				} else {
					taxonomies_string += taxonomies[i]+', ';
				}
			}
			shortcode_text += ' taxonomies="'+taxonomies+'"';
		}
		
		if(style) {
			shortcode_text += ' style="'+style+'"';
		}
		
		if(excluded_terms.length) {
			var excluded_terms_string = '';
			for(var i = 0; i < excluded_terms.length; i++) {
				if(i == (excluded_terms.length-1)) {
					excluded_terms_string += excluded_terms[i];	
				} else {
					excluded_terms_string += excluded_terms[i]+', ';
				}
			}
			shortcode_text += ' excluded_terms="'+excluded_terms+'"';
		}
		
		if(orderby) {
			shortcode_text += ' orderby="'+orderby+'"';
		}
		
		if(order) {
			shortcode_text += ' order="'+order+'"';
		}
		
		if(number) {
			shortcode_text += ' number="'+number+'"';
		}
		
		if(load_more_text) {
			shortcode_text += ' load_more_text="'+load_more_text+'"';
		}
		
		if(filter_id) {
			shortcode_text += ' filter_id="'+filter_id+'"';
		}
		
		shortcode_text += ']';
		
		$('.generated_shortcode').val(shortcode_text);
		$('.generated_shortcode').css('display', 'block');
		$('#add_filter_pro_shortcode').css('display', 'block');
	});
	
	$('#add_filter_pro_shortcode').click(function(e) {
		e.preventDefault();
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, $(".generated_shortcode").val());
	});
	
	
	
	// Ajax functions
	var get_taxonomies = function($container, terms) {
		var data = {
			'action': 'filter_pro_shortcode_get_taxonomies',
			'post_types': filtered_post_types,
			'terms': terms
		};
		
		$.ajax({
			type: 'POST',
			url: ajaxObject.ajax_url,
			data: data,
			beforeSend: function() {
				$container.empty();
				$container.css('display', 'none');
			},
			success: function(returnData) {
				if(returnData.length){  
					$container.html(returnData);
					$container.css('display', 'block');
                }
                if(terms) {
                	change_taxonomy_terms();
                }
			},
			error: function(xhr, textStatus, errorThrown) {
				if(terms) {
					change_taxonomy_terms();
				}
			}
		});
	};
	
	var get_tax_terms = function() {
		var data = {
			'action': 'filter_pro_shortcode_get_terms',
			'taxonomies': filtered_taxonomies,
		};
		
		$.ajax({
			type: 'POST',
			url: ajaxObject.ajax_url,
			data: data,
			beforeSend: function() {
				$('.filter_pro_sc_terms #excluded_terms').empty();
				$('.filter_pro_sc_terms #excluded_terms').css('display', 'none');
			},
			success: function(returnData) {
				if(returnData.length){  
					$('.filter_pro_sc_terms #excluded_terms').html(returnData);
					$('.filter_pro_sc_terms #excluded_terms').css('display', 'block');
                }
			},
			error: function(xhr, textStatus, errorThrown) {
				
			}
		});
	};
});