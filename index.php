<?php

/*

Plugin Name: 	Polynia Product Wizard
Plugin URI: 	ttp://themeforest.net/user/Veented
Description: 	Tool for helping users in making product selection decision.
Version: 		1.0
Author: 		Veented
Author URI: 	http://themeforest.net/user/Veented
License: 		GPL2

*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PPW_PATH', dirname(__FILE__) . '/' );

class Polynia_Product_Wizard {

	public static $data_prefix = 'ppw-';


	/**
	 * Class constructor.
	 */

	function __construct() {

		// Register custom post types

		$this->register_post_type();

		// Plugin scripts and styles

		add_action( 'admin_enqueue_scripts', array( $this, 'action_admin_enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts' ) );

		// Load Metabox Core

		$this->load_metaboxes();

		// Plugin Options Page

		//$this->settings_page();

		// Load predefined questions

		$this->load_questions();

		// Load predefined products

		$this->load_products();




		// Load Shortcode

		$this->load_shortcode();
//
//		// Init Ajax
//
//		$this->plugin_ajax();
//
//


	}

	/**
	 * Load Metaboxes.
	 */

	function load_metaboxes() {

		require_once PPW_PATH . 'includes/class.ppw-metaboxes.php';

	}

	/**
	 * Plugin Options Page.
	 */

	private function settings_page() {

		require_once PPW_PATH . 'includes/class.ppw-settings.php';

	}

	/**
	 * Load any additional functions.
	 */

	function load_functions() {

		require_once PPW_PATH . 'include/ppw-functions.php';

	}

	/**
	 * // Load predefined products
	 */

	function load_products() {

		require_once PPW_PATH . 'includes/ppw-products.php';

	}

	/**
	 * // Load predefined questions
	 */

	function load_questions() {

		require_once PPW_PATH . 'includes/ppw-questions.php';

	}


	/**
	 * // Load predefined questions
	 */

	function load_shortcode() {

		require_once PPW_PATH . 'includes/shortcode.php';

	}

	/**
	 * Register the main Polynia Product Wizard custom post type.
	 */

	private function register_post_type() {

		add_action( 'init', array( $this, 'register_post_type_ppw' ) );

	}



	/**
	 * Custom post type registration action.
	 */

	public function register_post_type_ppw() {

		$args = array(
			'label' => __( 'Polynia Product Wizard', 'ppw' ),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-list-view',
			'supports' => array( 'title' ),
			'exclude_from_search' => true,
			'show_in_nav_menus' => false,
			'show_in_menu' => true,
			'show_in_admin_bar' => false,
			'has_archive' => false,
			'public' => true,
			'publicly_queryable' => true,
			'rewrite' => false,
			'labels' => array(
				'add_new' => __( 'Add New Product', 'ppw' ),
				'all_items' => __( 'View Products', 'ppw' )
			)
		);

		register_post_type( 'polynia' , $args );

	}


	/**
	 * Admin scripts and styles.
	 */


	public function action_admin_enqueue_scripts() {

		wp_enqueue_style( 'ppw-admin', plugin_dir_url( __FILE__ ) . 'assets/css/ppw-admin.css' );
		wp_enqueue_script( 'ppw-backend-js', plugin_dir_url( __FILE__ ) . 'assets/js/ppw-backend.js', array( 'jquery' ) );

		//testy
//		$obj = new PPW_Question();
//		$arg = $obj->get_answer_values();
//
//		$obj2 = new PPW_Products();
//		$arg2 = $obj2->ppw_get_all_post_types();

		//tessty

		wp_localize_script(
			'ppw-backend-js',
			'ppw_wp_object',
			array(
				'msg_missing_field' => __( 'This field is required.', 'kashing' ),
				'example_data' => 'cokolwiek',
//				'values' => $arg,
//				'values2' => $arg2
			)
		);

	}

	/**
	 * Frontend scripts and styles.
	 */

	public function action_wp_enqueue_scripts() {

		wp_enqueue_style( 'ppw-frontend-css', plugin_dir_url( __FILE__ ) . 'assets/css/ppw-frontend.css' );

		wp_enqueue_script( 'ppw-frontend-js', plugin_dir_url( __FILE__ ) . 'assets/js/ppw-frontend.js', array( 'jquery' ) );

		// Localize the frontend JavaScript

		wp_localize_script(
			'kashing-frontend-js',
			'kashing_wp_object',
			array(
				'wp_ajax_url' => admin_url( 'admin-ajax.php' ),
				'page_id' => get_the_ID()
			)
		);

	}

}

$ppw = new Polynia_Product_Wizard();