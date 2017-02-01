<?php

namespace privacy_policy_genius;

use privacy_policy_genius\descriptor\Options;
use smartcat\core\AbstractPlugin;
use smartcat\core\HookSubscriber;

class PrivacyPolicy extends AbstractPlugin implements HookSubscriber {

    public function start() {
        $this->add_api_subscriber( $this );
        $this->add_api_subscriber( include_once $this->dir . '/config/admin_settings.php' );

        add_shortcode( 'privacy_policy', function () {
            echo include_once $this->dir . '/templates/template.php';
        } );

        if( get_option( 'policy-plugin-options' ) != false ) {
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

    public function enqueue_scripts() {
        if( get_option( Options::DISPLAY_COOKIE ) == 'on' ) {
            wp_enqueue_script( 'privacy_policy_genius_cookie_js', $this->url . '/assets/js/cookie.js', array( 'jquery'), PLUGIN_VERSION );
            wp_enqueue_style( 'privacy_policy_genius_cookie_css', $this->url . '/assets/css/cookie.css', PLUGIN_VERSION );
        }
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_script( 'privacy_policy_genius_admin_js', $this->url . '/assets/js/admin.js', array( 'jquery'), PLUGIN_VERSION );
    }

    public function cookies_notification() {
        if( get_option( Options::DISPLAY_COOKIE ) == 'on' ) { ?>

            <div id="privacy_policy_cookies_notification">
                <div class="top">
                    <span class="close">&#10005</span>
                </div>
                <div class="bottom">
                    <button class="close">Accept</button>
                </div>
            </div>

        <?php }
    }

    public function subscribed_hooks() {
        return array(
            'wp_head' => array( 'cookies_notification' ),
            'admin_enqueue_scripts' => array( 'enqueue_admin_scripts' ),
            'wp_enqueue_scripts' => array( 'enqueue_scripts' ),
            'privacy_policy_genius_strings' => array( 'get_string_resources' )
        );
    }

    public static function countries() {
        return array(
            ''          => __( 'Global', PLUGIN_ID ),
            'us'        => __( 'The United States', PLUGIN_ID ),
            'ca'        => __( 'Canada', PLUGIN_ID ),
            'hk'        => __( 'Hong Kong', PLUGIN_ID ),
            'ru'        => __( 'The Russian Federation', PLUGIN_ID ),
        );
    }
}
