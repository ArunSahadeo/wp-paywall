<?php
/*
Plugin Name: WP Paywall
Plugin URI: https://github.com/ArunSahadeo/wp-paywall
Description: Providing a secure lock to your premium content
Author: Arun James Sahadeo <arunjamessahadeo@gmail.com>
Author URI: https://arunsahadeo.github.io
Text Domain: wp-paywall
Domain Path: /languages/
Version: 0.1
*/

define( 'WP_PAYWALL_VERSION', '0.1' );

define( 'WP_PAYWALL_PLUGIN', __FILE__ );

define( 'WP_PAYWALL_PLUGIN_DIR', untrailingslashit(dirname(WP_PAYWALL_PLUGIN)) );

if ( !defined('WP_PAYWALL_PLUGIN_URL') )
{
    define( 'WP_PAYWALL_PLUGIN_URL', plugin_dir_url(__FILE__) );
}

require_once WP_PAYWALL_PLUGIN_DIR . '/settings.php';
