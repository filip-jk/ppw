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

            // Shortcode output

            ob_start();

		    $ppw_questions = new PPW_Question();
		    $questions = $ppw_questions->get_all_questions();

//		    $count_groups = [];
//
//		    foreach ( range(1, $ppw_questions->get_question_number()) as $number ) {
//
//			    $qid = 'ppw-q' . $number . '-number';
//
//			    $value = ppw_option( $qid );
//
//			    if( $value != NULL && $value != 'undefined') {
//
//				    $count_groups[ $value ] = 0;
//
//
//                } else {
//
//			        //qid not exists
//
//                }
//
//		    }
//
//		    $groups_number = count( $count_groups );
//
//		    if( $count_groups < 1 ) {
//
//			    $groups_number = $ppw_questions->get_question_number();
//
//            }

		    $groups_number = ppw_option( 'ppw-group-number' );

		    $num_of_groups = '<span class="ppw-progress-current">1</span><span class="ppw-progress-slash">/</span><span class="ppw-progress-total">' . $groups_number . '</span>';

		    ?>

                <form id="ppw-form" class="ppw-form">

                    <div id="ppw-progress" class="ppw-progress"> <?php echo( $num_of_groups ); ?>  </div>

                    <?php

                    foreach ( $questions as $question => $question_data) {

                        $hide = 'hidden';
	                    $group = ppw_option('ppw-' . $question . '-number') + 1;

                        // add this to preload fist group questions

                        if ( $group == 1 ) {
                            $hide = '';
                        }

	                    ?>

                        <div required class="ppw-input-holder ppw-question <?php echo($hide); ?>" id=<?php echo('ppw-' . $question); ?> data-group=<?php echo($group); ?>>

                            <h5 class="ppw-question-title"><?php echo($question_data['value']); ?></h5>

	                            <?php

                                foreach ( $question_data['answers'] as $answer_id => $answer_data ) {

                                    $radio_name = 'ppw-' . $question . '-form';
                                    $radio_id =  $radio_name . $answer_id;
                                    ?>
                                    <label class="ppw-answer-wrap"><input type="radio"
                                                                          id=<?php echo esc_attr( $radio_id ); ?>
                                                                          name=<?php echo esc_attr( $radio_name ); ?>
                                                                          value=<?php echo esc_attr( $answer_id ); ?>>
                                        <span class="ppw-answer-label"><?php echo esc_html( $answer_data ); ?></span>
                                    </label>
                                <?php
                                }
                                ?>

                        </div>

	                    <?php
                        }
                        ?>

                    <div id="ppw-results" class="ppw-results-class hidden">
                        <h3>Results:</h3>
                        <table>
                            <tr>
                                <th>Product Name</th>
                                <th>Points</th>
                                <th>Description</th>
                                <th>Why we suggest it?</th>
                            </tr>

                        </table>
                    </div>

                <?php

                $button_back  = ' <button class="button pw-button-left ppw-button-prev hidden" id="ppw-button-back" type="button">' .  esc_html('Back', 'ppw' ) .'</button>';

                $button_next = '<button class="button ppw-button-right ppw-button-next ';

                $button_finish =  '<button class="button ppw-button-right ppw-button-finish ';

                if( $groups_number < 2) {

	                $button_next  = $button_next . 'hidden';
	                $button_finish = $button_finish . 'disabled';

                } else {

	                $button_next  = $button_next . 'disabled';
	                $button_finish = $button_finish . 'hidden';

                }

                $button_next = $button_next . ' " id="ppw-button-next" type="button">' . esc_html('Next', 'ppw' ) . '</button>';
                $button_finish = $button_finish . '" id="ppw-button-finish" type="button">' . esc_html('Get results', 'ppw' ) . '</button>';

                echo $button_back;
                echo $button_next;
                echo $button_finish;

                ?>


                </form>

            <?php

            $content = ob_get_contents(); // End content "capture" and store it into a variable.
            ob_end_clean();

            return $content; // Return the shortcode content

        }

    }


$ppw_shortcode = new PPW_Shortcode();






function debug_to_console( $data ) {
	$output = $data;
	if ( is_array( $output ) )
		$output = implode( ',', $output);

	echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

