(function($){
	
	
	function initialize_field( $el ) {
		
		var currentLinkField = '';															// Variable to keep track of which field we clicked on
		
		jQuery('body').on('click', '.acf_link_field_text_input', function(event) {
            currentLinkField = jQuery(this).attr("data-id");								// Get the field id to keep track of
            
            jQuery('#wp-link-url').val(jQuery('#'+currentLinkField+'-url').val());
            //jQuery('#wp-link-text').val(jQuery('#'+currentLinkField+'-title').val());
            
            wpActiveEditor = true;
            wpLink.open();																	// Open the Wordpress Link editor
            return false;
		});
		
		jQuery('body').on('click', '#wp-link-submit', function(event) {
            if (currentLinkField != '') {
	            var linkAtts = wpLink.getAttrs(); 											// Get the field attributes fromt the popup
	            console.log(linkAtts);
	            jQuery('#'+currentLinkField+'-url').val(linkAtts.href); 					// Assign the URL from the popup to our text field
	            //jQuery('#'+currentLinkField+'-title').val(jQuery('#wp-link-text').val()); 					// Assign the Title from the popup to our text field
	            
	            wpLink.textarea = jQuery('#'+currentLinkField+'-url'); 								// Assign the focus back to our textfield
                wpLink.close(); 															// Close the popup box
                
                event.preventDefault();
                event.stopPropagation();
                
                return false;
			}
			currentLinkField = '';
		});
		
		jQuery('body').on('click', '#wp-link-cancel a', function(event) 
        {
            wpLink.textarea = jQuery('#'+currentLinkField+'-url');
            wpLink.close();
            
            event.preventDefault();
            event.stopPropagation();
            currentLinkField = '';
            return false;
        });
        
        jQuery('body').on('click', '#wp-link-close', function(event) 
        {
            wpLink.textarea = jQuery('#'+currentLinkField+'-url');
            wpLink.close();
            
            event.preventDefault();
            event.stopPropagation();
            currentLinkField = '';
            return false;
        });
	}
	
	
	if( typeof acf.add_action !== 'undefined' ) {
	
		/*
		*  ready append (ACF5)
		*
		*  These are 2 events which are fired during the page load
		*  ready = on page load similar to $(document).ready()
		*  append = on new DOM elements appended via repeater field
		*
		*  @type	event
		*  @date	20/07/13
		*
		*  @param	$el (jQuery selection) the jQuery element which contains the ACF fields
		*  @return	n/a
		*/
		
		acf.add_action('ready append', function( $el ){
			
			// search $el for fields of type 'link_field'
			acf.get_fields({ type : 'link_field'}, $el).each(function(){
				
				initialize_field( $(this) );
				
			});
			
		});
		
		
	} else {
		
		
		/*
		*  acf/setup_fields (ACF4)
		*
		*  This event is triggered when ACF adds any new elements to the DOM. 
		*
		*  @type	function
		*  @since	1.0.0
		*  @date	01/01/12
		*
		*  @param	event		e: an event object. This can be ignored
		*  @param	Element		postbox: An element which contains the new HTML
		*
		*  @return	n/a
		*/
		
		$(document).on('acf/setup_fields', function(e, postbox){
			
			$(postbox).find('.field[data-field_type="link_field"]').each(function(){
				
				initialize_field( $(this) );
				
			});
		
		});
	
	
	}


})(jQuery);
