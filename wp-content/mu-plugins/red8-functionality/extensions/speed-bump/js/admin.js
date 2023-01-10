jQuery(document).ready(function($) {
	$('#add_speed_bump_button').live('click', function(e) {
		e.preventDefault();
		var sb_selection = tinyMCE.activeEditor.selection.getContent()
		var sb_url = $('#speed_bump_url').val();
		var sb_title = $('#speed_bump_title').val();
		var sb_target = $('#speed_bump_target').prop('checked');
		if(sb_url.length > 0 && sb_url != 'http://' && sb_selection.length > 0) {
			var return_text = '<a class="alert" href="#alert" data-link="'+sb_url+'"';
			if(sb_title.length > 0) {
				return_text += ' title="'+sb_title+'"';
			}
			if(sb_target) {
				return_text += ' target="_blank"';
			}
			return_text += '">'+sb_selection+'</a>';
            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, return_text);
		}
		$('#TB_closeWindowButton').trigger('click');
		$('#speed_bump_url').val('http://');
		$('#speed_bump_title').val('');
	});
});