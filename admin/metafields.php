<?php

class MetaFields
{
    protected $metaFields = [];

    public function __construct()
    {
        //
    }

    public function init()
    {
        $this->metaFields = $this->createMetaFields(); 
    }

    public function createMetaFields()
    {
        return array(
            array(
                'ID'    => 'wpp_post_settings',
                'title' => __( 'Paywall post settings', 'wp-paywall' ),
                'callback' => 'renderMetaField',
                'screens'   => array( 'page', 'post' ),
                'context'   => 'side',
                'priority'  => 'high',
                'fields' => array(
                    array(
                        'ID'    => 'wpp_exempt_post',
                        'name'  => 'wpp_exempt_post',
                        'title' => __( 'Exempt post from paywall?', 'wp_paywall' ),
                        'type'  => 'checkbox',
                        'class' => '',
                    )
                )        
            ),
        );
    }

    public function fetchMetaFields()
    {
        return $this->metaFields;
    }
}
