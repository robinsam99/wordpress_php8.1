(function() {
    tinymce.create('tinymce.plugins.SpeedBump', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
	        
	        ed.onNodeChange.add(function(ed, cm, node) {
				cm.setDisabled('speedbump', (!ed.selection.getContent().length && node.tagName != 'A'));
				cm.setActive('speedbump', node.tagName == 'A');
    		});
	        
            ed.addButton('speedbump', {
                title : 'Speed Bump',
                cmd : 'speedbump',
            });
            
            ed.addCommand('speedbump', function() {
	            var e;

				if ( e = ed.dom.getParent( ed.selection.getNode(), 'A' ) ) {
					if(ed.dom.getAttrib(e, 'data-link')) {
						jQuery('#speed_bump_url').val(ed.dom.getAttrib( e, 'data-link' ));
					} else {
						jQuery('#speed_bump_url').val(ed.dom.getAttrib( e, 'href' ));
					}
					jQuery('#speed_bump_title').val(ed.dom.getAttrib( e, 'title' ));
					jQuery('#speed_bump_target').prop('checked', ( '_blank' === ed.dom.getAttrib( e, 'target' ) ));
					jQuery('#add_speed_bump_button').text('Update');
				} else {
					jQuery('#speed_bump_url').val('http://');
					jQuery('#speed_bump_title').val('');
					jQuery('#speed_bump_target').prop('checked', false);
					jQuery('#add_speed_bump_button').text('Add Speed Bump Link');
				}
	            
				
	            tb_show('Insert Speed Bump Link', '#TB_inline?height=300&width=400&inlineId=speed_bump_content');
	            jQuery('#TB_window').height('auto');
            });
            
            jQuery('.mce-i-speedbump').addClass('thickbox');
        },
 
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Speed Bump Buttons',
                author : 'Red8 Interactive',
                authorurl : 'http://red8interactive.com',
                infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'speed_bump', tinymce.plugins.SpeedBump );
})();