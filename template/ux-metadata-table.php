<?php

/* SORTABLE TABLE

$this->add_template(array(
	'template' => 'ux-metadata-table.php',
	'post_id' => $post->ID,
	'meta_key' => 'example_table',
	'cols' => 3,
));

// ADD SETTINGS

$this->add_template(array(
	'template' => 'ux-metadata-table.php',
	'settings_key' => 'x',
	'cols' => 3,
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

<div class="ux-table" id="<?php echo $meta_id; ?>">

<p><input type="hidden" name="<?php echo $meta_name; ?>" value="<?php echo htmlentities($meta_value); ?>" class="meta_value" /></p>

<table>

	<thead>
		<tr>
			<?php for ($i = 0; $i <= $cols-1; $i++) { ?>
			<th><?php echo $labels[$i]; ?></th>
			<?php } ?>
			<th></th>
		</tr>
	</thead>
	
	<tfoot>
		<tr class="new" style="display: none">
			<?php for ($i = 1; $i <= $cols; $i++) { ?>
			<td><input type="text" value="" size="" /></td>
			<?php } ?>
			<td class="remove"><a href="#">Remove</a></td>
		</tr>
		<tr>
			<td colspan="<?php echo $cols+1; ?>"><a href="#" class="add">Add row</a></td>
		</tr>
	</tfoot>

<?php $rows = json_decode($meta_value, true); ?>

<tbody>
<?php foreach ($rows as $row) { ?>
<tr>
	<?php for ($i = 0; $i <= $cols-1; $i++) { ?>
	<td><input type="text" value="<?php echo $row[$i]; ?>" size="" /></td>
	<?php } ?>
	<td class="remove"><a href="#">Remove</a></td>
</tr>
<?php } ?>
</tbody>


</div>