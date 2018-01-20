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

                        for( var product_num in response_data ) {

                            for( var product in response_data[ product_num ] ) {

                                //atrybuty
                               // console.log(product);
                                //wartosci atrybutow
                               // console.log(response_data[ product_num ][ product ]);
                            }
                        }

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

            count_points( page );
            change_progress( 1 );
            load_questions( page, page-1 );

        });


        $( '#ppw-button-back' ).on( 'click', function() {

            change_progress( -1 );
            load_questions( page, page+1 );

        });

        $( '#ppw-button-finish' ).on( 'click', function() {

            show_results();
        });


        //if AJAX is successful initialize things
        function init_form() {

            $( '#ppw-button-next' ).removeAttr( 'disabled' );

        }

        function change_progress( value ) {

            page += value;
            //show it somehow
            $( '#ppw-progress' ).text(page + '/' + num_of_groups );

            //back button appearance
            if(page < 2){

                $( '#ppw-button-back' ).addClass( 'hidden' );

            } else {

                $( '#ppw-button-back' ).removeClass( 'hidden' );

            }

            //next and final button appearance
            if(page == num_of_groups){

                $( '#ppw-button-finish').removeClass('hidden' );
                $( '#ppw-button-next').addClass('hidden' );

            } else {

                $( '#ppw-button-finish' ).addClass( 'hidden' );
                $( '#ppw-button-next' ).removeClass( 'hidden' );

            }

        }

        function load_questions( page, previous_page ) {

            var question_ids = [];
            var questions_groups = [];
            var groups = [];

            $( '#ppw-form' ).find( '.ppw-input-holder' ).each( function() {

                question_ids.push( this.id );
                questions_groups[ this.id ] = $( this ).attr( 'data-group' );
            });

            for (var qg in questions_groups) {

                if ( groups[ questions_groups[ qg ] ] == undefined ) {
                    groups[ questions_groups[ qg ] ] = new Array( qg );
                } else {
                    groups[ questions_groups[ qg ] ].push(qg);
                }
            }

            for( var qs in groups[ previous_page] ){

                $( '#' + groups[ previous_page ][ qs ] ).addClass( 'hidden' );

            }

            for( var qs in groups[ page ] ){

                $( '#' + groups[ page ][ qs ] ).removeClass( 'hidden' );

            }

        }

        function count_points( page ) {

            var current_question = 'ppw-form-q' + page;

            var value = $( 'input[name=' + current_question + ']:checked').val();
            console.log(value);
        }

        function show_results() {

            $('#ppw-button-finish').addClass('hidden');
            $('#ppw-button-back').addClass('hidden');

        }

    });


} ) ( jQuery );