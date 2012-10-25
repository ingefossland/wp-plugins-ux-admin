<?php

/* UX POOL

$this->add_template(array(
	'template' => 'ux-list.php',
	'post_id' => $post->ID,
	'meta_key' => 'example_pool',
	'post_type' => 'post',

	// make yer own stuff
	'ajax_url' => 'wp-content/plugins/ux-metadata/template/ux-pool-query.php',
	'item_template' => 'wp-content/plugins/ux-metadata/template/ux-pool-item.php'
));

// ADD SETTINGS

$this->add_template(array(
	'template' => 'ux-list.php',
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

<div class="ux-list" id="<?php echo $meta_id; ?>">

<p><input type="hidden" name="<?php echo $meta_name; ?>" value="<?php echo htmlentities($meta_value); ?>" class="meta_value" /></p>

<div class="ux-list-rows">
<?php $rows = json_decode($meta_value, true); ?>
<?php foreach ($rows as $title => $descr) { ?>
<?php include("ux-list-row.php"); ?>
<?php } ?>
</div>

<div class="ux-list-new" style="display: none">
<?php $title = ""; $descr = ""; ?>
<?php include("ux-list-row.php"); ?>
</div>

<div class="ux-list-add">
<p><a href="#" class="add">Add row</a></p>
</div>

</div>