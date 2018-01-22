<?php


class PPW_Metaboxes {

	private $prefix;

	/**
	 * Class constructor.
	 */

	function __construct() {

		$this->prefix = Polynia_Product_Wizard::$data_prefix;

		// Load Meta-Box Core

		require_once PPW_PATH . 'includes/metabox-core/meta-box/meta-box.php';
		require_once PPW_PATH . 'includes/metabox-core/extensions/mb-settings-page/mb-settings-page.php';
		require_once PPW_PATH . 'includes/metabox-core/extensions/meta-box-conditional-logic/meta-box-conditional-logic.php';

		// Add PPW Post Type Metaboxes

		$this->add_metaboxes();

	}

	/**
	 * Add filter to rwmb_meta_boxes for metaboxes.
	 */

	function add_metaboxes() {

		add_filter( 'rwmb_meta_boxes', array( $this, 'ppw_filter_add_metaboxes' ) );

	}

	/**
	 * Filter with metabox declarations.
	 */

	function ppw_filter_add_metaboxes( $meta_boxes ) {

		$meta_boxes[] = array(
			'id' => $this->prefix . 'meta',
			'title' => esc_html__( 'Product wizard data:', 'ppw' ),
			'post_types' => array( 'polynia' ),
			'context' => 'advanced',
			'priority' => 'high',
			'autosave' => false,
			'fields' => array(
				array(
					'id' => $prefix . 'description',
					'type' => 'textarea',
					'name' => esc_html__( 'Description', 'ppw' ),
					'attributes' => array(),
				),
				array(
					'id' => $prefix . 'recommendation',
					'type' => 'textarea',
					'name' => esc_html__( 'Recommendation', 'ppw' ),
				)

			),
		);

		$meta_boxes = $this->construct_metabox( $meta_boxes );

		return $meta_boxes;
	}


	private function construct_metabox( &$meta_boxes ) {

		$questions = new PPW_Question();

		$metabox_index = -1;
		foreach ($meta_boxes as $box) {

			$metabox_index++;

			if( $box[ 'id' ] === $this->prefix . 'meta' ) {
				break;
			}

		}

		foreach ( $questions->get_all_questions() as $question => $data ) {

			$question_heading = array(
				'type' => 'heading',
				'name' => $data[ 'value' ]
			);

			array_push($meta_boxes[$metabox_index][ 'fields' ], $question_heading);

			foreach ( $data[ 'answers'] as $answer => $value) {

				array_push($meta_boxes[$metabox_index][ 'fields' ], array(
					'id' => $this->prefix . $question . '-' . $answer,
					'name' => esc_html__( $value ),
					'type' => 'select',
					'placeholder' => esc_html__( __( 'Select value', 'ppw' ), -1),
					'options' => $questions->get_answer_values()
				));

			}

		}

		return $meta_boxes;
	}

}

$ppw_metaboxes = new PPW_Metaboxes();