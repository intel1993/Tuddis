<?php
//-----------------------------------*/
// Setup Portfolio Post type
//-----------------------------------*/
if( ! function_exists( 'village_portfolio_setup_post_type' ) ) {
	function village_portfolio_setup_post_type() {

		$labels = array(
			'name'                => _x( 'Entries', 'Post Type General Name', 'pure' ),
			'singular_name'       => _x( 'Entry', 'Post Type Singular Name', 'pure' ),
			'menu_name'           => __( 'Portfolio', 'pure' ),
			'parent_item_colon'   => __( 'Parent Entry', 'pure' ),
			'all_items'           => __( 'All Entries', 'pure' ),
			'view_item'           => __( 'View Entries', 'pure' ),
			'add_new_item'        => __( 'Add New Entry', 'pure' ),
			'add_new'             => __( 'New Entry', 'pure' ),
			'edit_item'           => __( 'Edit Entry', 'pure' ),
			'update_item'         => __( 'Update Entry', 'pure' ),
			'search_items'        => __( 'Search portfolio', 'pure' ),
			'not_found'           => __( 'No entries found', 'pure' ),
			'not_found_in_trash'  => __( 'No entries found in Trash', 'pure' ),
		);

		$args = array(
			'label'               => __( 'portfolio', 'pure' ),
			'description'         => __( 'Portfolio', 'pure' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', ),
			'taxonomies'          => array( 'projects', 'skills' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon' 		  => 'dashicons-portfolio',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'rewrite'			  => array( 'slug' => sanitize_title( Village::get_theme_mod('portfolio_slug', 'portfolio' ) ) )
		);

		register_post_type( 'portfolio', $args );
	}

	add_action( 'init', 'village_portfolio_setup_post_type', 5 );
}

/* -----------------------------------*/
/* 		Setup Taxonomy
/* -----------------------------------*/
if( ! function_exists( 'village_portfolio_setup_taxonomies' ) ) {
	function village_portfolio_setup_taxonomies()  {

		$labels = array(
			'name'                       => _x( 'Projects', 'Taxonomy General Name', 'village' ),
			'singular_name'              => _x( 'Project', 'Taxonomy Singular Name', 'village' ),
			'menu_name'                  => __( 'Projects', 'village' ),
			'all_items'                  => __( 'All Project', 'village' ),
			'parent_item'                => __( 'Parent Project', 'village' ),
			'parent_item_colon'          => __( 'Parent Project:', 'village' ),
			'new_item_name'              => __( 'New Project Name', 'village' ),
			'add_new_item'               => __( 'Add New Project', 'village' ),
			'edit_item'                  => __( 'Edit Project', 'village' ),
			'update_item'                => __( 'Update Project', 'village' ),
			'separate_items_with_commas' => __( 'Separate projects with commas', 'village' ),
			'search_items'               => __( 'Search projects', 'village' ),
			'add_or_remove_items'        => __( 'Add or remove projects', 'village' ),
			'choose_from_most_used'      => __( 'Choose from the most used projects', 'village' ),
		);

		$args = array(
			'labels' 					 => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'rewrite' 					 => array( 'slug' => sanitize_title( Village::get_theme_mod('taxonomy_slug', 'projects' ) ) )
		);

		register_taxonomy( 'projects', 'portfolio', $args );

	}
	

	add_action( 'init', 'village_portfolio_setup_taxonomies', 5 );

}

