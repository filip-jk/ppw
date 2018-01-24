( function($) {

    // Window resize actions

    $(document).ready(function() {
        'use strict';

        // Add Kashing Form button

        $( '#add-ppw-wizard' ).on( 'click', function() {

            tinymce.activeEditor.insertContent( '[polynia_product_wizard]' );

        });


    });

} ) ( jQuery );