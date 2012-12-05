jQuery(document).ready(function($) {
								
	// collect all instances and make them active
	var meta = $('.ux-metadata-options_multiple');
	
	$.each(meta, function(i, id) {
		ux_metadata_options_multiple(this.id);
	});
	
	// init
	function ux_metadata_options_multiple(meta_id) {

		// update
		ux_metadata_options_multiple_update(meta_id);
		
		// update on change
		$('#'+meta_id+' input[type=checkbox]').click(function() {
			ux_metadata_options_multiple_update(meta_id);
		});

	}
	
	// update and sort list rows
	function ux_metadata_options_multiple_update(meta_id) {

		// set posts array
		var values = [];
		
		// get rows
		var options = $('#'+meta_id+' input[type=checkbox]');
		options.each(function(i){
			
			if ($(this).is(':checked')) {
				values.push('"' + $(this).val() + '"');
			}
	
		});

		// set meta value
		var meta_value = values.join(',');
		meta_value = '['+meta_value+']';
		$('#'+meta_id+' .meta_value').val(meta_value);

	}

});