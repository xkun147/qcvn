<?php
function register_ads_post_type(){
	register_post_type('ads', array(
		'labels' => array(
			'name' => __('Ads','framework' ),
			'singular_name' => __('Ad', 'framework' ),
			'add_new' => __('Add New','framework' ),
			'add_new_item' => __('Add New ad', 'framework' ),
			'edit_item' => __('Edit ad', 'framework' ),
			'new_item' => __('New ad', 'framework' ),
			'view_item' => __('View ad', 'framework' ),
			'search_items' => __('Search in ads', 'framework' ),
			'not_found' =>  __('No ads found', 'framework' ),
			'not_found_in_trash' => __('No ads found in Trash', 'framework' ), 
			'parent_item_colon' => '',
			'menu_name' => __('Ads System', 'framework' ),
		),
		'singular_label' => __('ads', 'framework' ),
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 22,
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array('title'),
		'has_archive' => false,
		'rewrite' => array( 'slug' => 'ad', 'with_front' => true, 'pages' => true, 'feeds'=>false ),
		'query_var' => false,
		'can_export' => true,
		'show_in_nav_menus' => false,
		 'menu_icon' => 'dashicons-feedback'
	));

	
}
add_action('init','register_ads_post_type');