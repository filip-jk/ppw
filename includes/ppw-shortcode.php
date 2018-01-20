<?php


    class PPW_Shortcode {

        public function __construct() {

	        add_action( 'media_buttons', array( $this, 'add_shortcode_button' ) );

	        add_shortcode( 'polynia_product_wizard', array( $this,  'ppw_form_shortcode' ));

        }

	    public function add_shortcode_button( $editor_id ) {
		    echo '<a href="#" class="button" id="add-ppw-wizard">' . esc_html__( 'Add PPW Form', 'ppw' ) . '</a>';
	    }


	    public function ppw_form_shortcode( $atts, $content ) {

		    wp_enqueue_style( 'kashing-frontend-js' );

		    ?>

<!--            tutaj tak testowo czy dziala cokolwiek :) -->
        <form id="kashing-form" class="kashing-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST">

            <div class="input-holder">
                <label for="kashing-firstname"><?php esc_html_e('First Name', 'kashing'); ?></label>
                <input type="text" name="firstname" id="kashing-firstname" class="kashing-required-field" value="Ten">
            </div>

        </form>

		    <?php
		    add_shortcode( 'polynia_product_wizard', 'ppw_form_shortcode' );
        }

    }


$ppw_shortcode = new PPW_Shortcode();






function debug_to_console( $data ) {
	$output = $data;
	if ( is_array( $output ) )
		$output = implode( ',', $output);

	echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

