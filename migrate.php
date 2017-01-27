<?php

namespace privacy_policy_genius;

use privacy_policy_genius\descriptor\Options;
use privacy_policy_genius\util\StringUtils;

$old_options = unserialize( get_option( 'policy-plugin-options' ) );
$strings = StringUtils::get_strings();


$data_collection = array();

foreach( $old_options['collect'] as $str ) {
    $key = array_find( $str, $strings['policies']['data_collection'] );

    if( $key != false ) {
        $data_collection[] = $key;
    }
}

add_option( Options::DATA_COLLECTION, $data_collection );


$info_use = array();

foreach( $old_options['ppp'] as $str ) {
    $key = array_find( $str, $strings['policies']['information_use'] );

    if( $key != false ) {
        $info_use[] = $key;
    }
}

add_option( Options::INFO_USE, $info_use );


$info_transfer = array();

foreach( $old_options['purposes'] as $str ) {
    $key = array_find( $str, $strings['policies']['information_transfer'] );

    if( $key != false ) {
        $info_transfer[] = $key;
    }
}

add_option( Options::TRANSFER_PURPOSE, $info_transfer );


function array_find( $needle, array $haystack ) {
    $result = false;

    foreach( $haystack as $key => $value ) {
        if( strcasecmp( trim( $needle ), trim( $value ) ) == 0 ) {
            $result = $key;
        }
    }

    return $result;
}

return true;