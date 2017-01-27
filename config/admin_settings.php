<?php

namespace privacy_policy_genius;

use privacy_policy_genius\admin\ArrayFilter;
use privacy_policy_genius\admin\CheckBoxGroup;
use privacy_policy_genius\admin\HiddenField;
use privacy_policy_genius\admin\RadioGroup;
use privacy_policy_genius\admin\UrlFilter;
use privacy_policy_genius\descriptor\Options;
use privacy_policy_genius\util\StringUtils;
use smartcat\admin\CheckBoxField;
use smartcat\admin\MatchFilter;
use smartcat\admin\SelectBoxField;
use smartcat\admin\SettingsPage;
use smartcat\admin\SettingsSection;
use smartcat\admin\TextField;
use smartcat\admin\TextFilter;

$admin = new SettingsPage(
    array(
        'page_title' => __( 'Privacy Policy Configuration', PLUGIN_ID ),
        'menu_title' => __( 'Privacy Guru', PLUGIN_ID ),
        'menu_slug' => 'privacy_guru'
    )
);

$section_1 = new SettingsSection( 'section_1', '' );

$countries = PrivacyPolicy::countries();

$section_1->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_name',
        'option'        => Options::COMPANY_NAME,
        'value'         => get_option( Options::COMPANY_NAME, '' ),
        'label'         => __( 'Company Name', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_address',
        'option'        => Options::COMPANY_ADDRESS,
        'value'         => get_option( Options::COMPANY_ADDRESS, '' ),
        'label'         => __( 'Company Address', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_city',
        'option'        => Options::COMPANY_CITY,
        'value'         => get_option( Options::COMPANY_CITY, '' ),
        'label'         => __( 'Company City', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_phone',
        'option'        => Options::PHONE_NUMBER,
        'value'         => get_option( Options::PHONE_NUMBER, '' ),
        'type'          => 'tel',
        'label'         => __( 'Phone Number', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_email',
        'option'        => Options::EMAIL_ADDRESS,
        'value'         => get_option( Options::EMAIL_ADDRESS, '' ),
        'type'          => 'email',
        'label'         => __( 'Email Address', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
        array(
            'id'            => 'privacy_policy_company_website',
            'option'        => Options::WEBSITE,
            'value'         => get_option( Options::WEBSITE, '' ),
            'type'          => 'url',
            'label'         => __( 'Website', PLUGIN_ID ),
            'validators'    => array( new UrlFilter() )
        )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_officer_name',
        'option'        => Options::PRIVACY_OFFICER,
        'value'         => get_option( Options::PRIVACY_OFFICER, '' ),
        'label'         => __( 'Name of privacy officer', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'privacy_policy_jurisdiction_country',
        'option'        => Options::JURISDICTION_COUNTRY,
        'value'         => get_option( Options::JURISDICTION_COUNTRY, '' ),
        'options'       => $countries,
        'label'         => __( 'Country of jurisdiction', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array_keys( $countries ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'privacy_policy_storage_country',
        'option'        => Options::STORAGE_LOCATION,
        'value'         => get_option( Options::STORAGE_LOCATION ),
        'options'       => $countries,
        'label'         => __( 'Location of personal information storage', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array_keys( $countries ), '' ) )
    )

) );

$section_2 = new SettingsSection( 'section_2', '' );

$date = current_time( 'timestamp', '', '', true );
$strings = StringUtils::get_strings();
$disposal_options = array( 'destroy' => __( 'Destroy', PLUGIN_ID ), 'erase' => __( 'Erase', PLUGIN_ID ) );

$section_2->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_data_collection',
        'option'        => Options::DATA_COLLECTION,
        'options'       => StringUtils::localize_strings( $strings['admin_checkbox_groups']['data_collection'] ),
        'value'         => CheckBoxGroup::get_option( Options::DATA_COLLECTION ),
        'label'         => __( 'Data Collection', PLUGIN_ID ),
        'validators'    => array( new ArrayFilter( array_keys( $strings['admin_checkbox_groups']['data_collection'] ) ) )
    )

) )->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_information_use',
        'option'        => Options::INFO_USE,
        'options'       => StringUtils::localize_strings( $strings['admin_checkbox_groups']['information_use'] ),
        'value'         => CheckBoxGroup::get_option( Options::INFO_USE, array() ),
        'label'         => __( 'Use of personal information', PLUGIN_ID ),
        'validators'    => array( new ArrayFilter( array_keys( $strings['admin_checkbox_groups']['information_use'] ) ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_info_transfer',
        'option'        => Options::INFO_TRANSFER,
        'value'         => get_option( Options::INFO_TRANSFER, '' ),
        'label'         => __( 'Personal information transfer', PLUGIN_ID ),
        'desc'          => __( 'Does your website transfer personal information to third parties?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_transfer_purpose',
        'option'        => Options::TRANSFER_PURPOSE,
        'options'       => StringUtils::localize_strings( $strings['admin_checkbox_groups']['information_transfer'] ),
        'value'         => CheckBoxGroup::get_option( Options::TRANSFER_PURPOSE ),
        'label'         => __( 'Purposes of transferring personal information', PLUGIN_ID ),
        'validators'    => array( new ArrayFilter( array_keys( $strings['admin_checkbox_groups']['information_transfer'] ) ) )
    )

) )->add_field( new RadioGroup(
    array(
        'id'            => 'privacy_policy_destroy_information',
        'option'        => Options::INFO_DISPOSAL,
        'value'         => get_option( Options::INFO_DISPOSAL, '' ),
        'break'         => true,
        'label'         => __( 'Personal information disposal', PLUGIN_ID ),
        'desc'          => __( 'How do you dispose personal information?', PLUGIN_ID ),
        'options'       => $disposal_options,
        'validators'    => array( new MatchFilter( array_keys( $disposal_options ), '' ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_age_usage',
        'option'        => Options::CHILD_USAGE,
        'value'         => get_option( Options::CHILD_USAGE, '' ),
        'label'         => __( 'Usage of website by children', PLUGIN_ID ),
        'desc'          => __( 'Is your website used by children under 13 years of age?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_cookies_usage',
        'option'        => Options::COOKIES_USAGE,
        'value'         => get_option( Options::COOKIES_USAGE, '' ),
        'label'         => __( 'Usage of cookies', PLUGIN_ID ),
        'desc'          => __( 'Does your website use cookies?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new HiddenField(
    array(
        'id'            => 'privacy_policy_last_updated',
        'option'        => Options::LAST_UPDATED,
        'value'         => $date,
        'validators'    => array( new MatchFilter( array( $date ), $date ) )
    )

) );

$admin->add_section( $section_1 );
$admin->add_section( $section_2 );

return $admin;
