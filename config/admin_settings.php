<?php

namespace privacy_policy_genius;

use privacy_policy_genius\admin\RadioGroupField;
use smartcat\admin\CheckBoxField;
use smartcat\admin\MatchFilter;
use smartcat\admin\SettingsPage;
use smartcat\admin\SettingsSection;

$admin = new SettingsPage(
    array(
        'page_title' => __( 'Privacy Guru', PLUGIN_ID ),
        'menu_title' => __( 'Privacy Guru', PLUGIN_ID ),
        'menu_slug' => 'privacy_guru'
    )
);

$section_3 = new SettingsSection( 'section_3', '' );

$section_3->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_third_party_info',
        'option'        => '',
        'value'         => '',
        'label'         => __( 'Personal information transfer', PLUGIN_ID ),
        'desc'          => __( 'Does your website transfer personal information to third parties', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new RadioGroupField(
    array(
        'id' => 'privacy_policy_destroy_information',
        'option'        => '',
        'value'         => '',
        'break'         => true,
        'label'         => __( 'Personal information disposal', PLUGIN_ID ),
        'desc'          => __( 'How do you dispose personal information?', PLUGIN_ID ),
        'options'       => $options = array( 'destroy' => __( 'Destroy', PLUGIN_ID ), 'erase' => __( 'Erase', PLUGIN_ID ) ),
        'validators'    => array( new MatchFilter( $options, '' ) )
    )

) );

$admin->add_section( $section_3 );

return $admin;
