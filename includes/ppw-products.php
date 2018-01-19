<?php

class PPW_Products {


	private $products;

	public function __construct() {

		if ( ! function_exists( 'post_exists' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/post.php' );
		}

		$file = PPW_PATH . 'includes/data/default-products.php';

		if ( is_file( $file ) ) {

			$this->products = include $file;
			if ( is_array( $this->products ) ) {

				add_action( 'init', array($this, 'ppw_load_default_products') );

			}
		}


		//add_action( 'init', array($this, 'ppw_get_all_post_types') );

	}

	public function ppw_load_default_products() {

		foreach ( $this->products as $product_name => $data) {

			$this->ppw_insert_product( $product_name, $data);

		}

	}

	private function ppw_insert_product( $product_name, $data) {

		$prefix = 'ppw-';

		$post = get_page_by_title( $product_name, OBJECT, 'polynia' );

		//debug_to_console($post->ID);

		//TUTAJ BLAD!!
		if( 1 ) {
			debug_to_console($product_name);
			$post_information = array(
				'post_type' => 'polynia',
				'post_title' => $product_name
			);

			// to w zastępstwie chwilowo
			$post_id = post_exists( $product_name ) or wp_insert_post( $post_information );

			$post_id = $post->ID;


			wp_publish_post( $post_id );


			update_post_meta( $post_id, $prefix . 'description' , $data['type'] );
			update_post_meta( $post_id, $prefix . 'recommendation' , $data['recommendation'] );
			update_post_meta( $post_id, prefix . 'q1-a1' , 8 );
			foreach ( $data['questions'] as $question => $answers ) {

				foreach ( $answers as $answer => $points) {

					update_post_meta( $post_id, $prefix . $question . '-' . $answer , $points );

				}

			}


		} else {


			if ( get_post_status ( $post->ID ) == 'trash' ) {

				//kosz??
				//wp_delete_post($post->ID, $bypass_trash = true);

			} else {

				//maybe update product values to default?

			}

		}

	}

	public function ppw_get_all_post_types() {



		$posts = array();

		$query = new WP_Query( array(
			'post_type' => 'polynia',
			'posts_per_page' => -1
		));



		//if( $query-> have_posts() ) {


			while ( $query->have_posts() ) {

				$query->the_post();

				$post_title = get_the_title();
				$post_id = get_the_ID();
				$post_data = get_post_custom($post_id);

//				$hidden_field = '_';
//				foreach( $post_data as $key => $value ){
//					if( !empty($value) ) {
//						$pos = strpos($key, $hidden_field);
//						if( $pos !== false && $pos == 0 ) {
//							unset($post_data[$key]);
//						}
//					}
//				}

				array_push( $posts,
					array(
						'title' => $post_title,
						'id' => $post_id,
						'data' => $post_data
					)
				);


			}
		//}


		wp_reset_query();

		return $posts;

	}


}


$ppw_products = new PPW_Products();

