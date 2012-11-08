jQuery(document).ready(function($) {
	
	// UX POOL
	
	// collect all ux pools and make them active
	var ux_pools = $('.ux-pool');
	
	$.each(ux_pools, function(i, id) {
		ux_pool_init(this.id);
	});
	
	// init ux pool
	function ux_pool_init(pool_id) {

		// sort
		ux_pool_update(pool_id);

		// make items sortable
		$('#'+pool_id+' .ux-pool-items').sortable({
			items: '.ux-pool-item',
			placeholder: 'ux-pool-placeholder',
			handle: '.ux-pool-handle',
			axis: 'y',
			distance: 2,
			stop: function(e, ui) {
				ux_pool_update(pool_id);
			}
		});

		// make searchable
		var ajax_url = $('#'+pool_id+' .ajax_url').val(); // get ajax url
		var query = $('#'+pool_id+' :input'); // get all input values

		$('#'+pool_id+' .ux-pool-search').click(function() {
			// do ajax when user clicks search button
			$.post(ajax_url, query, function(data) {
				ux_pool_query(pool_id, data);
			});
			
		});
		
	}
	
	// query ux pool
	
	function ux_pool_query(pool_id, data) {
		// refresh query area
		$('#'+pool_id+' .ux-pool-query').html(data);

		// get query items
		var items = $('#'+pool_id+' .ux-pool-query .ux-pool-item');
		items.each(function(i){
			var item_html = $(this);
			var item_id = $(this).attr('id');	

			// make addable
			$('#'+item_id+' .add').click(function() {
				$('#'+pool_id+' .ux-pool-items').append(item_html);
				ux_pool_update(pool_id);
				return false;
			});

		});
	

	}

	// update and sort ux pool
	function ux_pool_update(pool_id) {
		
		// set posts array
		var posts = [];
		
		// get pool items
		var items = $('#'+pool_id+' .ux-pool-items .ux-pool-item');
		items.each(function(i){
			var item_id = $(this).attr('id');		
							
			// push post id to array
			var item_id_array =item_id.split("-"), id_len = item_id_array.length;
			var post_id = item_id_array[id_len-1];
			posts.push('{"id":"'+post_id+'"}');
	
			// set order
			var order = i + 1;
			$('#'+item_id+' input.ux-pool-item-order').val(order);
			
			// make removeable
			$('#'+item_id+' .remove').click(function() {
				//alert(item_id);
				$('#'+item_id+'').remove();
				ux_pool_update(pool_id);
				return false;
			});

		});
		
		// view empty container if no items
		if (items.length > 0) {
			$('#'+pool_id+' .ux-pool-empty').hide();
		} else {
			$('#'+pool_id+' .ux-pool-empty').show();
		}

		// set meta value
		if (items.length > 0) {
			var meta_value = posts.join(',');
			meta_value = '{"posts":['+meta_value+']}';
			$('#'+pool_id+' .meta_value').val(meta_value);
		} else {
			$('#'+pool_id+' .meta_value').val('');
		}

		
	}

});