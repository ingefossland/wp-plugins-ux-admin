<?php

/* GEOCODER

$this->add_template(array(
	'template' => 'ux-geocoder.php',
	'post_id' => $post->ID,
	'meta_key' => 'geocoder'
));

*/

// set geocoder keys

$geo_input = $meta_key . '-input';
$geo_latlng = $meta_key . '-latlng';
$geo_zoom = $meta_key . '-zoom';

// get geocoder values

$geo_input_value = get_post_meta($post_id, $meta_key . '-input', true);
$geo_latlng_value = get_post_meta($post_id, $meta_key . '-latlng', true);
$geo_zoom_value = get_post_meta($post_id, $meta_key . '-zoom', true);

?>

<span class="ux-geocoder" id="ux-geocoder-<?php echo $meta_key; ?>">

<?php if ($meta_label) { ?>
<h4><label for="<?php echo $geo_input; ?>"><?php echo $meta_label; ?> <em>(<?php echo $geo_input; ?>)</em></label></h4>
<?php } else { ?>
<h4><label for="<?php echo $geo_input; ?>"><strong>Input location</strong> <em>(<?php echo $geo_input; ?>)</em></label></h4>
<?php } ?>

<div id="geocoder">
	<p>
		<input type="text" name="ux-meta[<?php echo $post_id; ?>][<?php echo $geo_input; ?>]" value="<?php echo $geo_input_value; ?>" id="geocoder-input" size="55" />
		<input type="button" value="Zoom to place" id="geocoder-submit" />
	</p>
</div>

<div id="geocoder-display">
    <div id="geocoder-map"></div>
    <div id="geocoder-crosshair"></div>
</div>

<h4><label for="<?php echo $geo_zoom; ?>"><strong>Zoom level</strong> <em>(<?php echo $geo_zoom; ?>)</em></label> and <label for="<?php echo $geo_latlng; ?>"><strong>Latitude, longitude</strong> <em>(<?php echo $geo_latlng; ?>)</em></label></h4>
<p><input type="text" name="ux-meta[<?php echo $post_id; ?>][<?php echo $geo_zoom; ?>]" value="<?php echo $geo_zoom_value; ?>" id="geocoder-zoom" size="3" /> <input type="text" name="ux-meta[<?php echo $post_id; ?>][<?php echo $geo_latlng; ?>]" value="<?php echo $geo_latlng_value; ?>" id="geocoder-latlng" size="55" /></p>

<ul>
<li><strong>Latitude, Longitude:</strong> <span id="latlon"></span></li>
<li><strong>WKT:</strong> <span id="wkt"></span></li>
<li><strong>Google Maps zoom level:</strong> <span id="zoom"></span></li>
<li id="timezonep" style="display: none"><strong>Timezone:</strong> <span id="timezone"></span></li>
<li id="datetimep" style="display: none"><strong>Local time:</strong> <span id="datetime"></span></li>
</ul>

</span>