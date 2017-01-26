<?php

namespace privacy_policy_genius;

use smartcat\admin\SettingsPage;

$admin = new SettingsPage(
    array(
        'page_title' => __( 'Privacy Guru', PLUGIN_ID ),
        'menu_title' => __( 'Privacy Guru', PLUGIN_ID ),
        'menu_slug' => 'privacy_guru'
    )
);

return $admin;
