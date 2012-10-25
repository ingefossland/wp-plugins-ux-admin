jQuery(document).ready(function($) {
								
	// UX LIST
	
	// collect all ux lists and make them active
	var ux_list = $('.ux-list');
	
	$.each(ux_list, function(i, id) {
		ux_list_init(this.id);
	});
	
	// init
	function ux_list_init(meta_id) {

		// update
		ux_list_update(meta_id);

		// add row
		$('#'+meta_id+' .add').click(function() {
			var row = $('#'+meta_id+' .ux-list-new  .ux-list-row').clone();
			$('#'+meta_id+' .ux-list-rows').append(row);
			ux_list_update(meta_id);
			return false;
		});


		// make sortable and update on change
		$('#'+meta_id+' .ux-list-rows').sortable({
			items: '.ux-list-row',
			placeholder: 'placeholder',
			axis: 'y',
			distance: 2,
			stop: function(e, ui) {
				ux_list_update(meta_id);
			}
		}); 

	}
	
	// update and sort list rows
	function ux_list_update(meta_id) {
		
		// set posts array
		var list = [];
		
		// get rows
		var rows = $('#'+meta_id+' .ux-list-row');
		rows.each(function(i){

			// set row id
			var row_id = "list-row"+meta_id+"-"+i;
			$(this).attr('id', row_id);
	
			// get values of inputs
			var title = $('#'+row_id+' .title').val();
			var descr = $('#'+row_id+' .descr').val();

			// save if title
			if (title) {
				list.push('"'+title+'":"'+descr+'"');
			}

			// update on change
			$('#'+row_id+' input').change(function() {
				ux_list_update(meta_id);
			});

			// make removeable
			$('#'+row_id+' .remove').click(function() {
				$(this).parent().parent().parent().remove();
				ux_list_update(meta_id);
				return false;
			});	

		});

		// set meta value
		var meta_value = list.join(',');
		meta_value = '{'+meta_value+'}';
		$('#'+meta_id+' .meta_value').val(meta_value);

	}

});