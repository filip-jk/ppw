( function($) {

    // Window resize actions

    $(document).ready(function() {
        'use strict';

        var num_of_groups = 3;
        var page = 1;

        //init_questions
        var question_ids = [];
        var questions_groups = [];
        var groups = [];

        //init products
        var products = [];


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

                        init_questions();

                        var response_data = response['data'];

                        products = init_products( response_data );

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

            count_points( groups[ page ], products );
            change_progress( 1 );
            load_questions( page, page-1, groups);

        });


        $( '#ppw-button-back' ).on( 'click', function() {

            change_progress( -1 );
            count_points( groups[ page ], products, -1);
            load_questions( page, page+1, groups);

        });

        $( '#ppw-button-finish' ).on( 'click', function() {

            count_points( groups[ page ], products );
            change_progress( 1 );
            load_questions( page, page-1, groups);
            show_results();
        });


        //if AJAX is successful initialize things
        function init_form() {

            $( '#ppw-button-next' ).removeAttr( 'disabled' );

        }

        function change_progress( value ) {

            if( page <= num_of_groups) {

                page += value;

                //show it somehow
                $( '#ppw-progress' ).html(page + '/' + num_of_groups );

                //back button appearance
                if(page < 2){

                    $( '#ppw-button-back' ).addClass( 'hidden' );

                } else {

                    $( '#ppw-button-back' ).removeClass( 'hidden' );

                }

                //next and final button appearance
                if(page >= num_of_groups){

                    $( '#ppw-button-finish').removeClass('hidden' );
                    $( '#ppw-button-next').addClass('hidden' );

                } else {

                    $( '#ppw-button-finish' ).addClass( 'hidden' );
                    $( '#ppw-button-next' ).removeClass( 'hidden' );

                }
            } else {

            }
        }

        function init_questions() {

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
        }

        function init_products( products_data ) {

            var products = [];

            for( var product_num in products_data ) {

                    var data = {
                        'title' : products_data[ product_num ][ 'title' ],
                        'data' : products_data[ product_num ][ 'data' ],
                        'points' : 0,
                        'excluded' : false
                    }
                    products.push( data );
            }

            return products;

        }

        function load_questions( page, previous_page, groups ) {

            for( var qs in groups[ previous_page ] ){

                $( '#' + groups[ previous_page ][ qs ] ).addClass( 'hidden' );

            }

            console.log(groups[ page ]);
            for( var qs in groups[ page ] ){

                $( '#' + groups[ page ][ qs ] ).removeClass( 'hidden' );

            }

        }

        function count_points( groups, products, direction) {

            direction = direction || 1;

            for( var qnum in groups ) {

                var current_question = groups[qnum] + '-form';

                var value = $( 'input[name=' + current_question + ']:checked').val();

                //np ppw-q1-a2
                var chosen_question_id = groups[qnum] + "-" + value;

                for( var product_num in products) {

                    var product = products[product_num]

                    if( product.excluded != true ) {

                        var question_points = product.data[chosen_question_id][0];

                        if (question_points == 0) {

                            product.excluded = true;

                        } else {

                            product.points += Number(question_points) * direction;

                        }
                    } else {

                        //product excluded

                    }

                    //poodbnie np z q1-a1
                    //  console.log(product.data['ppw-description'][0])

                }

            }

            console.log(products);

        }

        function show_results() {


             $('#ppw-progress').addClass('hidden');
             $('#ppw-button-finish').addClass('hidden');
             $('#ppw-button-back').addClass('hidden');
             $('#ppw-results').removeClass('hidden');

            //sort descending
            products.sort( function( a, b ) {

                    if (a.points < b.points) {
                        return 1;
                    }
                    if (b.points < a.points) {
                        return -1;
                    }
                    return 0;
                }
            );

            var show_number = 3;

            for( var product_num in products) {

                var product = products[product_num]

                //what if some products got the same value?
                if(product.excluded == false && show_number > 0) {
                    var product_description = product.data['ppw-description'][0];
                    var product_recommendation = product.data['ppw-recommendation'][0];

                    console.log(product.title + ' | ' + product.points + ' | ' + product.excluded
                        + ' | ' + product_description + ' | ' + product_recommendation);

                    $('#ppw-results').append('<p>' + (product.title + ' | ' + product.points + ' | ' + product.excluded
                        + ' | ' + product_description + ' | ' + product_recommendation) + '</p>');

                    show_number--;
                } else {
                    continue;
                }

            }

        }

    });


} ) ( jQuery );