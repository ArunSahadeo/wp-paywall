<?php

if ( !defined('ABSPATH') )
{
    exit;
}

class WP_Paywall_Public
{
    public function __construct()
    {
        //
    }

    public function init()
    {
       add_action( 'wp_enqueue_scripts', array($this, 'enqueueFrontendAssets') );  
       add_action( 'wp_footer', array($this, 'addNotificationBar'), 1000 );
    }

    public function enqueueFrontendAssets()
    {
       wp_enqueue_style( 'wp-paywall-style', WP_PAYWALL_PLUGIN_URL . '/assets/css/style.css' ); 
    }

    public function displayPaywall()
    {
        global $post;
        
        if ( isset($post->ID) )
        {
            $excludedPostTypes = get_option( 'excluded_post_types' );
            $exempt = get_post_meta( $post->ID, 'exempt_from_paywall', true );
            $postType = get_post_type( $post->ID );

            if ( in_array($postType, $excludedPostTypes) || $exempt == 1 )
            {
                return false;
            }
        }

        return true;
    }

    public function addNotificationBar()
    {
        
    }
} 
