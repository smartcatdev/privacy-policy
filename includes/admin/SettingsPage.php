<?php

namespace privacy_policy_genius\admin;


use privacy_policy_genius\PrivacyPolicy;
use smartcat\admin\TabbedSettingsPage;

class SettingsPage extends TabbedSettingsPage {

    public function render() {
        $active_tab = key( $this->tabs );

        if( !empty( $_REQUEST['tab'] ) && array_key_exists( $_REQUEST['tab'], $this->tabs ) ) {
            $active_tab = $_REQUEST['tab'];
        }

        ?>


        <div class="wrap">

            <h2 class="privacy_policy_admin_header">
                <?php echo $this->page_title; ?>
                <div class="privacy_policy_branding">
                    <a href="http://kidesign.io">
                        <img src="<?php echo PrivacyPolicy::plugin_url( \privacy_policy_genius\PLUGIN_ID ) . '\assets\img\ki_design_io.jpg'; ?>">
                    </a>
                </div>
            </h2>

            <?php  if( $this->type == 'menu' || $this->type == 'submenu' ) : ?>

                <?php settings_errors( $this->menu_slug ); ?>

            <?php endif; ?>

            <h2 class="nav-tab-wrapper">

                <?php foreach( $this->tabs as $tab => $title ) : ?>

                    <a href="<?php echo 'admin.php?page=' . $this->menu_slug . '&tab=' . $tab; ?>"
                       class="nav-tab <?php echo $active_tab == $tab ? 'nav-tab-active' : ''; ?>">

                        <?php echo $title; ?>

                    </a>

                <?php endforeach; ?>

            </h2>

            <form method="post" action="options.php">

                <?php settings_fields( $this->menu_slug . '_' .$active_tab ); ?>

                <?php do_settings_sections( $this->menu_slug . '_' . $active_tab ); ?>

                <?php submit_button(); ?>

            </form>

        </div>

    <?php }

}