<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nt_register_testimonial_post_type() {
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name', 'new-testimonial' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'new-testimonial' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu', 'new-testimonial' ),
		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'new-testimonial' ),
		'add_new'            => _x( 'Add New', 'testimonial', 'new-testimonial' ),
		'add_new_item'       => __( 'Add New Testimonial', 'new-testimonial' ),
		'new_item'           => __( 'New Testimonial', 'new-testimonial' ),
		'edit_item'          => __( 'Edit Testimonial', 'new-testimonial' ),
		'view_item'          => __( 'View Testimonial', 'new-testimonial' ),
		'all_items'          => __( 'All Testimonials', 'new-testimonial' ),
		'search_items'       => __( 'Search Testimonials', 'new-testimonial' ),
		'parent_item_colon'  => __( 'Parent Testimonials:', 'new-testimonial' ),
		'not_found'          => __( 'No testimonials found.', 'new-testimonial' ),
		'not_found_in_trash' => __( 'No testimonials found in Trash.', 'new-testimonial' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'testimonial', $args );
}
add_action( 'init', 'nt_register_testimonial_post_type' );
