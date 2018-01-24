<?php

class PPW_Products {


	private $products;

	public function __construct() {

		$file = PPW_PATH . 'includes/data/default-products.php';

		// if default products data exists
		if ( is_file( $file ) ) {

			$this->products = include $file;

			if ( is_array( $this->products ) ) {

				// default products data loaded successfully
			}

		} else {

			//default products data could not be loaded

		}

		//add_action( 'init', array($this, 'ppw_get_all_post_types') );

	}


	/**
	 * Load default products post types or restore default settings
	 *
//	 * @param string
//	 * @param int
	 *
	 * @return boolean
	 */

	public function load_default_products() {

		$response = true;

		foreach ( $this->products as $product_name => $data) {

			 if ($this->insert_product( $product_name, $data) ) {

			 	//product loaded or updated

			 } else {

			 	return false;
			 }

		}

		return $response;

	}

	private function insert_product( $product_name, $data) {

		$prefix = Polynia_Product_Wizard::$data_prefix;

		$post = get_page_by_title( $product_name, OBJECT, 'polynia' );

		//create new posts
		if( $post == NULL ) {

			$post_information = array(
				'post_type' => 'polynia',
				'post_title' => $product_name
			);

			$post_id = wp_insert_post( $post_information );

			wp_publish_post( $post_id );

		} else {

			$post_id = $post->ID;

		}

		update_post_meta( $post_id, $prefix . 'description' , $data['type'] );
		update_post_meta( $post_id, $prefix . 'recommendation' , $data['recommendation'] );

		foreach ( $data['questions'] as $question => $answers ) {

			foreach ( $answers as $answer => $points) {

				update_post_meta( $post_id, $prefix . $question . '-' . $answer , $points );

			}

		}

		//have to be validated
		return true;

	}

	public function remove_all_default_posts() {

		foreach ( $this->products as $product_name => $data) {

			$post = get_page_by_title( $product_name, OBJECT, 'polynia' );

			if( $post != NULL ) {

				if ( get_post_status( $post->ID ) == 'trash' ) {

					$resp = wp_delete_post($post->ID, $bypass_trash = true);


				} else {

					//removes also post types
					$resp = wp_delete_post($post->ID, $bypass_trash = true);

				}

				if(!$resp || resp == NULL) {

					return false;

				}

			} else {

			}

		}

		return true;

	}

	private function remove_all_trashed_posts() {

		$trash = get_posts('post_status=trash&numberposts=-1$post_type=\'polynia\'');

		foreach($trash as $post) {

			wp_delete_post($post->ID, $bypass_trash = true);
		}

	}


	public function get_all_posts_data() {

		$posts = array();

		$query = new WP_Query( array(
			'post_type' => 'polynia',
			'posts_per_page' => -1
		));


		if( $query-> have_posts() ) {

			while ( $query->have_posts() ) {

				$query->the_post();

				$post_title = get_the_title();
				$post_id = get_the_ID();
				$post_data = get_post_custom($post_id);

				array_push( $posts,
					array(
						'title' => $post_title,
						'id' => $post_id,
						'data' => $post_data
					)
				);

			}
		}


		wp_reset_query();

		return $posts;

	}

}


$ppw_products = new PPW_Products();

