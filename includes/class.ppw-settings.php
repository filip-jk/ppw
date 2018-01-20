<?php


class PPW_Settings {

	function __construct() {

		add_filter( 'mb_settings_pages', array($this, 'add_option_page') );
		add_filter( 'rwmb_meta_boxes', array($this, 'add_options_page_fields') );


		add_action( 'wp_ajax_call_load_default_posts',  array( $this, 'ajax_load_default_posts' )  );
		add_action( 'wp_ajax_nopriv_call_load_default_posts', array( $this, 'ajax_load_default_posts' )  );

		add_action( 'wp_ajax_call_remove_default_posts',  array( $this, 'ajax_remove_default_posts' )  );
		add_action( 'wp_ajax_nopriv_call_remove_default_posts', array( $this, 'ajax_remove_default_posts' )  );
	}

	function ajax_load_default_posts() {

		$ppw_products = new PPW_Products();

		$is_loaded = $ppw_products->load_default_products();


		if( $is_loaded ) {

			$response = array(
				'response' => __( 'Products loaded correctly!', 'ppw' )
			);

			wp_send_json_success( json_encode( $response ) );

		} else {

			$response = array(
				'response' => __( 'Products not loaded correctly...', 'ppw' )
			);

			wp_send_json_error( json_encode( $response ) );

		}

	}

	function ajax_remove_default_posts() {

		$ppw_products = new PPW_Products();

		//$data = $ppw_products->remove_all_default_posts();

		$data = $ppw_products->get_all_posts_data();

		$response = array(
			'data' => $data
		);

		wp_send_json_success( json_encode( $response ) );
	}

	public function add_option_page () {

		$settings_pages[] = array(
			'id'          => 'ppw-settings',
			'option_name' => 'ppw',
			'menu_title'  => __( 'Settings', 'ppw' ),
			'page_title'  => __( 'PPW Plugin Settings', 'ppw' ),
			'icon_url'    => 'dashicons-edit',
			'style'       => 'no-boxes',
			'parent'      => 'edit.php?post_type=polynia',
			'columns'     => 1,
			'tabs'        => array(
				'general'  => __( 'General', 'ppw' )
			),
			'position'    => 68
		);

		return $settings_pages;

	}

	public function add_options_page_fields( $meta_boxes ) {


		$meta_boxes[] = array(
			'id'             => 'configuration',
			'title'          => 'API',
			'settings_pages' => 'ppw-settings',
			'tab'            => 'general',

			'fields' => array(
				array(
					'id' => 'ppw-' . 'button-load',
					'type' => 'button',
					'name' => esc_html__( 'Load default products', 'ppw' ),
				),
				array(
					'id' => 'ppw-' . 'button-remove',
					'type' => 'button',
					'name' => esc_html__( 'Remove default products', 'ppw' ),
				)
			)
		);

		return $meta_boxes;
	}

}


$ppw_settings = new PPW_Settings();

