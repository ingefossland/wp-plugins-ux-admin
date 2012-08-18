<?php

/* SELECT POST

$this->add_template(array(
	'template' => 'ux-metadata-select_post.php',
	'post_id' => $post->ID,
	'meta_key' => 'select_post'
));

*/

global $wpdb;

// meta value may be set outside
$meta_value = get_post_meta($post_id, $meta_key, true); 

// find title
if (isset($meta_value)) {
	$meta_title = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE ID = $meta_value");
}

?>

<span class="ux-metadata-select_post" id="ux-meta-<?php echo $meta_key; ?>">
<input type="hidden" value="../wp-content/plugins/ux-admin/template/ux-metadata-select_post-ajax_query.php" class="ajax_url" />
<input type="hidden" name="ux-meta[<?php echo $post_id; ?>][<?php echo $meta_key; ?>]" value="<?php echo $meta_value; ?>" class="post_value" />

<?php if ($meta_title) { ?>
<input type="text" name="ux-meta[<?php echo $post_id; ?>][<?php echo $meta_key; ?>_name]" value="<?php echo $meta_title; ?>" class="post_title on" />
<?php } else { ?>
<input type="text" name="ux-meta[<?php echo $post_id; ?>][<?php echo $meta_key; ?>_name]" value="<?php echo $meta_title; ?>" class="post_title" />
<?php } ?>

<span class="suggest"></span>
</span>