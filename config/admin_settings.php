<?php

namespace privacy_policy_genius;

use privacy_policy_genius\admin\ArrayFilter;
use privacy_policy_genius\admin\CharLimitFilter;
use privacy_policy_genius\admin\CheckBoxGroup;
use privacy_policy_genius\admin\HiddenField;
use privacy_policy_genius\admin\RadioGroup;
use privacy_policy_genius\admin\SettingsPage;
use privacy_policy_genius\admin\TextAreaField;
use privacy_policy_genius\admin\UrlFilter;
use privacy_policy_genius\descriptor\Options;
use privacy_policy_genius\util\StringUtils;
use smartcat\admin\CheckBoxField;
use smartcat\admin\MatchFilter;
use smartcat\admin\SelectBoxField;
use smartcat\admin\SettingsSection;
use smartcat\admin\TextField;
use smartcat\admin\TextFilter;

$admin = new SettingsPage(
    array(
        'page_title' => __( 'Privacy Policy', PLUGIN_ID ),
        'menu_title' => __( 'Privacy Guru', PLUGIN_ID ),
        'menu_slug'  => 'privacy_guru',
        'tabs'       => array(
            'general'       => __( 'General', PLUGIN_ID ),
            'policy_config' => __( 'Policy Configuration', PLUGIN_ID )
        )
    )
);

$company_info = new SettingsSection( 'company_info', __( 'Company Information', PLUGIN_ID ) );

