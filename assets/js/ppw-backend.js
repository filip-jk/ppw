( function($) {

    // Window resize actions

    $(document).ready(function() {
        'use strict';

        // Add Kashing Form button

        $( '#add-ppw-wizard' ).on( 'click', function() {

            tinymce.activeEditor.insertContent( '[polynia_product_wizard]' );

            console.log( ppw_wp_object.example_data );

            console.log( ppw_wp_object.values );
            console.log( ppw_wp_object.values2 );
        });


    });

} ) ( jQuery );