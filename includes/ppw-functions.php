<?php

if ( !function_exists( 'ppw_option' ) ) {
	function ppw_option( $option_name ) {

		$options = get_option( 'ppw_settings' );

		if ( is_array( $options ) && array_key_exists( $option_name, $options ) ) {
			return $options[ $option_name ];
		}
		return null;
	}
}
