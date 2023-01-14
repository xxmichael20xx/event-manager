<?php

if ( ! function_exists( 'toWords' ) ) {
    function toWords( $string ) {
        $string = str_replace( '_', ' ', $string );
        return ucwords( $string );
    }
}