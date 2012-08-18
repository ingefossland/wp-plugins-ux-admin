<?php

/*
Plugin Name: UX admin
Plugin URI: http://fossland.com/
Description: Metadata and taxonomy handler for WordPress.
Author: Inge Fossland
Version: 1.2
Author URI: http://fossland.com/
*/

class ux_admin {
	
	// SETUP
	
	function ux_admin() {

		// scripts and styles
		add_action('admin_init', array(&$this, 'ux_admin_scripts_and_styles'));
		
		// settings
		add_action('admin_menu', array(&$this, 'ux_admin_settings_menu'));
		add_action('admin_init', array(&$this, 'ux_admin_register_settings'));
		
		// post metadata
		add_action('save_post', array(&$this, 'save_post_metadata'));
		add_action('save_post', array(&$this, 'save_post_taxonomy'));
	
		// term metadata
		add_action('init', array(&$this, 'create_term_metadata'));
		add_action('edited_term', array(&$this, 'save_term_metadata'));
		add_action('delete_term', array(&$this, 'delete_term_metadata'));
	
	}

	// ADMIN INIT
	
	function ux_admin_scripts_and_styles() {
		
		// add library scripts and styles
		wp_enqueue_style('jquery-autocomplete', plugins_url('/lib/jquery.ui.autocomplete.css', __FILE__));
		wp_enqueue_script('jquery-autocomplete', plugins_url('/lib/jquery.ui.autocomplete.min.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-position', 'jquery-ui-widget'));

		// get google maps key
		$gmap_api_key = get_option("ux-geocoder-gmap_api_key");

		// google maps
		wp_enqueue_script('ux-geocoder-googlemaps', 'http://www.google.com/jsapi?key='.$gmap_api_key);
		
		// add scripts and styles from content modules
		if ($handle = opendir(WP_PLUGIN_DIR . '/ux-admin/template/')) {
			while (false !== ($file = readdir($handle))) {
				if (substr($file, -4) == ".css") {
					wp_enqueue_style(substr($file, 0, -4), WP_PLUGIN_URL . '/ux-admin/template/' . $file);
				} else if (substr($file, -3) == ".js") {
					wp_enqueue_script(substr($file, 0, -3), WP_PLUGIN_URL . '/ux-admin/template/' . $file);
				}
			}
			closedir($handle);
		}
	
	}
	
	// SETTINGS
	
	function ux_admin_register_settings() {

		register_setting('ux-admin', 'ux-geocoder-gmap_api_key');
		register_setting('ux-admin', 'ux-geocoder-gmap_api_key_v3');

	}
	
	function ux_admin_settings_menu() {

    	$ux_admin_settings_page = add_options_page(__('UX admin Settings'), __('UX admin'), 'manage_options', 'ux_admin', array(&$this, 'ux_admin_settings_page'));  
		
	}

	function ux_admin_settings_page() {
	
		include('ux-admin-options.php');

	}
		
	// ADD TEMPLATE
	
	function add_template($options = '') {

		// export options array as variables
		if ($options) { extract($options, EXTR_SKIP); }

		// add template if found
		if ($template && file_exists(WP_PLUGIN_DIR. '/ux-admin/template/' . $template)) {
			include('template/'.$template);
		} else {
			echo 'Template <strong>' . $template . '</strong> not found.';
		}

	}
	
	// SAVE POST METADATA
 	
	function save_post_metadata($post_id) {  

		// verify
		if (!current_user_can('edit_posts')) {
			return $post_id;
		} 

		// save metadata
		if (!empty($_POST['ux-meta'])) {
			foreach ($_POST['ux-meta'] as $post_id => $meta) {
				
				foreach ($meta as $meta_key => $meta_value) {

					if (isset($meta_value)) {

					    update_metadata('post', $post_id, $meta_key, $meta_value);

					}
					
				}
	
			}
		
		}
		
	}

	
	// SAVE POST TAXONOMY
 	
	function save_post_taxonomy($post_id) {  

		if (!empty($_POST['ux-taxonomy'])) {
			foreach ($_POST['ux-taxonomy'] as $post_id => $post_taxonomy) {

				foreach ($post_taxonomy as $taxonomy => $term) {

					if (isset($term)) {
						wp_set_post_terms($post_id, $term, $taxonomy);
					}
					
				}
	
			}
		
		}
		
	}

	// TERM METADATA
	
	function create_term_metadata() {

		$charset_collate = "";

		if (!empty($wpdb->charset)) {
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		}

		if (!empty($wpdb->collate)) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}
		
		// create table

		global $wpdb;

		$wpdb->termmeta = $wpdb->prefix . 'termmeta';

		$wpdb->query("CREATE TABLE IF NOT EXISTS $wpdb->termmeta (
			meta_id bigint(20) unsigned NOT NULL auto_increment,
			term_id bigint(20) unsigned NOT NULL default '0',
			meta_key varchar(255) default NULL,
			meta_value longtext,
			PRIMARY KEY  (meta_id),
			KEY term_id (term_id),
			KEY meta_key (meta_key)
		) $charset_collate");

	}
	
	// SAVE TERM METADATA
 	
	function save_term_metadata($term_id) {  

		if (!empty($_POST['ux-meta'])) {
			foreach ($_POST['ux-meta'] as $term_id => $meta) {
				
				foreach ($meta as $meta_key => $meta_value) {

					if (isset($meta_value)) {

					    update_metadata('term', $term_id, $meta_key, $meta_value);
	
					}
					
				}
	
			}
		
		}
				
	}

	// DELETE TERM METADATA

	function delete_term_metadata($term_id) {  

		global $wpdb;

		$wpdb->query("DELETE FROM $wpdb->termmeta WHERE term_id = '$term_id'");
				
	}

}

?>