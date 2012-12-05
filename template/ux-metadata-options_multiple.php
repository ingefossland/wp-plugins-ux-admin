<?php

/* OPTIONS

$this->add_template(array(
	'template' => 'ux-metadata-options_multiple.php',
	'post_id' => $post->ID,
	'meta_key' => 'options_key',
	'select' => array(
		'1' => 'Label 1',
		'2' => 'Label 2',
		'3' => 'Label 3',
	)
));

// ADD SETTINGS

$this->add_template(array(
	'template' => 'ux-metadata-options_multiple.php',
	'settings_key' => 'x',
	'select' => array(
		'1' => 'Label 1',
		'2' => 'Label 2',
		'3' => 'Label 3',
	)
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

// decode json
$meta_values = json_decode($meta_value, true);

?>

<div class="ux-metadata-options_multiple" id="<?php echo $meta_id; ?>">

<?php if ($meta_label) { ?>
<h4><?php echo $meta_label; ?> <em>(<?php echo $meta_key; ?>)</em></h4>
<?php } ?>

<input type="hidden" name="<?php echo $meta_name; ?>" value="<?php echo $meta_value; ?>" class="meta_value" />

<?php foreach ($select as $option => $label) { ?>
	<?php if (in_array($option, $meta_values)) { ?>
		<label><input type="checkbox" class="ux-checkbox" value="<?php echo $option; ?>" checked="checked" /> <?php echo $label; ?></label>
	<?php } else { ?>
		<label><input type="checkbox" class="ux-checkbox" value="<?php echo $option; ?>" /> <?php echo $label; ?></label>
	<?php } ?>
<?php } ?>

</div>