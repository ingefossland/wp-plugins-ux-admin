jQuery(document).ready(function($) {
								
	// UX LIST
	
	// collect all ux lists and make them active
	var ux_table = $('.ux-table');
	
	$.each(ux_table, function(i, id) {
		ux_table_init(id);
	});
	
	// init
	function ux_table_init(meta_id) {

		// update
		ux_table_update(meta_id);

		// add row
		$(meta_id).find('table tfoot tr td a').click(function() {
			console.log('add');

			var row = $(meta_id).find('table tfoot tr.new').clone().removeAttr('style');
			$(meta_id).find('table tbody').append(row);

			ux_table_update(meta_id);

			return false;
		});

		// make sortable
		$(meta_id).find('table tbody').sortable({
			items: 'tr',
			forceHelperSizeType: true,
			forcePlaceholderSizeType: true,
			placeholder: 'sortable-placeholder',
			opacity: 0.5,
			axis: 'y',
			distance: 2,
			stop: function(e, ui) {
				ux_table_update(meta_id);
			}
			
		}).disableSelection();

	}
	
	// update and sort list rows
	function ux_table_update(meta_id) {
		
		// set posts array
		var table_data = [];
		
		// get rows
		var rows = $(meta_id).find('table tbody tr');
		rows.each(function(i) {

			// get values per column
			var row_data = [];
			var cols = $(this).find('td input');
			
			cols.each(function(j) {

				// get data and push it into row
				col_data = $(this).val();
				row_data.push('"'+j+'":"'+col_data+'"');
				
			});

			// set values per row into table data
			table_data.push('{'+row_data.join(',')+'}');

			// update on change
			$(this).find('td input').change(function() {
				ux_table_update(meta_id);
			});

			// make removeable
			$(this).find('td a').click(function() {
				$(this).parent().parent().remove();
				ux_table_update(meta_id);
				return false;
			});	

		});

		// set meta value
		var meta_value = table_data.join(',');
		meta_value = '['+meta_value+']';

		$(meta_id).find('.meta_value').val(meta_value);

	}

});