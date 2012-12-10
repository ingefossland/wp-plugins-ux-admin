<?php

	require_once('../../../../wp-config.php');

	global $wpdb;

	// query
	//$post_id = $_REQUEST['post_id'];
	$post_title = $_REQUEST['post_title'];
	$post_type = $_REQUEST['post_type'];

	// post type
	if ($post_type) {
		$post_type_query = "$wpdb->posts.post_type = '$post_type'"; 
	}	
	
	// query posts
	if ($post_type) {

		$posts = $wpdb->get_results("
			SELECT DISTINCT(ID) as id, post_title AS value FROM $wpdb->posts 
			WHERE $wpdb->posts.ID != '$post_id'
			AND $wpdb->posts.post_type = '$post_type'
			AND (
				$wpdb->posts.post_status = 'publish'
				OR $wpdb->posts.post_status = 'draft'
			)
			AND (
				$wpdb->posts.post_title LIKE '%$post_title%'
				OR $wpdb->posts.post_excerpt LIKE '%$post_title%'
				OR $wpdb->posts.post_content LIKE '%$post_title%'
			)
			ORDER BY $wpdb->posts.post_title ASC
			LIMIT 10
			", 
		OBJECT);	

	} else {

		$posts = $wpdb->get_results("
			SELECT DISTINCT(ID) as id, post_title AS value FROM $wpdb->posts 
			WHERE $wpdb->posts.ID != '$post_id'
			AND (
				$wpdb->posts.post_status = 'publish'
				OR $wpdb->posts.post_status = 'draft'
			)
			AND (
				$wpdb->posts.post_title LIKE '%$post_title%'
				OR $wpdb->posts.post_excerpt LIKE '%$post_title%'
				OR $wpdb->posts.post_content LIKE '%$post_title%'
			) 
			ORDER BY $wpdb->posts.post_title ASC
			LIMIT 10
			", 
		OBJECT);	
	
	}
	
	$new_id = count($posts)+0;
	
	// add new
//	$posts[$new_id]->id = 'new';
//	$posts[$new_id]->value = '+ Add new' . $post_type;

	// clear input
	$posts[$new_id]->id = '0';
	$posts[$new_id]->value = '- Clear';

	// debug
//	$posts[$new_id+1]->id = '0';
//	$posts[$new_id+1]->value = $post_title . ' (' .$post_type. ')';

	// encode to json
	$output = json_encode($posts);

	echo $output;
		
?>