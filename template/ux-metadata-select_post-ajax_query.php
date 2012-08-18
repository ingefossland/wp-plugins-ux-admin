<?php

	require_once('../../../../wp-config.php');

	global $wpdb;

	// query
	$term = $_REQUEST['term'];
	
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
				$wpdb->posts.post_title LIKE '%$term%'
				OR $wpdb->posts.post_excerpt LIKE '%$term%'
				OR $wpdb->posts.post_content LIKE '%$term%'
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
				$wpdb->posts.post_title LIKE '%$term%'
				OR $wpdb->posts.post_excerpt LIKE '%$term%'
				OR $wpdb->posts.post_content LIKE '%$term%'
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

	// encode to json
	$output = json_encode($posts);

	echo $output;
		
?>