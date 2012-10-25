<?php

/* TEXT INPUT

$this->add_template(array(
	'template' => 'ux-metadata-text.php',
	'post_id' => $post->ID,
	'meta_key' => 'short_text',
	'size' => 60,
	'class' => '',
));

// TEXTAREA

$this->add_template(array(
	'template' => 'ux-metadata-text.php',
	'post_id' => $post->ID,
	'meta_key' => 'long_text',
	'cols' => 60,
	'rows' => 3,
	'class' => '',
));

// ADD SETTINGS

$this->add_template(array(
	'template' => 'ux-metadata-text.php',
	'settings_key' => 'x',
	'cols' => 60,
	'rows' => 3,
	'class' => '',
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
<h4><label for="<?php echo $meta_id; ?>"><?php echo $meta_label; ?> <em>(<?php echo $meta_key; ?>)</em></label></h4>
<?php } ?>

<?php if (isset($rows) && $rows > 1) { ?>
<textarea class="ux-textarea <?php echo $class; ?>" name="<?php echo $meta_name; ?>" id="<?php echo $meta_id; ?>" cols="<?php echo $cols; ?>" rows="<?php echo $rows; ?>" class="<?php echo $class; ?>" /><?php echo $meta_value; ?></textarea>
<?php } else { ?>
<input type="text" class="ux-text <?php echo $class; ?>" name="<?php echo $meta_name; ?>" value="<?php echo $meta_value; ?>" id="<?php echo $meta_id; ?>" size="<?php echo $size; ?>" />
<?php } ?>