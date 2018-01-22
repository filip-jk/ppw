<?php


class PPW_Settings {

	private $prefix;

	function __construct() {

		$this->prefix = Polynia_Product_Wizard::$data_prefix;

		add_filter( 'mb_settings_pages', array($this, 'add_option_page') );
		add_filter( 'rwmb_meta_boxes', array($this, 'add_options_page_main') );
		add_filter( 'rwmb_meta_boxes', array($this, 'add_options_page_question') );


		add_action( 'wp_ajax_call_load_default_posts',  array( $this, 'ajax_load_default_posts' )  );
		add_action( 'wp_ajax_nopriv_call_load_default_posts', array( $this, 'ajax_load_default_posts' )  );

		add_action( 'wp_ajax_call_remove_default_posts',  array( $this, 'ajax_remove_default_posts' )  );
		add_action( 'wp_ajax_nopriv_call_remove_default_posts', array( $this, 'ajax_remove_default_posts' )  );

		add_action( 'wp_ajax_call_load_default_question_groups',  array( $this, 'ajax_load_default_question_groups' )  );
		add_action( 'wp_ajax_nopriv_load_default_question_groups', array( $this, 'ajax_load_default_question_groups' )  );
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

		$data = $ppw_products->remove_all_default_posts();

		$response = array(
			'response' => __( 'Groups loaded correctly!', 'ppw' )
		);


		wp_send_json_success( json_encode( $response ) );

	}

	function ajax_load_default_question_groups() {

//		$ppw_products = new PPW_Products();

//		$data = $ppw_products->remove_all_default_posts();

		$questions = new PPW_Question();

		$get_options = get_option('ppw_settings');
		//update_option( 'ppw_settings', $get );
		//add_option('ppw_settings', $get);

		//$get_options['ppw-group-number'] = 3;

		foreach ( $questions->get_all_questions() as $question => $data ) {

			$qid = $this->prefix . $question . '-number';
			$group = $data[ 'group' ];

			$get_options[ $qid ] = $group - 1;

		}


		update_option( 'ppw_settings', $get_options );

		$data = 'hehe';

		$response = array(
			'response' => $data
		);

		wp_send_json_success( json_encode( $response ) );

	}

	public function add_option_page () {

		$settings_pages[] = array(
			'id'          => 'ppw-settings',
			'option_name' => 'ppw_settings',
			'menu_title'  => __( 'Settings', 'ppw' ),
			'page_title'  => __( 'PPW Plugin Settings', 'ppw' ),
			'icon_url'    => 'dashicons-edit',
			'style'       => 'no-boxes',
			'parent'      => 'edit.php?post_type=polynia',
			'columns'     => 1,
			'tabs'        => array(
				'general'  => __( 'General', 'ppw' ),
				'question'  => __( 'Questionnaire', 'ppw' )
			),
			'position'    => 68
		);

		return $settings_pages;

	}

	public function add_options_page_main( $meta_boxes ) {


		$meta_boxes[] = array(
			'id'             => $this->prefix . 'main-settings',
			'title'          => 'API',
			'settings_pages' => 'ppw-settings',
			'tab'            => 'general',

			'fields' => array(
				array(
					'id' => $this->prefix . 'button-load',
					'type' => 'button',
					'name' => esc_html__( 'Load default products', 'ppw' ),
				),
				array(
					'id' => $this->prefix . 'button-remove',
					'type' => 'button',
					'name' => esc_html__( 'Remove default products', 'ppw' ),
				),
				array(
					'id' => $this->prefix . 'button-load-groups',
					'type' => 'button',
					'name' => esc_html__( 'Load default question groups', 'ppw' ),
				)
			)
		);

		return $meta_boxes;
	}

	public function add_options_page_question( $meta_boxes ) {


		$meta_boxes[] = array(
			'id'             => $this->prefix . 'question-settings',
			'title'          => 'API',
			'settings_pages' => 'ppw-settings',
			'tab'            => 'question',

			'fields' => array(
				array(
					'id' => $this->prefix . 'group-number',
					'type' => 'text',
					'name' => esc_html__( 'Group number', 'ppw' ),
				),
			)
		);

		$meta_boxes = $this->construct_metabox( $meta_boxes );

		return $meta_boxes;
	}


	private function construct_metabox( &$meta_boxes ) {

		$questions = new PPW_Question();

		$metabox_index = -1;
		foreach ($meta_boxes as $box) {

			$metabox_index++;

			if( $box[ 'id' ] === $this->prefix . 'q1-number' ) {
				break;
			}

		}

		$groups_number = ppw_option('ppw-group-number' );






		//tmp checking, should be only positive decimal number
		if( $groups_number !== NULL) {

			$groups_numbers = range(1, $groups_number);

			foreach ( $questions->get_all_questions() as $question => $data ) {

				$question_heading = array(
					'id' => $this->prefix . $question . '-number',
					'name' => esc_html__( $data[ 'value' ] ),
					'type' => 'select',
					'options' => $groups_numbers
				);

				array_push($meta_boxes[$metabox_index][ 'fields' ], $question_heading);

			}

		}



		//if ( get_post_meta( $form_id, $prefix . 'address2', true ) == true )

		return $meta_boxes;
	}


}


$ppw_settings = new PPW_Settings();

