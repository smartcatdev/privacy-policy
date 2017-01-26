<?php

namespace privacy_policy_genius;

use smartcat\core\AbstractPlugin;

class PrivacyPolicyGenius extends AbstractPlugin {

    public function start() {
        $this->add_api_subscriber( include_once $this->dir . '/config/admin_settings.php' );
    }
}
