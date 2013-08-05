<?php

/* UX POOL

$this->add_template(array(
	'template' => 'ux-pool.php',
	'post_id' => $post->ID,
	'meta_key' => 'example_pool',
	'post_type' => 'post',
	'post_lang' => 'en',

	// make yer own stuff
	'ajax_url' => 'wp-content/plugins/ux-admin/template/ux-pool-query.php',
	'item_template' => 'wp-content/plugins/ux-admin/template/ux-pool-item.php'
));

*/

$meta_value = get_post_meta($post_id, $meta_key, true); 

?>

<div class="ux-pool" id="ux-pool-<?php echo $meta_key; ?>">

<?php if (isset($ajax_url)) { ?>
<input type="hidden" name="ajax_url" value="<?php echo $ajax_url; ?>" class="ajax_url" />
<?php } else { ?>
<input type="hidden" name="ajax_url" value="<?php echo WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)) . '/ux-pool-query.php'; ?>" class="ajax_url" />
<?php } ?>

<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
<input type="hidden" name="post_type" value="<?php echo $post_type; ?>" />
<input type="hidden" name="post_language" value="<?php echo $post_language; ?>" />
<input type="hidden" name="meta_key" value="<?php echo $meta_key; ?>" />
<input type="hidden" name="item_template" value="<?php echo $item_template; ?>" />

<input type="hidden" name="ux-meta[<?php echo $post_id; ?>][<?php echo $meta_key; ?>]" value="<?php echo $meta_value; ?>" class="meta_value" />

<div class="ux-pool-items">

<div class="ux-pool-empty">
Search and add items to pool (<?php echo $post_type; ?>).
</div>

<?php $pool = json_decode($meta_value, true); ?>

<?php 

if ($pool['posts']) { 
	foreach ($pool['posts'] as $item) {
		$item_id = $item['id'];
		if ($item_id) {
			if ($item_template) {
				include($item_template);
			} else {
				include("ux-pool-item.php");
			}
		}
	}
}

?>

</div>

<p><input type="text" name="search" /> <input type="button" class="ux-pool-search" value="Search" /></p>

<div class="ux-pool-query"></div>

</div>