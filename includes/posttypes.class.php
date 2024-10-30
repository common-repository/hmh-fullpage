<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Bbfp_Posttypes' ) ) {
	/**
	 * Bbfp_Posttypes Class
	 *
	 * @since	1.0
	 */
	class Bbfp_Posttypes {


		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_filter( 'bb_register_posttypes', array( $this, 'register_posttypes' ), 10, 1 );
		}
        
		public function register_posttypes($posttypes) {

			if( empty($posttypes) ) {
				$posttypes = array();
			}

			$labels = array(
				'name'               => esc_html_x( 'Section', 'Section', 'wp_fullpage' ),
				'singular_name'      => esc_html_x( 'Section', 'Section', 'wp_fullpage' ),
				'menu_name'          => esc_html__( 'Section', 'wp_fullpage' ),
				'name_admin_bar'     => esc_html__( 'Section', 'wp_fullpage' ),
				'parent_item_colon'  => esc_html__( 'Parent Menu:', 'wp_fullpage' ),
				'all_items'          => esc_html__( 'All Sections', 'wp_fullpage' ),
				'add_new_item'       => esc_html__( 'Add New Section', 'wp_fullpage' ),
				'add_new'            => esc_html__( 'Add New', 'wp_fullpage' ),
				'new_item'           => esc_html__( 'New Section', 'wp_fullpage' ),
				'edit_item'          => esc_html__( 'Edit Section', 'wp_fullpage' ),
				'update_item'        => esc_html__( 'Update Section', 'wp_fullpage' ),
				'view_item'          => esc_html__( 'View Section', 'wp_fullpage' ),
				'search_items'       => esc_html__( 'Search Section', 'wp_fullpage' ),
				'not_found'          => esc_html__( 'Not found', 'wp_fullpage' ),
				'not_found_in_trash' => esc_html__( 'Not found in Trash', 'wp_fullpage' ),
			);
			$args   = array(
				'label'               => esc_html__( 'Section', 'wp_fullpage' ),
				'description'         => esc_html__( 'Section', 'wp_fullpage' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', ),
				'hierarchical' => false,
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 21,
				'menu_icon' => 'dashicons-slides',
				'show_in_admin_bar' => true,
				'show_in_nav_menus' => true,
				'can_export' => true,
				'has_archive' => false,
				'exclude_from_search' => true,
				'publicly_queryable' => true,
				'rewrite' => false,
				'capability_type' => 'page',
			);

			$posttypes[BBFP_POSTTYPE_SECTION] = $args;

			// FullPage
			$labels = array(
				'name' => esc_html_x('FullPages', 'FullPages', 'wp_fullpage'),
				'singular_name' => esc_html_x('FullPage', 'FullPage', 'wp_fullpage'),
				'menu_name' => esc_html__('FullPage', 'wp_fullpage'),
				'name_admin_bar' => esc_html__('FullPage', 'wp_fullpage'),
				'parent_item_colon' => esc_html__('Parent Menu:', 'wp_fullpage'),
				'all_items' => esc_html__('All FullPages', 'wp_fullpage'),
				'add_new_item' => esc_html__('Add New FullPage', 'wp_fullpage'),
				'add_new' => esc_html__('Add New', 'wp_fullpage'),
				'new_item' => esc_html__('New FullPage', 'wp_fullpage'),
				'edit_item' => esc_html__('Edit FullPage', 'wp_fullpage'),
				'update_item' => esc_html__('Update FullPage', 'wp_fullpage'),
				'view_item' => esc_html__('View FullPage', 'wp_fullpage'),
				'search_items' => esc_html__('Search FullPage', 'wp_fullpage'),
				'not_found' => esc_html__('Not found', 'wp_fullpage'),
				'not_found_in_trash' => esc_html__('Not found in Trash', 'wp_fullpage'),
			);
			$args = array(
				'label' => esc_html__('FullPage', 'wp_fullpage'),
				'description' => esc_html__('FullPage', 'wp_fullpage'),
				'labels' => $labels,
				'supports' => array('title', 'editor', ),
				'hierarchical' => false,
				'public' => false,
				'show_ui' => false,
				'show_in_menu' => false,
				'menu_position' => 13,
				'menu_icon' => BBFP_URL . 'assets/images/FullPage.png',
				'show_in_admin_bar' => false,
				'show_in_nav_menus' => false,
				'can_export' => true,
				'has_archive' => false,
				'exclude_from_search' => true,
				'publicly_queryable' => false,
				'rewrite' => false,
				'capability_type' => 'page',
			);
			$posttypes[BBFP_POSTTYPE_FULLPAGE] = $args;

			return $posttypes;
		}
        
    }
	
	new Bbfp_Posttypes();
}
