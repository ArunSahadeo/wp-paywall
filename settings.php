<?php

if ( is_admin() )
{
    require_once WP_PAYWALL_PLUGIN_DIR . '/admin/class-wp-paywall-admin.php';
    $paywallAdminClass = new WP_Paywall_Admin();
    $paywallAdminClass->init();
}
