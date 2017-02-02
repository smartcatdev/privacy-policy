<?php

namespace privacy_policy_genius;

use privacy_policy_genius\descriptor\Options;
use smartcat\core\AbstractPlugin;
use smartcat\core\HookSubscriber;

class PrivacyPolicy extends AbstractPlugin implements HookSubscriber {

    public function start() {
        $this->add_api_subscriber( $this );
        $this->add_api_subscriber( include_once $this->dir . '/config/admin_settings.php' );

        if( get_option( Options::LAST_CONFIGURED ) != false ) {
            add_shortcode( 'privacy_policy', function () {
                echo include_once $this->dir . '/templates/template.php';
            } );
        }

        if( get_option( 'policy-plugin-options' ) != false ) {
            include_once $this->dir . '/migrate.php';
        }
    }

    public function configuration_notice() {
        if( !get_option( Options::LAST_CONFIGURED ) && get_current_screen()->id != 'settings_page_privacy_guru' ) { ?>

                <div class="notice notice-warning is-dismissible">
                    <p>
                        <span class="dashicons dashicons-warning"></span>
                        <?php _e( 'Privacy policy has not been configured!', PLUGIN_ID ); ?>
                        <a style="font-weight: bold; text-decoration: none"
                           href="<?php echo menu_page_url( 'privacy_guru', false ) . '&tab=policy_config'; ?>">
                            <?php _e( 'Configure Privacy Policy', PLUGIN_ID ); ?>
                        </a>
                    </p>
                </div>

        <?php }
    }

    public function add_action_links( $links ) {
        return array( 'settings' => '<a href="' . menu_page_url( 'privacy_guru', false ) . '">' . __( 'Settings', PLUGIN_ID ) . '</a>' ) + $links;
    }

    public function get_string_resources() {
        if( empty( $this->strings ) ) {
            $file = file_get_contents( $this->dir . '/res/strings.json' );
            $this->strings = json_decode( $file, true );
        }

        return $this->strings;
    }

    public function enqueue_scripts() {
        if( get_option( Options::DISPLAY_COOKIE_WARNING ) == 'on' ) {
            wp_enqueue_script( 'privacy_policy_genius_cookie_js', $this->url . '/assets/js/cookie.js', array( 'jquery'), PLUGIN_VERSION );
            wp_enqueue_style( 'privacy_policy_genius_cookie_css', $this->url . '/assets/css/cookie.css', PLUGIN_VERSION );
        }
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_script( 'privacy_policy_genius_admin_js', $this->url . '/assets/js/admin.js', array( 'jquery'), PLUGIN_VERSION );
    }

    public function cookies_notification() {
        if( get_option( Options::DISPLAY_COOKIE_WARNING ) == 'on' ) {

            $url = get_option( Options::POLICY_URL );
            $url_text = get_option( Options::COOKIE_WARN_URL_TEXT, Options\Defaults::COOKIE_WARN_URL_TEXT ); ?>

            <div id="privacy_policy_cookies_notification">
                <div class="top">
                    <span class="close">&#10005</span>
                </div>
                <div class="middle">
                    <p class="title"><?php _e( get_option( Options::COOKIE_WARN_TITLE, Options\Defaults::COOKIE_WARN_TITLE ), PLUGIN_ID ); ?></p>
                    <p class="message"><?php _e( substr( get_option( Options::COOKIE_WARN_MESSAGE, Options\Defaults::COOKIE_WARN_MESSAGE ), 0, 500 ), PLUGIN_ID ); ?></p>

                    <?php if( !empty( $url ) && !empty( $url_text ) ) : ?>
                        <p class="url">
                            <a href="<?php echo esc_url( $url ); ?>"><?php _e( $url_text, PLUGIN_ID ); ?></a>
                        </p>

                    <?php endif; ?>
                </div>
                <div class="bottom">
                    <button class="close">
                        <?php _e( get_option( Options::COOKIE_ACCEPT_BTN_TEXT, Options\Defaults::COOKIE_ACCEPT_BTN_TEXT ) ); ?>
                    </button>
                </div>
            </div>

        <?php }
    }

    public function subscribed_hooks() {
        return array(
            'plugin_action_links_' . plugin_basename( $this->file ) => array( 'add_action_links' ),
            'wp_head' => array( 'cookies_notification' ),
            'admin_enqueue_scripts' => array( 'enqueue_admin_scripts' ),
            'wp_enqueue_scripts' => array( 'enqueue_scripts' ),
            'privacy_policy_genius_strings' => array( 'get_string_resources' ),
            'admin_notices' => array( 'configuration_notice' )
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
