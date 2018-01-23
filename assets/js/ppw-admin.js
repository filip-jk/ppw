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

                            alert ( response['response'] ) ;

                        } else {

                            alert ( response['response'] ) ;
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

            if( new_group_number != '0' && new_group_number >>> 0 === parseFloat(new_group_number) ) {

                //tmp constant value
                var question_numbers = 10;
                //tmp constant value
                var group_numbers = 3;

                for( var i = 0, qn = [ i ]; i < question_numbers; qn[ i++ ] = i );

                var question_id_template = '#ppw-q%-number';


                for( var number in qn  ) {

                    var id = question_id_template.replace('%', qn[number])

                    var old_value = $( id  ).val();

                    $( id ).empty();
                    for( var i = 0; i < new_group_number; i++ ) {

                        $( id ).append($('<option></option>').attr("value", i).text(i + 1));
                        console.log($( id ).val());
                    }

                    if( old_value + 1 > new_group_number) {

                        $( id ).val(new_group_number - 1);

                    } else {

                        $( id ).val(old_value);

                    }

                }

            } else {

                $(this).val($(this).data('oldval'));

                alert ('Inserted wrong group number value!') ;

            }



            // $.ajax ({
            //     url: ppw_wp_meta.wp_ajax_url,
            //     type: 'POST',
            //     dataType: 'JSON',
            //     data: {
            //         action: 'call_load_default_question_groups'
            //     },
            //     success: function ( resp ) {
            //
            //         if ( resp.success ) {
            //
            //             var response = JSON.parse( resp.data );
            //
            //             if ( resp.success ) {
            //
            //                 alert ( response['response'] ) ;
            //
            //             } else {
            //
            //                 alert ( response['response'] ) ;
            //             }
            //
            //         } else {
            //
            //             alert ( 'Not loaded.' ) ;
            //         }
            //     },
            //     error: function (xhr, ajaxOptions, thrownError) {
            //
            //         alert ('Request failed') ;
            //     },
            // }) ;



        });



    });


} ) ( jQuery );