<?php

namespace privacy_policy_genius;

use smartcat\core\AbstractPlugin;
use smartcat\core\HookSubscriber;

class PrivacyPolicyGenius extends AbstractPlugin implements HookSubscriber {

    public function start() {
        $this->add_api_subscriber( $this );
        $this->add_api_subscriber( include_once $this->dir . '/config/admin_settings.php' );

        add_shortcode( 'privacy_policy2', function () {
            include_once $this->dir . '/templates/template.php';
        } );
    }

    public function activate() {
        $option = get_option( 'policy-plugin-options' );

        if( $option != false ) {
            include_once $this->dir . '/migrate.php';
        }
    }

    public function get_string_resources() {
        if( empty( $this->strings ) ) {
            $file = file_get_contents( $this->dir . '/res/strings.json' );
            $this->strings = json_decode( $file, true );
        }

        return $this->strings;
    }

    public function subscribed_hooks() {
        return array(
            'privacy_policy_genius_strings' => array( 'get_string_resources' )
        );
    }

    public static function countries() {
        return array(
            ''          => __( 'Global', PLUGIN_ID ),
            'us'        => __( 'United States', PLUGIN_ID ),
            'ca'        => __( 'Canada', PLUGIN_ID ),
            'hk'        => __( 'Hong Kong', PLUGIN_ID ),
            'ru'        => __( 'Russian Federation', PLUGIN_ID ),
        );
    }
}
