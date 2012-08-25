<?php

/* TEXT INPUT

$this->add_template(array(
	'template' => 'ux-metadata-text.php',
	'post_id' => $post->ID,
	'meta_key' => 'short_text',
	'size' => 60
));

// TEXTAREA

$this->add_template(array(
	'template' => 'ux-metadata-text.php',
	'post_id' => $post->ID,
	'meta_key' => 'long_text',
	'cols' => 60,
	'rows' => 3
));

*/

$meta_value = get_post_meta($post_id, $meta_key, true);

?>

<?php if ($meta_label) { ?>
<h4><label for="ux-meta-<?php echo $meta_key; ?>"><?php echo $meta_label; ?> <em>(<?php echo $meta_key; ?>)</em></label></h4>
<?php } ?>

<?php if (isset($rows) && $rows > 1) { ?>
<textarea class="ux-textarea" name="ux-meta[<?php echo $post_id; ?>][<?php echo $meta_key; ?>]" id="ux-meta-<?php echo $meta_key; ?>" cols="<?php echo $cols; ?>" rows="<?php echo $rows; ?>"/><?php echo $meta_value; ?></textarea>
<?php } else { ?>
<input type="text" class="ux-text"  name="ux-meta[<?php echo $post_id; ?>][<?php echo $meta_key; ?>]" value="<?php echo $meta_value; ?>" id="ux-meta-<?php echo $meta_key; ?>" size="<?php echo $size; ?>" />
<?php } ?>