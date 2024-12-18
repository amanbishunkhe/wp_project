<?php
/**
 * Register all the custom post types here
 *
 * @see get_post_type_labels() for label keys.
 */
function readymix_custom_post_type_edit() {

	// Display Center
	$display_center_labels = array(
		'name'               => _x( 'Display Centers', 'Post type general name', 'readymix' ),
		'singular_name'      => _x( 'Display Center', 'Post type singular name', 'readymix' ),
		'menu_name'          => _x( 'Display Centers', 'Admin Menu text', 'readymix' ),
		'name_admin_bar'     => _x( 'Display Center', 'Add New on Toolbar', 'readymix' ),
		'add_new'            => __( 'Add New', 'readymix' ),
		'add_new_item'       => __( 'Add New Display Center', 'readymix' ),
		'new_item'           => __( 'New Display Center', 'readymix' ),
		'edit_item'          => __( 'Edit Display Center', 'readymix' ),
		'view_item'          => __( 'View Display Center', 'readymix' ),
		'all_items'          => __( 'All Display Centers', 'readymix' ),
		'search_items'       => __( 'Search Display Centers', 'readymix' ),
		'parent_item_colon'  => __( 'Parent Display Centers:', 'readymix' ),
		'not_found'          => __( 'No Display Center found.', 'readymix' ),
		'not_found_in_trash' => __( 'No Display Center found in Trash.', 'readymix' ),
	);

	$display_center_args = array(
		'labels'             => $display_center_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-format-gallery',
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'display-center' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'show_in_rest'       => true,
		'supports'           => array( 'title', 'editor', 'page-attributes' ),
	);

	register_post_type( 'display-center', $display_center_args );

	$labels = array(
		'name'              => _x( 'States/Regions', 'taxonomy general name', 'readymix' ),
		'singular_name'     => _x( 'State/Region', 'taxonomy singular name', 'readymix' ),
		'search_items'      => __( 'Search States/Regions', 'readymix' ),
		'all_items'         => __( 'All States/Regions', 'readymix' ),
		'parent_item'       => __( 'Parent State/Region', 'readymix' ),
		'parent_item_colon' => __( 'Parent State/Region:', 'readymix' ),
		'edit_item'         => __( 'Edit State/Region', 'readymix' ),
		'update_item'       => __( 'Update State/Region', 'readymix' ),
		'add_new_item'      => __( 'Add New State/Region', 'readymix' ),
		'new_item_name'     => __( 'New State/Region Name', 'readymix' ),
		'menu_name'         => __( 'States/Regions', 'readymix' ),
	);

	$args = array(
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'         => 'visit-display-centre',
			'hierarchical' => true,
		),
	);

	register_taxonomy( 'display-center-state', array( 'display-center' ), $args );
	// FAQs
	$faqs_labels = array(
		'name'               => _x( 'FAQs', 'Post type general name', 'readymix' ),
		'singular_name'      => _x( 'FAQ', 'Post type singular name', 'readymix' ),
		'menu_name'          => _x( 'FAQs', 'Admin Menu text', 'readymix' ),
		'name_admin_bar'     => _x( 'FAQ', 'Add New on Toolbar', 'readymix' ),
		'add_new'            => __( 'Add New', 'readymix' ),
		'add_new_item'       => __( 'Add New FAQ', 'readymix' ),
		'new_item'           => __( 'New FAQ', 'readymix' ),
		'edit_item'          => __( 'Edit FAQ', 'readymix' ),
		'view_item'          => __( 'View FAQ', 'readymix' ),
		'all_items'          => __( 'All FAQs', 'readymix' ),
		'search_items'       => __( 'Search FAQs', 'readymix' ),
		'parent_item_colon'  => __( 'Parent FAQs:', 'readymix' ),
		'not_found'          => __( 'No FAQ found.', 'readymix' ),
		'not_found_in_trash' => __( 'No FAQ found in Trash.', 'readymix' ),
	);

	$faqs_args = array(
		'labels'             => $faqs_labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-format-gallery',
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'faq' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'show_in_rest'       => true,
		'supports'           => array( 'title', 'editor' ),
	);

	register_post_type( 'faq', $faqs_args );
	// FAQ Topic Taxonomy
	$labels = array(
		'name'              => _x( 'FAQs Topics', 'taxonomy general name', 'readymix' ),
		'singular_name'     => _x( 'FAQ Topic', 'taxonomy singular name', 'readymix' ),
		'search_items'      => __( 'Search FAQs Topics', 'readymix' ),
		'all_items'         => __( 'All FAQs Topics', 'readymix' ),
		'parent_item'       => __( 'Parent FAQ Topic', 'readymix' ),
		'parent_item_colon' => __( 'Parent FAQ Topic:', 'readymix' ),
		'edit_item'         => __( 'Edit FAQ Topic', 'readymix' ),
		'update_item'       => __( 'Update FAQ Topic', 'readymix' ),
		'add_new_item'      => __( 'Add New FAQ Topic', 'readymix' ),
		'new_item_name'     => __( 'New FAQ Topic Name', 'readymix' ),
		'menu_name'         => __( 'FAQs Topics', 'readymix' ),
	);

	$args = array(
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => false,
		'rewrite'           => array( 'slug' => 'faq-topic' ),
	);

	register_taxonomy( 'faq-topic', array( 'faq' ), $args );

	// Ready Mix Product
	$readymix_product_labels = array(
		'name'               => _x( 'Readymix Products', 'Post type general name', 'readymix' ),
		'singular_name'      => _x( 'Readymix Product', 'Post type singular name', 'readymix' ),
		'menu_name'          => _x( 'Readymix Products', 'Admin Menu text', 'readymix' ),
		'name_admin_bar'     => _x( 'Readymix Product', 'Add New on Toolbar', 'readymix' ),
		'add_new'            => __( 'Add New', 'readymix' ),
		'add_new_item'       => __( 'Add New Product', 'readymix' ),
		'new_item'           => __( 'New Product', 'readymix' ),
		'edit_item'          => __( 'Edit Product', 'readymix' ),
		'view_item'          => __( 'View Product', 'readymix' ),
		'all_items'          => __( 'All Products', 'readymix' ),
		'search_items'       => __( 'Search Products', 'readymix' ),
		'parent_item_colon'  => __( 'Parent Products:', 'readymix' ),
		'not_found'          => __( 'No products found.', 'readymix' ),
		'not_found_in_trash' => __( 'No products found in Trash.', 'readymix' ),
	);

	$readymix_product_args = array(
		'labels'             => $readymix_product_labels,
		'public'             => true,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-products',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'readymix-product' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'show_in_rest'       => true,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);

	register_post_type( 'readymix_product', $readymix_product_args );

	register_taxonomy(
		'readymix_state',
		'readymix_product',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => 'Readymix State', // display name
			'show_in_rest' => true,
			'query_var'    => false,
			'rewrite'      => array(
				'with_front' => true,
			),
		)
	);

	// register_taxonomy(
	// 	'readymix_installer-region',
	// 	'readymix_product',
	// 	array(
	// 		'hierarchical' => true,
	// 		'show_in_menu' => true,
	// 		'label'        => 'Readymix Installer Region', // display name
	// 		'show_in_rest' => true,
	// 		'query_var'    => false,
	// 		'rewrite'      => array(
	// 			'with_front' => true,
	// 		),
	// 	)
	// );

	// Stone Type taxonomy for product
	register_taxonomy(
		'readymix_type',
		'readymix_product',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => 'Readymix Stone Type', // display name
			'query_var'    => false,
			'show_in_rest' => true,
			'rewrite'      => array(
				'with_front' => true,
			),
		)
	);

	   // Project
	   $project_labels = array(
		   'name'               => _x( 'Projects', 'Post type general name', 'readymix' ),
		   'singular_name'      => _x( 'Project', 'Post type singular name', 'readymix' ),
		   'menu_name'          => _x( 'Projects', 'Admin Menu text', 'readymix' ),
		   'name_admin_bar'     => _x( 'Project', 'Add New on Toolbar', 'readymix' ),
		   'add_new'            => __( 'Add New', 'readymix' ),
		   'add_new_item'       => __( 'Add New Project', 'readymix' ),
		   'new_item'           => __( 'New Project', 'readymix' ),
		   'edit_item'          => __( 'Edit Project', 'readymix' ),
		   'view_item'          => __( 'View Project', 'readymix' ),
		   'all_items'          => __( 'All Projects', 'readymix' ),
		   'search_items'       => __( 'Search Projects', 'readymix' ),
		   'parent_item_colon'  => __( 'Parent Projects:', 'readymix' ),
		   'not_found'          => __( 'No projects found.', 'readymix' ),
		   'not_found_in_trash' => __( 'No projects found in Trash.', 'readymix' ),
	   );

	   $project_args = array(
		   'labels'             => $project_labels,
		   'public'             => true,
		   'publicly_queryable' => true,
		   'show_ui'            => true,
		   'show_in_menu'       => true,
		   'menu_icon'          => 'dashicons-format-gallery',
		   'query_var'          => true,
		   'rewrite'            => array( 'slug' => 'readymix_project' ),
		   'capability_type'    => 'post',
		   'has_archive'        => true,
		   'hierarchical'       => false,
		   'menu_position'      => null,
		   'show_in_rest'       => true,
		   'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	   );

	   register_post_type( 'readymix_project', $project_args );

	   // Register taxonomy for projects
    register_taxonomy(
		'readymix_projects_state',
		'readymix_project',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => 'States', // display name
			'query_var'    => true,
			'rewrite'      => array(
				'with_front' => true,
			),
			'show_in_rest' => true,
		)
	);

	// Register taxonomy for projects
	register_taxonomy(
		'readymix_projects_type',
		'readymix_project',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => 'Project Type', // display name
			'query_var'    => true,
			'rewrite'      => array(
				'with_front' => true,
			),
			'show_in_rest' => true,
		)
	);

	// Register taxonomy for projects
	register_taxonomy(
		'readymix_projects_concrete_type',
		'readymix_project',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => 'Concrete Type', // display name
			'query_var'    => true,
			'rewrite'      => array(
				'with_front' => true,
			),
			'show_in_rest' => true,
		)
	);
	/*
	// Product
	$gproduct_labels = array(
		'name'               => _x( 'ReadyMix Products', 'Post type general name', 'readymix' ),
		'singular_name'      => _x( 'Product', 'Post type singular name', 'readymix' ),
		'menu_name'          => _x( 'ReadyMix Products', 'Admin Menu text', 'readymix' ),
		'name_admin_bar'     => _x( 'ReadyMix Product', 'Add New on Toolbar', 'readymix' ),
		'add_new'            => __( 'Add New', 'readymix' ),
		'add_new_item'       => __( 'Add New Product', 'readymix' ),
		'new_item'           => __( 'New Product', 'readymix' ),
		'edit_item'          => __( 'Edit Product', 'readymix' ),
		'view_item'          => __( 'View Product', 'readymix' ),
		'all_items'          => __( 'All Products', 'readymix' ),
		'search_items'       => __( 'Search Products', 'readymix' ),
		'parent_item_colon'  => __( 'Parent Products:', 'readymix' ),
		'not_found'          => __( 'No products found.', 'readymix' ),
		'not_found_in_trash' => __( 'No products found in Trash.', 'readymix' ),
	);

	$gproduct_args = array(
		'labels'             => $gproduct_labels,
		'public'             => true,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-products',
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'stone' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'show_in_rest'       => true,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);

	register_post_type( 'geostone_product', $gproduct_args );

	// Register state taxonomy for product
	register_taxonomy(
		'geostone_state',
		'geostone_product',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => ' Readymix State', // display name
			'show_in_rest' => true,
			'query_var'    => false,
			'rewrite'      => array(
				'with_front' => true,
			),
		)
	);

	register_taxonomy(
		'geostone_installer-region',
		'geostone_product',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => 'Readymix Installer Region', // display name
			'show_in_rest' => true,
			'query_var'    => false,
			'rewrite'      => array(
				'with_front' => true,
			),
		)
	);

	// Stone Type taxonomy for product
	register_taxonomy(
		'geostone_type',
		'geostone_product',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => 'Readymix Stone Type', // display name
			'query_var'    => false,
			'show_in_rest' => true,
			'rewrite'      => array(
				'with_front' => true,
			),
		)
	);

	// Register Cementious taxonomy for product
	/*
	register_taxonomy(
		'geostone_cementious',
		'geostone_product',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => 'Readymix Cementious Colour', // display name
			'query_var'    => false,
			'show_in_rest' => true,
			'rewrite'      => array(
				'with_front' => true,
			),
		)
	);
	// Register state Primary for product
	register_taxonomy(
		'geostone_primary',
		'geostone_product',
		array(
			'hierarchical' => true,
			'show_in_menu' => true,
			'label'        => 'Readymix Primary Aggregate Colour', // display name
			'show_in_rest' => true,
			'query_var'    => false,
			'rewrite'      => array(
				'with_front' => true,
			),
		)
	);
	*/
}

add_action( 'init', 'readymix_custom_post_type_edit' );
