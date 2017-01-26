<?php

namespace privacy_policy_genius;

use smartcat\core\AbstractPlugin;

class PrivacyPolicyGenius extends AbstractPlugin {

    public function start() {
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
