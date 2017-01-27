<?php

namespace privacy_policy_genius;

use smartcat\core\AbstractPlugin;
use smartcat\core\HookSubscriber;

class PrivacyPolicy extends AbstractPlugin implements HookSubscriber {

    public function start() {
        $this->add_api_subscriber( $this );
        $this->add_api_subscriber( include_once $this->dir . '/config/admin_settings.php' );

        add_shortcode( 'privacy_policy', function () {
            echo include_once $this->dir . '/templates/template.php';
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

    public function enqueue_admin_scripts() {
        wp_enqueue_script( 'privacy_policy_genious_admin_js', $this->url . '/assets/js/admin.js', array( 'jquery'), PLUGIN_VERSION );
    }

    public function subscribed_hooks() {
        return array(
            'admin_enqueue_scripts' => array( 'enqueue_admin_scripts' ),
            'privacy_policy_genius_strings' => array( 'get_string_resources' )
        );
    }

    public static function countries() {
        return array(
            ''          => __( 'The World', PLUGIN_ID ),
            'us'        => __( 'The United States', PLUGIN_ID ),
            'ca'        => __( 'Canada', PLUGIN_ID ),
            'hk'        => __( 'Hong Kong', PLUGIN_ID ),
            'ru'        => __( 'The Russian Federation', PLUGIN_ID ),
        );
    }
}
