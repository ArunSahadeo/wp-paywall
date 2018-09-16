<?php

if ( is_admin() )
{
    require_once WP_PAYWALL_PLUGIN_DIR . '/admin/class-wp-paywall-admin.php';
    $paywallAdminClass = new WP_Paywall_Admin();
    $paywallAdminClass->init();

    require_once WP_PAYWALL_PLUGIN_DIR . '/admin/class-wp-paywall-admin-meta.php';

    $paywallAdminMetaClass = new WP_Paywall_Admin_Meta();
    $paywallAdminMetaClass->init();
}

else
{
    require_once WP_PAYWALL_PLUGIN_DIR . '/public/class-wp-paywall-public.php';
    $paywallPublicClass = new WP_Paywall_Public();
    $paywallPublicClass->init();
}
