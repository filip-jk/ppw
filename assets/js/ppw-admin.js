( function($) {

    // Window resize actions

    $(document).ready(function() {
        'use strict';

        var question_numbers = 10;
        var group_numbers = 3;


        //load default product button action
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

        //remove default products button actions
        $( '#ppw-button-remove' ).on( 'click', function() {

            $.ajax ({
                url: ppw_wp_meta.wp_ajax_url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'call_remove_default_posts'
                },
                success: function ( resp ) {

                    var response = JSON.parse( resp.data );

                    if ( resp.success ) {

                        alert ( response['response'] );

                    } else {

                        alert ( response['response'] );
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert ('Remove failed');
                },
            }) ;

        });


        //load default questin groups
        $( '#ppw-button-load-groups' ).on( 'click', function() {

            $.ajax ({
                url: ppw_wp_meta.wp_ajax_url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'call_load_default_question_groups'
                },
                success: function ( resp ) {

                    if ( resp.success ) {

                        var response = JSON.parse( resp.data );

                        if ( resp.success ) {

                            set_group_numbers( question_numbers, group_numbers, response[ 'data' ] );

                            alert ( 'Groups loaded correctly!' ) ;

                        } else {

                            alert ( 'Loading default groups failed.' ) ;
                        }

                    } else {

                        alert ( 'Not loaded.' ) ;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert ('Request failed') ;
                },
            }) ;

        });


        $( '#ppw-group-number' ).on('focusin', function(){

            $( this ).data( 'oldval', $(this).val() );

        });


        $( '#ppw-group-number' ).on( 'change', function() {

            var new_group_number = $(this).val();

            //if new group number is positive integer
            if( new_group_number != '0' && new_group_number >>> 0 === parseFloat(new_group_number) ) {

                set_group_numbers( question_numbers, new_group_number );

            } else {

                $(this).val($(this).data('oldval'));

                alert ('Inserted wrong group number value!') ;

            }

        });


        function set_group_numbers( question_numbers, new_group_number, values_array) {

            values_array =  values_array || null;

            //creating additional array
            for( var i = 0, qn = [ i ]; i < question_numbers; qn[ i++ ] = i );

            var question_id_template = 'ppw-q%-number';

            for( var number in qn  ) {

                var id = question_id_template.replace('%', qn[number])

                if( values_array == null ) {

                    var old_value = $( '#' + id  ).val();

                } else {

                    var old_value = values_array[ id ];

                }

                id = '#' + id;


                $( id ).empty();
                for( var i = 0; i < new_group_number; i++ ) {

                    $( id ).append($('<option></option>').attr("value", i).text(i + 1));

                }

                if( old_value + 1 > new_group_number) {

                    $( id ).val(new_group_number - 1);

                } else {

                    $( id ).val(old_value);

                }

            }

        }



    });


} ) ( jQuery );