$company_info->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_name',
        'option'        => Options::COMPANY_NAME,
        'value'         => get_option( Options::COMPANY_NAME, '' ),
        'label'         => __( 'Company Name', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_address',
        'option'        => Options::COMPANY_ADDRESS,
        'value'         => get_option( Options::COMPANY_ADDRESS, '' ),
        'label'         => __( 'Company Address', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_city',
        'option'        => Options::COMPANY_CITY,
        'value'         => get_option( Options::COMPANY_CITY, '' ),
        'label'         => __( 'Company City', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_phone',
        'option'        => Options::PHONE_NUMBER,
        'value'         => get_option( Options::PHONE_NUMBER, '' ),
        'type'          => 'tel',
        'label'         => __( 'Phone Number', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_company_email',
        'option'        => Options::EMAIL_ADDRESS,
        'value'         => get_option( Options::EMAIL_ADDRESS, '' ),
        'type'          => 'email',
        'label'         => __( 'Email Address', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
        array(
            'id'            => 'privacy_policy_company_website',
            'option'        => Options::WEBSITE,
            'value'         => get_option( Options::WEBSITE, home_url() ),
            'type'          => 'url',
            'placeholder'   => 'http://',
            'label'         => __( 'Website', PLUGIN_ID ),
            'required'      => true,
            'validators'    => array( new UrlFilter() )
        )

) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_officer_name',
        'option'        => Options::PRIVACY_OFFICER,
        'value'         => get_option( Options::PRIVACY_OFFICER, '' ),
        'label'         => __( 'Name of privacy officer', PLUGIN_ID ),
        'required'      => true,
        'validators'    => array( new TextFilter() )
    )

) );

$policy_config = new SettingsSection( 'policy_config', __( 'Policy Options', PLUGIN_ID ) );

$date = current_time( 'timestamp' );
$strings = StringUtils::get_strings();
$disposal_options = array( 'destroy' => __( 'Destroy', PLUGIN_ID ), 'erase' => __( 'Erase', PLUGIN_ID ) );
$countries = array( '' => __( 'Select a Country', PLUGIN_ID ) ) + PrivacyPolicy::countries();

$policy_config->add_field( new SelectBoxField(
    array(
        'id'            => 'privacy_policy_jurisdiction_country',
        'option'        => Options::JURISDICTION_COUNTRY,
        'value'         => get_option( Options::JURISDICTION_COUNTRY, '' ),
        'options'       => $countries,
        'label'         => __( 'Country of Jurisdiction', PLUGIN_ID ),
        'required'      => true,
        'desc'          => __( 'Country where this policy will apply to', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array_keys( $countries ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'privacy_policy_storage_country',
        'option'        => Options::STORAGE_LOCATION,
        'value'         => get_option( Options::STORAGE_LOCATION ),
        'options'       => $countries,
        'label'         => __( 'Storage Location', PLUGIN_ID ),
        'required'      => true,
        'desc'          => __( 'Country where personal information is stored', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array_keys( $countries ), '' ) )
    )

) )->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_data_collection',
        'option'        => Options::DATA_COLLECTION,
        'options'       => StringUtils::localize_strings( $strings['admin_checkbox_groups']['data_collection'] ),
        'value'         => CheckBoxGroup::get_option( Options::DATA_COLLECTION ),
        'label'         => __( 'Data Collected', PLUGIN_ID ),
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
        'option'        => Options::INFO_DISCLOSURE,
        'value'         => get_option( Options::INFO_DISCLOSURE, '' ),
        'label'         => __( 'Third party disclosure', PLUGIN_ID ),
        'desc'          => __( 'Does your website transfer personal information to third parties?', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxGroup(
    array(
        'id'            => 'privacy_policy_transfer_purpose',
        'option'        => Options::TRANSFER_PURPOSE,
        'options'       => StringUtils::localize_strings( $strings['admin_checkbox_groups']['information_transfer'] ),
        'value'         => CheckBoxGroup::get_option( Options::TRANSFER_PURPOSE ),
        'label'         => __( 'Purposes of transfer', PLUGIN_ID ),
        'validators'    => array( new ArrayFilter( array_keys( $strings['admin_checkbox_groups']['information_transfer'] ) ) )
    )

) )->add_field( new RadioGroup(
    array(
        'id'            => 'privacy_policy_destroy_information',
        'option'        => Options::INFO_DISPOSAL,
        'value'         => get_option( Options::INFO_DISPOSAL, '' ),
        'break'         => true,
        'label'         => __( 'Information disposal method', PLUGIN_ID ),
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
        'option'        => Options::LAST_CONFIGURED,
        'value'         => $date,
        'validators'    => array( new MatchFilter( array( $date ), $date ) )
    )

) );

$general = new SettingsSection( 'general', __( 'Cookies Usage Notification', PLUGIN_ID ) );

$general->add_field( new CheckBoxField(
    array(
        'id'            => 'privacy_policy_display_cookie',
        'option'        => Options::DISPLAY_COOKIE_WARNING,
        'value'         => get_option( Options::DISPLAY_COOKIE_WARNING, Options\Defaults::DISPLAY_COOKIE_WARNING ),
        'label'         => __( 'Display Usage Notification', PLUGIN_ID ),
        'desc'          => __( 'Display cookie warning to visitors of your website', PLUGIN_ID ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_cookie_title',
        'option'        => Options::COOKIE_WARN_TITLE,
        'value'         => get_option( Options::COOKIE_WARN_TITLE, Options\Defaults::COOKIE_WARN_TITLE ),
        'label'         => __( 'Notification Title', PLUGIN_ID ),
        'desc'          => __( 'Title to display on notification', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
) )->add_field( new TextAreaField(
    array(
        'id'            => 'privacy_policy_cookie_message',
        'option'        => Options::COOKIE_WARN_MESSAGE,
        'size'          => array( 50, 10 ),
        'max_chars'     => 500,
        'value'         => get_option( Options::COOKIE_WARN_MESSAGE, Options\Defaults::COOKIE_WARN_MESSAGE ),
        'label'         => __( 'Notification Message', PLUGIN_ID ),
        'desc'          => __( 'Message to display on notification (500 characters Max.)', PLUGIN_ID ),
        'validators'    => array( new TextFilter(), new CharLimitFilter( 500, '...' ) )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_cookie_accept_btn_text',
        'option'        => Options::COOKIE_ACCEPT_BTN_TEXT,
        'value'         => get_option( Options::COOKIE_ACCEPT_BTN_TEXT, Options\Defaults::COOKIE_ACCEPT_BTN_TEXT ),
        'label'         => __( 'Accept Button Text', PLUGIN_ID ),
        'desc'          => __( 'Text to display on notification accept button', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_url',
        'type'          => 'url',
        'option'        => Options::POLICY_URL,
        'value'         => get_option( Options::POLICY_URL, '' ),
        'label'         => __( 'Policy Page URL', PLUGIN_ID ),
        'placeholder'   => 'http://',
        'desc'          => __( 'URL of page containing privacy policy', PLUGIN_ID ),
        'validators'    => array( new UrlFilter() )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'privacy_policy_url_text',
        'option'        => Options::COOKIE_WARN_URL_TEXT,
        'value'         => get_option( Options::COOKIE_WARN_URL_TEXT, Options\Defaults::COOKIE_WARN_URL_TEXT ),
        'label'         => __( 'Policy URL Text', PLUGIN_ID ),
        'desc'          => __( 'Text to display for link to privacy policy', PLUGIN_ID ),
        'validators'    => array( new TextFilter() )
    )
) );

$admin->add_section( $company_info, 'policy_config' );
$admin->add_section( $policy_config, 'policy_config' );
$admin->add_section( $general, 'general' );

return $admin;
