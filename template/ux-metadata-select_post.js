jQuery(document).ready(function($) {
								
	// initialize
	var meta = $('.ux-metadata-select_post');
	
	$.each(meta, function(i, id) {
		ux_metadata_select_post(this.id);
	});

	// select relation
	function ux_metadata_select_post(item_id) {
		
		var ajax_url = $('#'+item_id+' .ajax_url').val(); // get ajax url

		var post_id = $('#'+item_id+' .post_id').val(); // current post id
		var post_title = $('#'+item_id+' .post_title').val(); // post title input (query)
		var post_type = $('#'+item_id+' .post_type').val(); // post_type (scope for query)

		var input = $('#'+item_id+' .post_title');
		var output = $('#'+item_id+' .suggest');
		
		$(input).autocomplete({
			source: ajax_url,
			appendTo: output,
			minLength: 2,
			autoFocus: true,
			focus: function(event, ui) {
				$('#'+item_id+' .post_title').removeClass('on');
				return false;
			},
			select: function(event, ui) {
				ux_metadata_select_post_update(item_id, ui.item.id, ui.item.value);
				return false;
			}
		});

	}
	
	// select relation update
	function ux_metadata_select_post_update(item_id, selected_id, selected_value) {
		
		// get input fields
		var post_id = $('#'+item_id+' .post_value');
		var post_name = $('#'+item_id+' .post_title');

		// query
		var query = $(post_name).val()
		
		// set meta value
		$(post_id).val(selected_id);
		
		// remove classes
		$(post_name).removeClass('new');
		$(post_name).removeClass('on');
		
		// new, off or on
		if (selected_id == 'new') { // new
			$(post_name).val(query);
			$(post_name).addClass('new');
		} else if (selected_id == '0') { // off
			$(post_name).val('');
		} else if (selected_id != 0) { // on
			$(post_name).val(selected_value);
			$(post_name).addClass('on');
		}
		
		return false;

	}

});