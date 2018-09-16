<?php

if ( !defined('ABSPATH') )
{
    exit;
}

require_once WP_PAYWALL_PLUGIN_DIR . '/admin/metafields.php';

class WP_Paywall_Admin_Meta
{
    public function __construct()
    {
        $this->metaFields = new MetaFields(); 
    }

    public function init()
    {
       add_action( 'add_meta_boxes', array($this, 'addCustomMetaFields') ); 
    }

    public function addCustomMetaFields()
    {
        if ( !isset($this->metaFields) )
        {
            return;
        }     

        $this->metaFields->init();
        $metaFields = $this->metaFields->fetchMetaFields();
        if ( count($metaFields) < 1 )
        {
            return;
        }

        foreach ( $metaFields as $metaField )
        {
            add_meta_box(
                $metaField['ID'],
                $metaField['title'],
                array ( $this, $metaField['callback'] ),
                $metaField['screens'],
                $metaField['context'],
                $metaField['priority'],
                $metaField['fields']  
            );
        }
    }

    public function renderMetaField($post, $fields)
    {
        if ( isset($fields['args']) )
        {
            foreach ( $fields['args'] as $field )
            {
                switch ( $field['type'] )
                {
                    case 'checkbox':
                        $this->outputMetaFieldCheckbox($post, $field);
                    break;
                }
            }
        }   
    }

    public function outputMetaFieldCheckbox($post, $field)
    {
    ?>
    <div class="padding-25">
        <input type="checkbox" name="<?php echo $field['name']; ?>" />
        <label for="<?php echo $field['name']; ?>" class="vertical-baseline">
            <?php echo $field['title']; ?>
        </label> 
    </div>
    <?php        
    }

}
