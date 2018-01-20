( function($) {

    // Window resize actions

    $(document).ready(function() {
        'use strict';

        // Add Kashing Form button

        $( '#ppw-button-load' ).on( 'click', function() {

            $.ajax ({
                url: ppw_wp_meta.wp_ajax_url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'call_load_default_posts'
                },
                success: function ( resp ) {

                    var response = JSON.parse( resp.data );

                    if ( resp.success ) {

                        alert ( response['response'] ) ;

                    } else {

                        alert ( response['response'] ) ;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert ('Request failed') ;
                },
            }) ;

        });

        $( '#ppw-button-remove' ).on( 'click', function() {

            $.ajax ({
                url: ppw_wp_meta.wp_ajax_url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'call_remove_default_posts'
                },
                success: function ( resp ) {

                    if ( resp.success ) {

                        var response = JSON.parse( resp.data );

                        console.log(response);

                        alert ( 'Removed' ) ;

                    } else {

                        alert ( 'Not removed' ) ;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert ('Remove failed') ;
                },
            }) ;

        });


    });

} ) ( jQuery );