<?php
/*
 * Plugin Name: Privacy Policy Genius
 * Plugin URI: http://privacypolicy.guru/
 * Description: Instantly create a custom privacy policy for your website.
 * Version: 1.0.0
 * Author: Wael Hassan
 * Author URI: http://waelhassan.com
 * Text Domain: privacy_policy_genius
 *
 */

namespace privacy_policy_genius;

if( !defined( 'ABSPATH' ) ) {
    die;
}

include 'vendor/autoload.php';

const PLUGIN_ID = 'privacy_policy_genius';
const PLUGIN_VERSION = '1.0.0';

PrivacyPolicyGenius::boot( PLUGIN_ID, PLUGIN_VERSION, __FILE__ );
