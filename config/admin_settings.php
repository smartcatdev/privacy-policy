<?php

namespace privacy_policy_genius;

use privacy_policy_genius\admin\CheckBoxGroup;
use privacy_policy_genius\admin\RadioGroup;
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

$section_1->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_name',
        'option'        => 'privacy_policy_company_name',
        'value'         => get_option( 'privacy_policy_company_name' ),
        'label'         => __( 'Company Name', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_address',
        'option'        => '',
        'value'         => '',
        'label'         => __( 'Company Address', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_city',
        'option'        => '',
        'value'         => '',
        'label'         => __( 'Company City', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_phone',
        'option'        => '',
        'value'         => '',
        'type'          => 'tel',
        'label'         => __( 'Phone Number', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_email',
        'option'        => '',
        'value'         => '',
        'type'          => 'email',
        'label'         => __( 'Email Address', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
        array(
            'id'            => 'privacy_policy_company_website',
            'option'        => '',
            'value'         => '',
            'type'          => 'url',
            'label'         => __( 'Website', PLUGIN_ID ),
            'validators'    => array( new TextFilter() )
        )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_officer_name',
        'option'        => '',
        'value'         => '',
        'label'         => __( 'Name of privacy offer', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'privacy_policy_jurisdiction_country',
        'option'        => '',
        'value'         => '',
        'options'       => PrivacyPolicyGenius::countries(),
        'label'         => __( 'Country of jurisdiction', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( PrivacyPolicyGenius::countries(), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'privacy_policy_storage_country',
        'option'        => '',
        'value'         => '',
        'options'       => PrivacyPolicyGenius::countries(),
        'label'         => __( 'Location of personal information storage', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( PrivacyPolicyGenius::countries(), '' ) )
    )

) );

$section_2 = new SettingsSection( 'section_2', '' );

$strings = StringUtils::get_strings();

$section_2->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_data_collection',
        'option'        => '',
        'options'       => StringUtils::localize_strings( $strings['policies']['data_collection'] ),
        'value'         => '',
        'label'         => __( 'Data Collection', PLUGIN_ID ),
        'validators'    => array()
    )

) )->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_information_use',
        'option'        => '',
        'options'       => StringUtils::localize_strings( $strings['policies']['information_use'] ),
        'value'         => '',
        'label'         => __( 'Use of personal information', PLUGIN_ID ),
        'validators'    => array()
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_third_party_info',
        'option'        => '',
        'value'         => '',
        'label'         => __( 'Personal information transfer', PLUGIN_ID ),
        'desc'          => __( 'Does your website transfer personal information to third parties?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_information_transfer',
        'option'        => '',
        'options'       => StringUtils::localize_strings( $strings['policies']['information_transfer'] ),
        'value'         => '',
        'label'         => __( 'Purposes of transferring personal information', PLUGIN_ID ),
        'validators'    => array()
    )

) )->add_field( new RadioGroup(
    array(
        'id'            => 'privacy_policy_destroy_information',
        'option'        => '',
        'value'         => '',
        'break'         => true,
        'label'         => __( 'Personal information disposal', PLUGIN_ID ),
        'desc'          => __( 'How do you dispose personal information?', PLUGIN_ID ),
        'options'       => $options = array( 'destroy' => __( 'Destroy', PLUGIN_ID ), 'erase' => __( 'Erase', PLUGIN_ID ) ),
        'validators'    => array( new MatchFilter( $options, '' ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_age_usage',
        'option'        => '',
        'value'         => '',
        'label'         => __( 'Usage of website by children', PLUGIN_ID ),
        'desc'          => __( 'Is your website used by children under 13 years of age?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_cookies_usage',
        'option'        => '',
        'value'         => '',
        'label'         => __( 'Usage of cookies', PLUGIN_ID ),
        'desc'          => __( 'Does your website use cookies?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) );

$admin->add_section( $section_1 );
$admin->add_section( $section_2 );

return $admin;
