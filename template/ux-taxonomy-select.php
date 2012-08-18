<?php 

/* 

// TAXONOMY SELECT

$this->add_template(array(
	'template' => 'ux-taxonomy-select.php',
	'post_id' => $post->ID,
	'taxonomy' => 'category',
));

*/

require_once('ux-taxonomy-select-get_children.php');

// get terms associated with post and set selected
$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'ids'));

// get first post term
if ($post_terms) {
	$selected = $post_terms[0];
} else if (isset($default_term)) {
	$selected = $default_term;
} else {
	$selected = 0;
}

?>

<select name="ux-taxonomy[<?php echo $post_id; ?>][<?php echo $taxonomy; ?>]">
<option value="">--</option>
<?php taxonomy_select_get_children($taxonomy, $selected); ?>
</select>