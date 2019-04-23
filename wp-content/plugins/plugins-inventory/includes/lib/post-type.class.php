<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Inventory_Plugin_Post_Type {


	public $post_type;
	public $plural;
	public $single;
	public $description;

	public function __construct ( $post_type = '', $plural = '', $single = '', $description = '' ) {

		if ( ! $post_type || ! $plural || ! $single ) return;

		// Post type name and labels
		$this->post_type = $post_type;
		$this->plural = $plural;
		$this->single = $single;
		$this->description = $description;

		// Regsiter post type
		add_action( 'init' , array( $this, 'register_post_type' ) );

		// Display custom update messages for posts edits
		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );
	}

	public function register_post_type () {

		$labels = array(
			'name' => $this->plural,
			'singular_name' => $this->single,
			'name_admin_bar' => $this->single,
			'add_new' => _x( 'Add New', $this->post_type , 'inventory-plugin' ),
			'add_new_item' => sprintf( __( 'Add New %s' , 'inventory-plugin' ), $this->single ),
			'edit_item' => sprintf( __( 'Edit %s' , 'inventory-plugin' ), $this->single ),
			'new_item' => sprintf( __( 'New %s' , 'inventory-plugin' ), $this->single ),
			'all_items' => sprintf( __( 'All %s' , 'inventory-plugin' ), $this->plural ),
			'view_item' => sprintf( __( 'View %s' , 'inventory-plugin' ), $this->single ),
			'search_items' => sprintf( __( 'Search %s' , 'inventory-plugin' ), $this->plural ),
			'not_found' =>  sprintf( __( 'No %s Found' , 'inventory-plugin' ), $this->plural ),
			'not_found_in_trash' => sprintf( __( 'No %s Found In Trash' , 'inventory-plugin' ), $this->plural ),
			'parent_item_colon' => sprintf( __( 'Parent %s' ), $this->single ),
			'menu_name' => $this->plural,
		);

		$args = array(
			'labels' => apply_filters( $this->post_type . '_labels', $labels ),
			'description' => $this->description,
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'excerpt', 'comments', 'thumbnail' ),
			'menu_position' => 5,
			'menu_icon' => 'dashicons-admin-post',
		);

		register_post_type( $this->post_type, apply_filters( $this->post_type . '_register_args', $args, $this->post_type ) );
	}

	// Set up Admin Messages
	public function updated_messages ( $messages = array() ) {
	  global $post, $post_ID;

	  $messages[ $this->post_type ] = array(
		  // NEED TO BUILD THIS
	   );

	  return $messages;
	}

}
