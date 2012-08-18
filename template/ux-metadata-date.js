jQuery(document).ready(function($) {
								
	// collect all date and make them active
	var ux_dates = $('.ux-date');
	
	$.each(ux_dates, function(i, id) {
		ux_date_init(this.id);
	});
	
	// init datetime
	function ux_date_init(date_id) {


		// update on load
		ux_date_update(date_id);
		
		// year
		$('#'+date_id+' input.year').change(function() {

			var year = $(this).val();
			
			// valid year
			if (year > 0 && year.length == 4) {
				year = year;
			} else {
				year = '0000';
			}			

			$('#'+date_id+' input.year').val(year);

			ux_date_update(date_id);
		});

		// month
		$('#'+date_id+' select.month').change(function() {
			ux_date_update(date_id);
		});

		// day
		$('#'+date_id+' input.day').change(function() {

			var day = $(this).val();
			
			// valid day
			if (day > 0 && day < 10) { 
				day = '0'+day;
			} else if (day >= 10 && day <= 31) {
				day = day;
			} else {
				day = "01";
			}

			$('#'+date_id+' input.day').val(day);

			ux_date_update(date_id);
		});

		// hour
		$('#'+date_id+' input.hour').change(function() {

			var hour = $(this).val();

			// valid hour
			if (hour < 10) {
				hour = '0'+hour*1;
			} else if (hour >= 10 && hour <= 23) {
				hour = hour*1;
			} else {
				hour = "00";
			}

			$('#'+date_id+' input.hour').val(hour);

			ux_date_update(date_id);
		});

		// minute
		$('#'+date_id+' input.minute').change(function() {

			var minute = $(this).val();

			// valid minute
			if (minute < 10) {
				minute = '0'+minute*1;
			} else if (minute >= 10 && minute <= 59) {
				minute = minute*1;
			} else {
				minute = "00";
			}

			$('#'+date_id+' input.minute').val(minute);
			
			ux_date_update(date_id);
		});
	
	}

	// update ux date
	function ux_date_update(date_id) {
		
		var year = $('#'+date_id+' input.year').val();
		var month = $('#'+date_id+' select.month').val();
		var month_txt = $('#'+date_id+' select.month :selected').text();
		var day = $('#'+date_id+' input.day').val();
		var day_txt = day * 1;

		var hour = $('#'+date_id+' input.hour').val();
		var minute = $('#'+date_id+' input.minute').val();

		// set value
		var meta_value = year+'-'+month+'-'+day+' '+hour+':'+minute+':00';
		$('#'+date_id+' .meta_value').val(meta_value);
		
		// set display value
		var date = new Date(year, month-1, day);
		
		var weekday = date.getDay();
		if (weekday == 0) {
			weekday_txt = 'Sunday';
		} else if (weekday == 1) {
			weekday_txt = 'Monday';
		} else if (weekday == 2) {
			weekday_txt = 'Tuesday';
		} else if (weekday == 3) {
			weekday_txt = 'Wednesday';
		} else if (weekday == 4) {
			weekday_txt = 'Thursday';
		} else if (weekday == 5) {
			weekday_txt = 'Friday';
		} else if (weekday == 6) {
			weekday_txt = 'Saturday';
		}
		
		var display_value = weekday_txt+', ' +month_txt+' '+day_txt+', '+year+' @ '+hour+':'+minute;
		
		$('#'+date_id+' .display').html(display_value);
		
	}

});