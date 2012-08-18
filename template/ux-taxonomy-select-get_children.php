<?php 

// select taxonomy children

function taxonomy_select_get_children($taxonomy, $selected, $parent = '', $level = 0) {
	
	$terms = get_terms($taxonomy, 'orderby=name&parent='.$parent.'&hide_empty=0');
	
	if ($terms) {
		foreach ($terms as $term) { 
			if ($term->term_id == $selected) {
				echo '<option value="'.$term->term_id.'" class="'.$term->slug.'" selected="selected">';
			} else {
				echo '<option value="'.$term->term_id.'" class="'.$term->slug.'">';
			}
			
			if ($level > 0) {
				echo str_repeat('-', $level*2) . ' ';
			}
			
			echo $term->name;
			echo '</option>';
			
			// get children
			taxonomy_select_get_children($taxonomy, $selected, $term->term_id, $level+1);
		}
	}

}

?>