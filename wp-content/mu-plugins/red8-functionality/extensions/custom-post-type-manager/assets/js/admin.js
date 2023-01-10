jQuery(document).ready(function($) {
	
	var icons = [
			"menu",
			"admin-site",
			"dashboard",
			"admin-media",
			"admin-page",
			"admin-comments",
			"admin-appearance",
			"admin-plugins",
			"admin-users",
			"admin-tools",
			"admin-settings",
			"admin-network",
			"admin-generic",
			"admin-home",
			"admin-collapse",
			"admin-links",
			"format-links",
			"admin-post",
			"format-standard",
			"format-image",
			"format-gallery",
			"format-audio",
			"format-video",
			"format-chat",
			"format-status",
			"format-aside",
			"format-quote",
			"welcome-write-blog",
			"welcome-edit-page",
			"welcome-add-page",
			"welcome-view-site",
			"welcome-widgets-menus",
			"welcome-comments",
			"welcome-learn-more",
			"image-crop",
			"image-rotate-left",
			"image-rotate-right",
			"image-flip-vertical",
			"image-flip-horizontal",
			"undo",
			"redo",
			"editor-bold",
			"editor-italic",
			"editor-ul",
			"editor-ol",
			"editor-quote",
			"editor-alignleft",
			"editor-aligncenter",
			"editor-alignright",
			"editor-insertmore",
			"editor-spellcheck",
			"editor-distractionfree",
			"editor-kitchensink",
			"editor-underline",
			"editor-justify",
			"editor-textcolor",
			"editor-paste-word",
			"editor-paste-text",
			"editor-removeformatting",
			"editor-video",
			"editor-customchar",
			"editor-outdent",
			"editor-indent",
			"editor-help",
			"editor-strikethrough",
			"editor-unlink",
			"editor-rtl",
			"align-left",
			"align-right",
			"align-center",
			"align-none",
			"lock",
			"calendar",
			"visibility",
			"post-status",
			"post-trash",
			"edit",
			"trash",
			"arrow-up",
			"arrow-down",
			"arrow-left",
			"arrow-right",
			"arrow-up-alt",
			"arrow-down-alt",
			"arrow-left-alt",
			"arrow-right-alt",
			"arrow-up-alt2",
			"arrow-down-alt2",
			"arrow-left-alt2",
			"arrow-right-alt2",
			"leftright",
			"sort",
			"list-view",
			"exerpt-view",
			"share",
			"share1",
			"share-alt",
			"share-alt2",
			"twitter",
			"rss",
			"facebook",
			"facebook-alt",
			"networking",
			"googleplus",
			"hammer",
			"art",
			"migrate",
			"performance",
			"wordpress",
			"wordpress-alt",
			"pressthis",
			"update",
			"screenoptions",
			"info",
			"cart",
			"feedback",
			"cloud",
			"translation",
			"tag",
			"category",
			"yes",
			"no",
			"no-alt",
			"plus",
			"minus",
			"dismiss",
			"marker",
			"star-filled",
			"star-half",
			"star-empty",
			"flag",
			"location",
			"location-alt",
			"camera",
			"images-alt",
			"images-alt2",
			"video-alt",
			"video-alt2",
			"video-alt3",
			"vault",
			"shield",
			"shield-alt",
			"search",
			"slides",
			"analytics",
			"chart-pie",
			"chart-bar",
			"chart-line",
			"chart-area",
			"groups",
			"businessman",
			"id",
			"id-alt",
			"products",
			"awards",
			"forms",
			"portfolio",
			"book",
			"book-alt",
			"download",
			"upload",
			"backup",
			"lightbulb",
			"smiley"
		];

 
    $('.select_icon_button').click(function(e) {
    	e.stopPropagation();

        $('.dashicon_picker_container').show();
        
		for (var i in icons) {
			$('.dashicon_picker_list').append('<li data-icon="'+icons[i]+'"><a href="#" title="'+icons[i]+'"><span class="dashicons dashicons-'+icons[i]+'"></span></a></li>');
		};
		
		$('.dashicon_picker_list a').click(function(e) {
			e.preventDefault();
			
			var iconValue = "dashicons-" + $(this).attr('title');
			$('.icon_text').val(iconValue);
			$('.dashicon_picker_container').hide();
		});
		
	});
	
	$('body').click(function (e){
		$('.dashicon_picker_container').hide();
	});
	
	var custom_uploader;
	
	$('.upload_icon_button').click(function (e) {
	
    	//If the uploader object has already been created, reopen the dialog
	    if (custom_uploader) {
	        custom_uploader.open();
	        return;
	    }
	
	    //Extend the wp.media object
	    custom_uploader = wp.media.frames.file_frame = wp.media({
	        title: 'Choose Icon',
	        button: {
	            text: 'Choose Icon'
	        },
	        multiple: false
	    });
	
	    //When a file is selected, grab the URL and set it as the text field's value
	    custom_uploader.on('select', function() {
	        attachment = custom_uploader.state().get('selection').first().toJSON();
	        $('.icon_text').val(attachment.url);
	    });
	
	    //Open the uploader dialog
	    custom_uploader.open();

	});
	
	$('#update_tax_form, #new_tax_form, #update_cpt_form, #new_cpt_form').submit(function (e) {
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
	
	$('#update_tax_form, #new_tax_form').submit(function (e){
		$('.checkbox_error').hide();
		var valid = valthisform();
	    
	    if(valid) {
		    return true;
	    } else {
	    	e.preventDefault();
	    	$('.checkbox_error').show();
	    	$("html, body").animate({ scrollTop: 0 });
		}
	});
	
	function valthisform() {
	
	    var checkboxes = document.getElementsByName("post_types[]");
	    var checked = false;
	    
	    for(var i=0,l=checkboxes.length; i < l; i++) {
	        if(checkboxes[i].checked) {
	        	checked = true;
	            break;
	        }
	    }
	    
	    return checked;
	}
	
	
	$('#post_type_name').focusout(function(e) {
		if($('#post_type_name').val().length) {
			var post_type = $('#post_type_name').val();
			
			if(!$('#singular_name').val().length) {
				$('#singular_name').val(post_type);
			}
			
			if(!$('#menu_name').val().length) {
				$('#menu_name').val(post_type);
			}
			
			if(!$('#name_admin_bar').val().length) {
				$('#name_admin_bar').val(post_type);
			}
			
			if(!$('#all_items').val().length) {
				$('#all_items').val(post_type);
			}
			
			if(!$('#add_new').val().length) {
				$('#add_new').val('Add New');
			}
			
			if(!$('#add_new_item').val().length) {
				$('#add_new_item').val('Add New '+post_type);
			}
			
			if(!$('#edit_item').val().length) {
				$('#edit_item').val('Edit '+post_type);
			}
			
			if(!$('#new_item').val().length) {
				$('#new_item').val('New '+post_type);
			}
			
			if(!$('#view_item').val().length) {
				$('#view_item').val('View '+post_type);
			}
			
			if(!$('#search_items').val().length) {
				$('#search_items').val('Search '+post_type);
			}
			
			if(!$('#not_found').val().length) {
				$('#not_found').val('No '+post_type+' found');
			}
			
			if(!$('#not_found_in_trash').val().length) {
				$('#not_found_in_trash').val('No '+post_type+'s found in Trash');
			}
			
			if(!$('#parent_item_colon').val().length) {
				$('#parent_item_colon').val('Parent '+post_type);
			}
		}
	});


	$('#tax_name').focusout(function(e) {
		if($('#tax_name').val().length > 0) {
			var taxonomy = $('#tax_name').val();
			
			if(!$('#singular_name').val().length) {
				$('#singular_name').val(taxonomy);
			}
			
			if(!$('#menu_name').val().length) {
				$('#menu_name').val(taxonomy);
			}
			
			if(!$('#all_items').val().length) {
				$('#all_items').val('All '+taxonomy);
			}
			
			if(!$('#edit_item').val().length) {
				$('#edit_item').val('Edit '+taxonomy);
			}
			
			if(!$('#view_item').val().length) {
				$('#view_item').val('View '+taxonomy);
			}
			
			if(!$('#update_item').val().length) {
				$('#update_item').val('Update '+taxonomy);
			}
			
			if(!$('#add_new_item').val().length) {
				$('#add_new_item').val('Add New '+taxonomy);
			}
			
			if(!$('#new_item_name').val().length) {
				$('#new_item_name').val('New '+taxonomy+' name');
			}
	
			if(!$('#parent_item').val().length) {
				$('#parent_item').val('Parent '+taxonomy);
			}
			
			if(!$('#parent_item_colon').val().length) {
				$('#parent_item_colon').val('Parent '+taxonomy+':');
			}
			
			if(!$('#search_items').val().length) {
				$('#search_items').val('Search '+taxonomy);
			}
			
			if(!$('#popular_items').val().length) {
				$('#popular_items').val('Popular '+taxonomy);
			}
			
			if(!$('#separate_items_with_commas').val().length) {
				$('#separate_items_with_commas').val('Seperate '+taxonomy.toLowerCase()+'s with commas');
			}
			
			if(!$('#add_or_remove_items').val().length) {
				$('#add_or_remove_items').val('Add or remove '+taxonomy.toLowerCase()+'s');
			}
			
			if(!$('#choose_from_most_used').val().length) {
				$('#choose_from_most_used').val('Choose from the most used '+taxonomy.toLowerCase()+'s');
			}
			
			if(!$('#not_found').val().length) {
				$('#not_found').val('No '+taxonomy.toLowerCase()+'s found');
			}
		}
	});
	
	$('input[type="number"], select, input[type="checkbox"]:not(.activation)').change(function(e) {
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