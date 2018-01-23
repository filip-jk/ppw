<?php


    class PPW_Shortcode {

        public function __construct() {

	        add_action( 'media_buttons', array( $this, 'add_shortcode_button' ) );

	        add_shortcode( 'polynia_product_wizard', array( $this,  'ppw_form_shortcode' ));

	        add_action( 'wp_ajax_call_get_posts_data',  array( $this, 'ajax_get_posts_data' )  );
	        add_action( 'wp_ajax_nopriv_call_get_posts_data', array( $this, 'ajax_get_posts_data' )  );

        }

	    function ajax_get_posts_data() {

		    $ppw_products = new PPW_Products();

		    $data = $ppw_products->get_all_posts_data();
		    $groups_number = ppw_option('ppw-group-number' );

		    $response = array(
			    'data' => $data,
                'groups' => $groups_number
		    );

		    wp_send_json_success( json_encode( $response ) );
	    }


	    public function add_shortcode_button( $editor_id ) {
		    echo '<a href="#" class="button" id="add-ppw-wizard">' . esc_html__( 'Add PPW Form', 'ppw' ) . '</a>';
	    }


	    public function ppw_form_shortcode( $atts, $content ) {

		    wp_enqueue_style( 'kashing-frontend-js' );

		    $num_of_groups = '1/3';

			    ?>

                <form id="ppw-form" class="ppw-form">

                    <div id="ppw-progress" class="'ppw-progress-class"> <?php echo($num_of_groups); ?>  </div>

                    <?php

                    $ppw_questions = new PPW_Question();
                    $questions = $ppw_questions->get_all_questions();

                    $groups_number = ppw_option('ppw-group-number' );

                    foreach ( $questions as $question => $question_data) {

                        $hide = 'hidden';

	                    $group = ppw_option('ppw-' . $question . '-number') + 1;

                        //add this to preload fist group questions
                        if( $group == 1 ) {
                            $hide = '';
                        }

	                   // data-group=<?php echo($question_data['group'])
	                    ?>

                        <div required class="ppw-input-holder <?php echo($hide); ?>" id=<?php echo('ppw-' . $question); ?> data-group=<?php echo($group); ?>>

                            <label for="ppw-question-label"><?php echo($question_data['value']); ?></label>
<!--                            <form>-->

	                            <?php

	                                 foreach ( $question_data['answers'] as $answer_id => $answer_data) {

	                                     $radio_name = 'ppw-' . $question . '-form';
	                                     $radio_id =  $radio_name . $answer_id;
                                 ?>

                                         <input type="radio"
                                                id=<?php echo($radio_id); ?>
                                                name=<?php echo($radio_name); ?>
                                                value=<?php echo($answer_id); ?>>
		                                    <?php echo($answer_data); ?>
                                         <br>

                                 <?php } ?>

<!--                            </form>-->

                        </div>

                        <div id="ppw-results" class="ppw-results-class hidden">  </div>
	                    <?php
                    }
                        ?>

                    <button class="ppw-button-left hidden" id="ppw-button-back" type="button"><?php esc_html_e('Back', 'ppw' ); ?></button>

                    <button class="ppw-button-right disabled"  id="ppw-button-next" type="button"><?php esc_html_e('Next', 'ppw' ); ?></button>

                    <button class="ppw-button-right hidden" id="ppw-button-finish" type="button"><?php esc_html_e('Get results', 'ppw' ); ?></button>

                </form>

			    <?php

		    //add_shortcode( 'polynia_product_wizard', 'ppw_form_shortcode' );
        }

    }


$ppw_shortcode = new PPW_Shortcode();






function debug_to_console( $data ) {
	$output = $data;
	if ( is_array( $output ) )
		$output = implode( ',', $output);

	echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

