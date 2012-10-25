<?php

/* DATE 

$this->add_template(array(
	'template' => 'ux-metadata-date.php',
	'post_id' => $post->ID,
	'meta_key' => 'example_date'
));

// ADD SETTINGS

$this->add_template(array(
	'template' => 'ux-metadata-date.php',
	'settings_key' => 'date_settings_key',
));

*/

if ($settings_key) {

	$meta_id = 'ux-meta-' . $settings_key;
	$meta_key = $settings_key;
	$meta_name = $settings_key;
	$meta_value = get_option($settings_key);

} else {

	$meta_id = 'ux-meta-' . $meta_key;
	$meta_name = 'ux-meta['.$post_id.']['.$meta_key.']';
	$meta_value = get_post_meta($post_id, $meta_key, true);
	
}

global $wp_locale;

$year = substr($meta_value, 0, 4);
$month = substr($meta_value, 5, 2);
$day = substr($meta_value, 8, 2);
$hour = substr($meta_value, 11, 2);
$min = substr($meta_value, 14, 2);

$time_adj = current_time('timestamp');

if (empty($month)) {
	$month = gmdate('m', $time_adj);
}

if (empty($day)) {
	$day = gmdate('d', $time_adj);
}

if (empty($year)) {
	$year = gmdate('Y', $time_adj);
}

if (empty($hour)) {
	$hour = gmdate('H', $time_adj);
}

if (empty($min)) {
	$min = '00';
}

if (empty($sec)) {
	$sec = '00';
}

?>

<span class="ux-date" id="<?php echo $meta_id; ?>">

<input type="hidden" class="meta_value" name="<?php echo $meta_name; ?>" value="<?php echo $meta_value; ?>" id="<?php echo $meta_id; ?>" />

<?php if ($meta_label) { ?>
<h4><label for="<?php echo $meta_id; ?>"><?php echo $meta_label; ?> <em>(<?php echo $meta_key; ?>)</em></label></h4>
<?php } ?>

<select class="month" name=\"_month\">

<?php for ($i = 1; $i < 13; $i++) { ?>
	<?php if ($i == $month) { ?>
        <option value="<?php echo zeroise($i, 2) ?>" selected="selected"><?php echo $wp_locale->get_month_abbrev($wp_locale->get_month($i)); ?></option>
    <?php } else { ?>
        <option value="<?php echo zeroise($i, 2) ?>"><?php echo $wp_locale->get_month_abbrev($wp_locale->get_month($i)); ?></option>
    <?php } ?>
<?php } ?>

</select>

<input type="text" class="day" name="_day" value="<?php echo $day; ?>" size="2" maxlength="2" />,
<input type="text" class="year" name="_year" value="<?php echo $year; ?>" size="4" maxlength="4" /> @

<input type="text" class="hour" name="_hour" value="<?php echo $hour; ?>" size="2" maxlength="2"/> :
<input type="text" class="minute" name="_minute" value="<?php echo $min; ?>" size="2" maxlength="2" />

<span class="display"></span>

</span>