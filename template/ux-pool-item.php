<?php 

$item = get_post($item_id); 

// time

if ( '0000-00-00 00:00:00' == $item->post_date && 'date' == $column_name ) {
	$t_time = $h_time = __('Unpublished');
} else {
	$t_time = get_the_time(__('Y/m/d g:i:s A'));
	$m_time = $item->post_date;
	$time = get_post_time( 'G', true, $item, false );
	if ( ( abs($t_diff = time() - $time) ) < 86400 ) {
		if ( $t_diff < 0 )
			$h_time = sprintf( __('%s from now'), human_time_diff( $time ) );
		else
			$h_time = sprintf( __('%s ago'), human_time_diff( $time ) );
	} else {
		$h_time = mysql2date(__('Y/m/d'), $m_time);
	}
}

// parent

if ($item->post_parent) {
	$item_parent = get_post($item->post_parent);
	$item->parent = "<em>Parent: <strong>" . $item_parent->post_title . "</strong></em>";
}

?>

<div class="ux-pool-item" id="ux-pool-<?php echo $meta_key; ?>-item-<?php echo $item_id; ?>">
	<div class="ux-pool-handle">
        <div class="ux-pool-order"><input type="text" name="ux-pool[<?php echo $item_id; ?>][menu_order]" value="<?php echo $item->menu_order; ?>" size="3" disabled="disabled" class="ux-pool-item-order" /></div>
		<div class="ux-pool-description"><strong><?php echo $item->post_title; ?></strong> (<?php echo $h_time; ?>) <?php echo $item->parent; ?></div>
		<div class="ux-pool-action"><a href="#" class="add">Add</a> <a href="#" class="remove">Remove</a></div>
	</div>
</div>