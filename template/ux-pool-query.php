<?php

	require_once('../../../../wp-config.php');

	global $wpdb;

	// meta key and value
	$post_id = $_REQUEST['post_id'];
	$meta_key = trim($_REQUEST['meta_key']);
	$meta_value = stripslashes($_REQUEST['ux-meta'][$post_id][$meta_key]);
	
	// pool id
	$pool_id = "ux-pool-" . $meta_key;
	
	// query
	$query_search = $_REQUEST['search'];

	// query options
	$query_scope = $_REQUEST['query_scope'];
	
	if (!$query_limit = $_REQUEST['query_limit']) {
		$limit_query = 10;
	}

	// post type
	$post_type = $_REQUEST['post_type'];

	// post language
	$post_language = $_REQUEST['post_language'];

	// item template
	$item_template = $_REQUEST['item_template'];

	// exclude ids already in pool
	if ($meta_value) {
		$pool = json_decode($meta_value, true);
		$exclude = array();
		foreach ($pool['posts'] as $item) {
			$item_id = $item['id'];
			if ($item_id) {
				array_push($exclude, $item_id); // add id in pool
			}
		}
		array_push($exclude, $post_id); // add current id to exclude
		$query_exclude = implode(",",$exclude);		
	} else {
		$query_exclude = $post_id; // exclude current id
	}
	
	// query all or just title

	if ($query_scope == 'all') {

		$scope_query = "$wpdb->posts.post_title LIKE '%$query_search%'"
			."OR $wpdb->posts.post_excerpt LIKE '%$query_search%'"
			."OR $wpdb->posts.post_content LIKE '%$query_search%'";
		
	} else {

		$scope_query = "$wpdb->posts.post_title LIKE '%$query_search%'";
		
	}
		
	// query posts for use with wpml
	//if (ICL_LANGUAGE_CODE == 'en' || ICL_LANGUAGE_CODE == 'nb') {	
	if ($post_language == 'nb') {
		$wpdb->translations = $wpdb->prefix . 'icl_translations';

		$posts = $wpdb->get_results("
			SELECT DISTINCT(ID), post_title
			FROM $wpdb->posts 
			LEFT JOIN $wpdb->translations AS translations ON (
				$wpdb->posts.ID = translations.element_id
			)
			WHERE $wpdb->posts.post_type = '$post_type'
			AND (
				$wpdb->posts.post_status = 'publish'
				OR $wpdb->posts.post_status = 'draft'
			)
			AND $wpdb->posts.ID NOT IN ($query_exclude) 
			AND (
				$scope_query
			)
			AND translations.element_type = 'post_$post_type'
			AND translations.language_code != 'en'
			ORDER BY $wpdb->posts.post_title ASC
			LIMIT $limit_query
			", 
		OBJECT);	

	// regular query posts
	} else {

		$posts = $wpdb->get_results("
			SELECT DISTINCT(ID), post_title
			FROM $wpdb->posts 
			WHERE $wpdb->posts.post_type = '$post_type'
			AND (
				$wpdb->posts.post_status = 'publish'
				OR $wpdb->posts.post_status = 'draft'
			)
			AND $wpdb->posts.ID NOT IN ($query_exclude) 
			AND (
				$scope_query
			)
			ORDER BY $wpdb->posts.post_title ASC
			LIMIT $limit_query
			", 
		OBJECT);	
		
	}

	// no hits? try regular query posts
	/*
	if (!$posts) {

		$posts = $wpdb->get_results("
			SELECT DISTINCT(ID), post_title
			FROM $wpdb->posts 
			WHERE $wpdb->posts.post_type = '$post_type'
			AND (
				$wpdb->posts.post_status = 'publish'
				OR $wpdb->posts.post_status = 'draft'
			)
			AND $wpdb->posts.ID NOT IN ($query_exclude) 
			AND (
				$wpdb->posts.post_title LIKE '%$query_search%'
				OR $wpdb->posts.post_excerpt LIKE '%$query_search%'
				OR $wpdb->posts.post_content LIKE '%$query_search%'
			)
			ORDER BY $wpdb->posts.post_title ASC
			LIMIT 10
			", 
		OBJECT);	
		
	}
	*/
	
	if ($posts) {
		foreach ($posts as $item) {
			
			$item_id = $item->ID;
			
			if ($item_template) {
				include("ux-pool-item-".$item_template.".php");
			} else if ($query_scope == "post") {
				include("ux-pool-item.php");
			} else if ($query_scope == "page") {
				include("ux-pool-item.php");
			} else if ($query_scope == "media") {
				include("ux-pool-item-media.php");
			} else {
				include("ux-pool-item.php");
			}
			
		}
	} else {
		echo '<p>No result ('.$post_type.')</p>';
	}
		
?>