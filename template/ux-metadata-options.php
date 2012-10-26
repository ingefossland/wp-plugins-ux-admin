<?php

/* OPTIONS

$this->add_template(array(
	'template' => 'ux-metadata-options.php',
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
	'template' => 'ux-metadata-options.php',
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

?>

<?php if ($meta_label) { ?>
<h4><?php echo $meta_label; ?> <em>(<?php echo $meta_key; ?>)</em></h4>
<?php } ?>

<?php foreach ($select as $option => $label) { ?>

	<?php if ($meta_value == $option) { ?>
	<label><input type="radio" class="ux-radio" name="<?php echo $meta_name; ?>" value="<?php echo $option; ?>" checked="checked" /> <?php echo $label; ?></label>
	<?php } else { ?>
	<label><input type="radio" class="ux-radio" name="<?php echo $meta_name; ?>" value="<?php echo $option; ?>" /> <?php echo $label; ?></label>
	<?php } ?>

<?php } ?>