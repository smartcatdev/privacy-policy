<?php

namespace privacy_policy_genius\util;

final class StringUtils {

    private function __construct() {}

    public static function get_strings() {
        return apply_filters( 'privacy_policy_genius_strings', array() );
    }

    public static function localize_strings( array $strings ) {
        $localized_strings = array();

        foreach( $strings as $id => $string ) {
            $localized_strings[ $id ] = __( $string,\privacy_policy_genius\PLUGIN_ID );
        }

        return $localized_strings;
    }
}
