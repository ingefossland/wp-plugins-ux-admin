google.load('maps', '2'); // Load version 2 of the Maps API

function timezoneLoaded(obj) {
    var timezone = obj.timezoneId;
    if (!timezone) {
        return;
    }
    document.getElementById('timezone').innerHTML = timezone;
    document.getElementById('timezonep').style.display = 'block';
    // Find out what time it is there
    var s = document.createElement('script');
    s.src = "http://json-time.appspot.com/time.json?callback=timeLoaded&tz=" + timezone;
    s.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(s);
}

function timeLoaded(obj) {
    if (obj.datetime) {
        document.getElementById('datetime').innerHTML = obj.datetime;
        document.getElementById('datetimep').style.display = 'block';        
    }
}

function updateLatLonFields(lat, lon) {
    document.getElementById("latlon").innerHTML = lat + ', ' + lon;
    document.getElementById("wkt").innerHTML = 'POINT('+lon+' '+lat +')';
	document.getElementById('geocoder-latlng').value = lat + ', ' + lon;
}

function showMap() {
    window.gmap = new google.maps.Map2(document.getElementById('geocoder-map'));
    gmap.addControl(new google.maps.LargeMapControl());
    gmap.addControl(new google.maps.MapTypeControl());
    gmap.enableContinuousZoom();
    gmap.enableScrollWheelZoom();
    
    var timer = null;
    
    google.maps.Event.addListener(gmap, "move", function() {
        var center = gmap.getCenter();
        updateLatLonFields(center.lat(), center.lng());
        
        // Wait a second, then figure out the timezone
        if (timer) {
            clearTimeout(timer);
            timer = null;
        }
        timer = setTimeout(function() {
            document.getElementById('timezonep').style.display = 'none';
            document.getElementById('datetimep').style.display = 'none';
            // Look up the timezone using geonames
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.src = "http://ws.geonames.org/timezoneJSON?lat=" + center.lat() +
                "&lng=" + center.lng() + "&callback=timezoneLoaded";
            document.getElementsByTagName("head")[0].appendChild(s);
        }, 1500);
        
    });
    google.maps.Event.addListener(gmap, "zoomend", function(oldZoom, newZoom) {
        document.getElementById("zoom").innerHTML = newZoom;
		document.getElementById('geocoder-zoom').value = newZoom;
    });
    google.maps.Event.addDomListener(document.getElementById('geocoder-crosshair'),
        'dblclick', function() {
            gmap.zoomIn();
        }
    );
	
	var saved_location = document.getElementById('geocoder-latlng').value;
	var saved_zoom = document.getElementById('geocoder-zoom').value * 1;
	

	// Zoom to saved location or default view

	if (saved_location && saved_zoom) {

		var saved_latlng = saved_location.split(",");
		var saved_lat = saved_latlng[0];
		var saved_lng = saved_latlng[1];
			
		gmap.setCenter(
			new google.maps.LatLng(saved_lat, saved_lng), saved_zoom
		);

	} else {

		gmap.setCenter(
			new google.maps.LatLng(43.834526782236814, -37.265625), 3
		);

	}

    /* If we have a best-guess for the user's location based on their IP, 
       show a "zoom to my location" link */
    if (google.loader.ClientLocation) {
        var link = document.createElement('a');
        link.onclick = function() {
            gmap.setCenter(
                new google.maps.LatLng(
                    google.loader.ClientLocation.latitude,
                    google.loader.ClientLocation.longitude
                ), 8
            );
            return false;
        }
        link.href = '#'
        link.appendChild(
            document.createTextNode('Zoom to my location (by IP)')
        );
        var form = document.getElementById('geocoder');
        var p = form.getElementsByTagName('p')[0];
        p.appendChild(link);
    }
    
    // Set up Geocoder
    window.geocoder = new google.maps.ClientGeocoder();
    
	// zoom to place if input
/*	var saved_location = document.getElementById('geocoder-input').value;

	if (saved_location) {
		geocode(saved_location);
	}
*/

	// zoom to place
    var geocodeSubmit = document.getElementById('geocoder-submit');
	geocodeSubmit.onclick = function() {
		var location = document.getElementById('geocoder-input').value;
		geocode(location);
	}

}

var accuracyToZoomLevel = [
    1,  // 0 - Unknown location
    5,  // 1 - Country
    6,  // 2 - Region (state, province, prefecture, etc.)
    8,  // 3 - Sub-region (county, municipality, etc.)
    11, // 4 - Town (city, village)
    13, // 5 - Post code (zip code)
    15, // 6 - Street
    16, // 7 - Intersection
    17, // 8 - Address
    17  // 9 - Premise
];

function geocodeComplete(result) {
    if (result.Status.code != 200) {
        alert('Could not geocode "' + result.name + '"');
        return;
    }
    var placemark = result.Placemark[0]; // Only use first result
    var accuracy = placemark.AddressDetails.Accuracy;
    var zoomLevel = accuracyToZoomLevel[accuracy] || 1;
    var lon = placemark.Point.coordinates[0];
    var lat = placemark.Point.coordinates[1];
    gmap.setCenter(new google.maps.LatLng(lat, lon), zoomLevel);
}

function geocode(location) {
    geocoder.getLocations(location, geocodeComplete);
}

google.setOnLoadCallback(showMap);