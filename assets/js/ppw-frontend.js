( function($) {

    // Window resize actions

    $(document).ready(function() {
        'use strict';

        var num_of_groups = 3;
        var page = 1;


        if($('#ppw-form').is('.ppw-form')){

            $.ajax ({
                url: ppw_wp_meta.wp_ajax_url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'call_get_posts_data'
                },
                success: function ( resp ) {

                    var response = JSON.parse( resp.data );

                    if ( resp.success ) {

                        var response_data = response['data'];

                        // for( var product_num in response_data ) {
                        //
                        //     for( var product in response_data[ product_num ] ) {
                        //
                        //         //atrybuty
                        //         //console.log(product);
                        //         //wartosci atrybutow
                        //         //console.log(response_data[ product_num ][ product ]);
                        //     }
                        // }

                        init_form();

                       // console.log( response['data'] ) ;

                    } else {

                        alert ( 'response error' ) ;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert ('Request failed') ;
                },
            }) ;
        }


        $( '#ppw-button-next' ).on( 'click', function() {

            change_progress(1);

        });


        $( '#ppw-button-back' ).on( 'click', function() {

            change_progress(-1);

        });

        $( '#ppw-button-finish' ).on( 'click', function() {
            
            show_results();
        });


        //if AJAX is successful initialize things
        function init_form() {

            $( '#ppw-button-next' ).removeAttr('disabled');

        }

        function change_progress( value ) {

            page += value;
            //show it somehow
            $('#ppw-progress').text(page + '/' + num_of_groups);

            //back button appearance
            if(page < 2){

                $('#ppw-button-back').addClass('hidden');

            } else {

                $('#ppw-button-back').removeClass('hidden');

            }

            //next and final button appearance
            if(page == num_of_groups){

                $('#ppw-button-finish').removeClass('hidden');
                $('#ppw-button-next').addClass('hidden');

            } else {

                $('#ppw-button-finish').addClass('hidden');
                $('#ppw-button-next').removeClass('hidden');

            }

        }

        function show_results() {

            $('#ppw-button-finish').addClass('hidden');
            $('#ppw-button-back').addClass('hidden');

        }

    });


} ) ( jQuery );