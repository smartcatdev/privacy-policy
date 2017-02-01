<?php

namespace privacy_policy_genius;

use privacy_policy_genius\descriptor\Options;
use privacy_policy_genius\util\StringUtils;

$old_options = unserialize( get_option( 'policy-plugin-options' ) );
$strings = StringUtils::get_strings();


// Single key migration
if( isset( $old_options[ 'company_name' ] ) ) {
    add_option( Options::COMPANY_NAME, $old_options[ 'company_name' ] );
}

if( isset( $old_options[ 'address'] ) ) {
    add_option( Options::COMPANY_ADDRESS, $old_options['address'] );
}

if( isset( $old_options['city'] ) ) {
    add_option( Options::COMPANY_CITY, $old_options['city'] );
}

if( isset( $old_options['phone_number'] ) ) {
    add_option( Options::PHONE_NUMBER, $old_options['phone_number'] );
}

if( isset( $old_options['email_address'] ) ) {
    add_option( Options::EMAIL_ADDRESS, $old_options['email_address'] );
}

if( isset( $old_options['website'] ) ) {
    add_option( Options::WEBSITE, $old_options['website'] );
}

if( isset( $old_options['name_of_privacy_officer'] ) ) {
    add_option( Options::PRIVACY_OFFICER, $old_options['name_of_privacy_officer'] );
}

if( isset( $old_options['country'] ) ) {
    add_option( Options::JURISDICTION_COUNTRY, $old_options['country'] );
}

if( isset( $old_options['storage'] ) ) {
    add_option( Options::STORAGE_LOCATION, $old_options['storage'] );
}

if( isset( $old_options['destroy_or_erase'] ) ) {
    add_option( Options::INFO_DISPOSAL, $old_options['destroy_or_erase'] );
}

if( isset( $old_options['under_16'] ) && $old_options['under_16'] == 'yes' ) {
    add_option( Options::CHILD_USAGE, 'on' );
}

if( isset( $old_options['use_cookies'] ) && $old_options['use_cookies'] == 'yes' ) {
    add_option( Options::COOKIES_USAGE, 'on' );
}

if( isset( $old_options['do_disclosure'] ) && $old_options['do_disclosure'] == 'yes' ) {
    add_option( Options::INFO_TRANSFER, 'on' );
}


// Checkbox groups

if( isset( $old_options['collect'] ) && is_array( $old_options['collect'] ) ) {
    $data_collection = array();

    foreach ( $old_options['collect'] as $str ) {
        $key = array_find( $str, $strings['policies']['data_collection'] );

        if ( $key != false ) {
            $data_collection[] = $key;
        }
    }

    add_option( Options::DATA_COLLECTION, $data_collection );
}


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