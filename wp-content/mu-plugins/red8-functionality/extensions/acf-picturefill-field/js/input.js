(function($){
	
	acf.fields.picturefill_field = acf.field.extend({
		
		type: 'picturefill_field',
		$el: null,
		breakpoint: null,
		
		actions: {
			'ready':	'initialize',
			'append':	'initialize'
		},
		
		events: {
			'click a[data-name="add"]': 	'add',
			'click a[data-name="edit"]': 	'edit',
			'click a[data-name="remove"]':	'remove',
			'change input[type="file"]':	'change'
		},
		
		focus: function(){
			
			if(this.breakpoint) {
				this.$el = this.$field.find('.acf-image-uploader[data-breakpoint="'+this.breakpoint+'"]');
			} else {
				// get elements
				this.$el = this.$field.find('.acf-image-uploader');
			}
			
			// get options
			this.o = acf.get_data( this.$el );
			
		},
		
		initialize: function(){
			
			// add attribute to form
			if( this.$el.hasClass('basic') ) {
				
				this.$el.closest('form').attr('enctype', 'multipart/form-data');
				
			}
				
		},
		
		add: function(e) {
			
			// reference
			var self = this,
				$field = this.$field;
				
			this.breakpoint = $(e.target).attr('data-breakpoint');
			this.$el = this.$field.find('.acf-image-uploader[data-breakpoint="'+this.breakpoint+'"]');
			
			
			// get repeater
			var $repeater = acf.get_closest_field( this.$field, 'repeater' );
			
			
			// popup
			var frame = acf.media.popup({
				
				title:		acf._e('image', 'select'),
				mode:		'select',
				type:		'image',
				field:		acf.get_field_key($field),
				multiple:	$repeater.exists(),
				library:	this.o.library,
				mime_types: this.o.mime_types,
				
				select: function( attachment, i ) {
					
					// select / add another image field?
			    	if( i > 0 ) {
			    		
			    		// vars
						var key = acf.get_field_key( $field ),
							$tr = $field.closest('.acf-row');
						
						
						// reset field
						$field = false;
						
						
						// find next image field
						$tr.nextAll('.acf-row:visible').each(function(){
							
							// get next $field
							$field = acf.get_field( key, $(this) );
							
							
							// bail early if $next was not found
							if( !$field ) {
								
								return;
								
							}
							
							
							// bail early if next file uploader has value
							if( $field.find('.acf-image-uploader.has-value').exists() ) {
								
								$field = false;
								return;
								
							}
								
								
							// end loop if $next is found
							return false;
							
						});
						
						
						// add extra row if next is not found
						if( !$field ) {
							
							$tr = acf.fields.repeater.doFocus( $repeater ).add();
							
							
							// bail early if no $tr (maximum rows hit)
							if( !$tr ) {
								
								return false;
								
							}
							
							
							// get next $field
							$field = acf.get_field( key, $tr );
							
						}
						
					}
					
					// focus
					self.doFocus( $field );
					
								
			    	// render
					self.render( self.prepare(attachment) );
					
				}
				
			});
						
		},
		
		prepare: function( attachment ) {
		
			// vars
			var image = {
		    	id:		attachment.id,
		    	url:	attachment.attributes.url
	    	};			
			
			
			// check for preview size
			if( acf.isset(attachment.attributes, 'sizes', this.o.preview_size, 'url') ) {
	    	
		    	image.url = attachment.attributes.sizes[ this.o.preview_size ].url;
		    	
	    	}
	    	
	    	
	    	// return
	    	return image;
			
		},
		
		render: function( image ){
			
	    	
			// set atts
		 	this.$el.find('[data-name="image"]').attr( 'src', image.url );
			this.$el.find('[data-name="id"]').val( image.id ).trigger('change');
			
			
			// set div class
		 	this.$el.addClass('has-value');
	
		},
		
		edit: function(e) {
			
			// reference
			var self = this;
			
			this.breakpoint = $(e.target).attr('data-breakpoint');
			this.$el = this.$field.find('.acf-image-uploader[data-breakpoint="'+this.breakpoint+'"]');
			
			
			// vars
			var id = this.$el.find('[data-name="id"]').val();
			
			
			// popup
			var frame = acf.media.popup({
			
				title:		acf._e('image', 'edit'),
				button:		acf._e('image', 'update'),
				mode:		'edit',
				id:			id,
				
				select:	function( attachment, i ) {
				
			    	self.render( self.prepare(attachment) );
					
				}
				
			});
			
		},
		
		remove: function(e) {
			
			this.breakpoint = $(e.target).attr('data-breakpoint');
			this.$el = this.$field.find('.acf-image-uploader[data-breakpoint="'+this.breakpoint+'"]');
			
			// vars
	    	var attachment = {
		    	id:		'',
		    	url:	''
	    	};
	    	
	    	
	    	// add file to field
	        this.render( attachment );
	        
	        
			// remove class
			this.$el.removeClass('has-value');
			
		},
		
		change: function( e ){
			
			this.$el.find('[data-name="id"]').val( e.$el.val() );
			
		}
		
	});
	
	
	function initialize_field( $el ) {
		
		//$el.doStuff();
		var $field = $el, $options = $el.find('.acf-image-uploader');
        $field.find('.acf-image-value').on('change', function(){
            var originalImage = $(this).val();
            if($(this).val()){
                $field.removeClass('invalid');
                updateFieldValue($field);
            }
            else{
                //Do nothing
            }

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
			
			// search $el for fields of type 'picturefill_field'
			acf.get_fields({ type : 'picturefill_field'}, $el).each(function(){
				
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
			
			$(postbox).find('.field[data-field_type="picturefill_field"]').each(function(){
				
				initialize_field( $(this) );
				
			});
		
		});
	
	
	}


})(jQuery);
