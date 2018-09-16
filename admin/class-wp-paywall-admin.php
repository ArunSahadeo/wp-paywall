<?php
/*
 * WP Paywall admin class
*/

// Exit if accessed directly

if ( !defined('ABSPATH') )
{
    die( 'Cannot access directly!' );
}

/**
 * Plugin admin class
*/

class WP_Paywall_Admin
{

    protected $currencies = [
        'GBP',
        'USD'
    ];

    public function __construct()
    {
        //
    }

    // Initialise class and start making calls to WordPress
    public function init()
    {
        add_action( 'admin_menu', array($this, 'installMenu') );    
        add_action( 'admin_init', array($this, 'registerSettings') );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueueScripts') );
    }

    public function registerSettings()
    {
        $this->registerSettingsGeneral();
        $this->registerSettingsContent();
        $this->registerSettingsStyles();
    }

    public function enqueueScripts()
    {
        wp_enqueue_style( 'wpp-admin-style', WP_PAYWALL_PLUGIN_URL . '/assets/css/admin-style.css' );
        wp_enqueue_script( 'wpp-admin-scripts', WP_PAYWALL_PLUGIN_URL . '/assets/js/admin-scripts.js' );
    }

    public function installMenu()
    {
        $settingsPageArgs = [
            'page_title'    => __('Paywall', 'paywall'),
            'menu_title'    => __('Paywall', 'paywall'),
            'capability'    => 'manage_options',
            'menu_slug'     => 'wp-paywall',
            'function'      => array($this, 'renderSettingsPage')
        ];
        
        $this->createSettingsPage($settingsPageArgs);
    }

    public function createSettingsPage($settingsPageArgs = [])
    {
        add_options_page(
            $settingsPageArgs['page_title'],
            $settingsPageArgs['menu_title'],
            $settingsPageArgs['capability'],
            $settingsPageArgs['menu_slug'],
            $settingsPageArgs['function']
        );
    }

    public function renderSettingsPage()
    {
        $title = __( 'WP Paywall', 'wp-paywall' );
        $tabs = array(
            'options'   => __( 'General', 'wp-paywall' ),
            'content'   => __( 'Content', 'wp-paywall' ),
            'styles'    => __( 'Styles', 'wp-paywall' )
        );        

        include WP_PAYWALL_PLUGIN_DIR . '/admin/templates/page-options.php'; 
    }

    public function registerSettingsGeneral()
    {
        register_setting( 'wpp_options', 'wpp_options_settings' );   

        add_settings_section(
            'wpp_options_general',
            __( 'General Settings', 'wp-paywall'),
            array( $this, 'renderGeneralSettings' ),
            'wpp_options'
        );

        add_settings_field(
            'article_limit',
            __( 'Article Limit', 'wp-paywall' ),
            array( $this, 'renderLimitField' ),
            'wpp_options',
            'wpp_options_general'
        );

        add_settings_field(
            'article_limit_frequency',
            __( 'Article Limit Frequency', 'wp-paywall' ),
            array( $this, 'renderLimitFrequencyField' ),
            'wpp_options',
            'wpp_options_general'
        );

        add_settings_field(
            'article_counter',
            __( 'Article Counter', 'wp-paywall' ),
            array( $this, 'renderCounterField' ),
            'wpp_options',
            'wpp_options_general'
        );

        add_settings_field(
            'excluded_posts',
            __( 'Excluded Posts', 'wp-paywall' ),
            array( $this, 'renderExcludedPostsField' ),
            'wpp_options',
            'wpp_options_general'
        );

        add_settings_field(
            'excluded_post_types',
            __( 'Excluded Post Types', 'wp-paywall' ),
            array( $this, 'renderExcludedPostTypesField' ),
            'wpp_options',
            'wpp_options_general'
        );

        add_settings_field(
            'accepted_payment_providers',
            __( 'Accepted Payment Providers', 'wp-paywall' ),
            array( $this, 'renderAcceptedProvidersField' ),
            'wpp_options',
            'wpp_options_general'
        );

        add_settings_field(
            'default_currency',
            __( 'Default currency', 'wp-paywall' ),
            array( $this, 'renderCurrencyField' ),
            'wpp_options',
            'wpp_options_general'
        );

        add_settings_field(
            'subscription_fee',
            __( 'Subscription fee', 'wp-paywall' ),
            array( $this, 'renderSubscriptionFeeField' ),
            'wpp_options',
            'wpp_options_general'
        );

        add_settings_field(
            'subscription_period',
            __( 'Subscription period', 'wp-paywall' ),
            array( $this, 'renderSubscriptionPeriodField' ),
            'wpp_options',
            'wpp_options_general'
        );

        add_settings_field(
            'subscription_period_frequency',
            __( 'Subscription period frequency', 'wp-paywall' ),
            array( $this, 'renderSubscriptionPeriodFrequencyField' ),
            'wpp_options',
            'wpp_options_general',
            [
                'class' => 'display-none subscription-frequency',
            ]
        );
    }

    public function registerSettingsContent()
    {
        register_setting( 'wpp_content', 'wpp_content_settings' );   

        add_settings_section(
            'wpp_content_settings',
            __( 'Content Settings', 'wp-paywall'),
            array( $this, 'renderContentSettings' ),
            'wpp_content'
        );

        add_settings_field(
            'bottom_bar_heading',
            __( 'Bottom Bar Heading', 'wp-paywall' ),
            array( $this, 'renderBottomBarHeadingField' ),
            'wpp_content',
            'wpp_content_settings'
        );

        add_settings_field(
            'bottom_bar_cta_text',
            __( 'Bottom Bar CTA Text', 'wp-paywall' ),
            array( $this, 'renderBottomBarCTATextField' ),
            'wpp_content',
            'wpp_content_settings'
        );

        add_settings_field(
            'paywall_overlay_text',
            __( 'Paywall Overlay Text', 'wp-paywall' ),
            array( $this, 'renderPaywallOverlayTextField' ),
            'wpp_content',
            'wpp_content_settings'
        );
    }

    public function registerSettingsStyles()
    {
        register_setting( 'wpp_styles', 'wpp_styles_settings' );   

        add_settings_section(
            'wpp_styles_settings',
            __( 'Styles Settings', 'wp-paywall'),
            array( $this, 'renderStylesSettings' ),
            'wpp_styles'
        );

        add_settings_field(
            'bottom_bar_cta_background',
            __( 'Bottom Bar CTA Background', 'wp-paywall' ),
            array( $this, 'renderBottomBarCTABackgroundTextField' ),
            'wpp_styles',
            'wpp_styles_settings'
        );

        add_settings_field(
            'paywall_overlay_background',
            __( 'Paywall Overlay Background', 'wp-paywall' ),
            array( $this, 'renderPaywallOverlayBackgroundTextField' ),
            'wpp_styles',
            'wpp_styles_settings'
        );
    
    }

    public function renderGeneralSettings()
    {
        echo '<p>' . __( 'These configuration settings affect how the plugin behaves', 'wp-paywall' ) . '</p>';    
    }

    public function renderLimitField()
    {
    ?>

    <input type="number" min="0" name="wpp_options_settings[article_limit]" />
    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please enter the number of articles a user can read for free before being required to sign up', 'wp-paywall' ); ?>
    </span>
    
    <?php
    }

    public function renderLimitFrequencyField()
    {
    ?>

    <table class="table-custom contains-radios">
        <tr>
            <td>
                <input type="radio" name="wpp_options_settings[article_limit_frequency][daily]" value="daily" /> Daily
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="wpp_options_settings[article_limit_frequency][weekly]" value="weekly" /> Weekly
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="wpp_options_settings[article_limit_frequency][monthly]" value="monthly" /> Monthly
            </td>
        </tr>
    </table>
    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please enter the frequency at which the limit should reset, i.e. daily, monthly etc.', 'wp-paywall' ); ?>
    </span>
    
    <?php
    }

    public function renderCounterField()
    {
    ?>

    <table class="table-custom contains-radios">
        <tr>
            <td>
                <input type="radio" data-visibility-toggle-target="#character_limit" name="wpp_options_settings[article_counter][characters]" value="characters" /> Characters
                <table class="margin-top-20 display-none visibility-field" id="character_limit">
                    <tr>
                        <td>
                            <label for="wpp_options_settings[article_counter][characters][limit]">
                                Character Limit:
                            </label>
                            <input type="number" name="wpp_options_settings[article_counter][characters][limit]" min="0" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" data-visibility-toggle-target="#paragraph_limit" name="wpp_options_settings[article_counter][paragraphs]" value="paragraphs" /> Paragraphs
                <table class="margin-top-20 display-none visibility-field" id="paragraph_limit">
                    <tr>
                        <td>
                            <label for="wpp_options_settings[article_counter][paragraph][limit]">
                                Paragraph Limit:
                            </label>
                            <input type="number" id="character_limit" name="wpp_options_settings[article_counter][characters][limit]" min="0" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please select whether you would like to limit articles by characters or paragraphs.', 'wp-paywall' ); ?>
    </span>
    
    <?php
    }

    public function renderExcludedPostsField()
    {
    ?>

    <input type="number" min="0" name="wpp_options_settings[excluded_posts]" />
    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please enter the post IDs of any posts or pages you wish to exclude from the paywall, delimited by a comma.', 'wp-paywall' ); ?>
    </span>
    
    <?php
    }

    public function renderExcludedPostTypesField()
    {
        $postArgs = [
            'public'    => true
        ];

        $postTypes = get_post_types($postArgs, 'objects');

        if ( count($postTypes) < 1 )
        {
            return;
        }
    ?>

    <table class="table-custom">
        <?php foreach ($postTypes as $postType): ?>
        <?php
            $label = $postType->label;
            $type = $postType->name;
            $format = '%s (<code>%s</code>)';
            $checkboxText = sprintf( $format, $label, $type );
        ?>
        <tr>
            <td>
                <input type="checkbox" value="" /> <?php echo $checkboxText; ?> 
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please select any post types that should be excluded from the paywall.', 'wp-paywall' ); ?>
    </span>
    
    <?php
    }

    public function renderAcceptedProvidersField()
    {
    ?>

    <table class="table-custom">
        <tr>
            <td>
                <input type="checkbox" name="wpp_options_settings[accepted_providers][visa]" value="visa" /> Visa
            </td>
        </tr>

        <tr>
            <td>
                <input type="checkbox" name="wpp_options_settings[accepted_providers][mastercard]" value="mastercard" /> Mastercard
            </td>
        </tr>

        <tr>
            <td>
                <input type="checkbox" name="wpp_options_settings[accepted_providers][maestro]" value="maestro" /> Maestro
            </td>
        </tr>
    </table>
    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please enable all payment providers deemed suitable for accepting payments from users to disable the paywall.', 'wp-paywall' ); ?>
    </span>
    
    <?php
    }

    public function renderSubscriptionFeeField()
    {
    ?>

    <input type="number" min="0" step="0.01" />

    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please set the fee for the subscription required to disable the paywall, formatted if necessary with decimal points.', 'wp-paywall' ); ?>
    </span>
    
    <?php
    }

    public function renderSubscriptionPeriodField()
    {
    ?>

    <input data-input-event-target=".subscription-frequency" type="number" min="1" />

    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please set the period for which the subscription is valid.', 'wp-paywall' ); ?>
    </span>
    
    <?php
    }

    public function renderSubscriptionPeriodFrequencyField()
    {
    ?>

    <select>
        <option value="0" disabled>
            Please select the frequency
        </option>

        <option value="1">
            Week(s)
        </option>

        <option value="2">
            Month(s)
        </option>

        <option value="3">
            Year(s)
        </option>
    </select>

    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please set the period frequency for which the subscription is valid.', 'wp-paywall' ); ?>
    </span>
    
    <?php
    }

    public function renderCurrencyField()
    {
        $currencies = $this->currencies;
        if (count($currencies) < 1)
        {
            return;
        }
    ?>
    <select>
        <option value="0" disabled>
            Please select a currency
        </option>
        <?php foreach ($currencies as $index => $currency): ?>
        <option value="<?php echo $index + 1; ?>">
            <?php echo $currency; ?>
        </option>
        <?php endforeach; ?> 
    </select>

    <span class="description display-block max-width-25-pc">
        <?php echo __( 'Please select a default currency.', 'wp-paywall' ); ?>

    </span>
    <?php
    }

    public function renderContentSettings()
    {
        echo '<p>' . __( 'Replace our filler text with handcrafted copy relevant to your audience', 'wp-paywall' ) . '</p>';    
    }

    public function renderBottomBarHeadingField()
    {
    ?>
    <input type="text" name="wpp_content_settings[bottom_bar_heading]" draggable value="Subscribe for just a [amount] per [subscription_period]" />
    <?php
    }

    public function renderBottomBarCTATextField()
    {
    ?>
    <input type="text" name="wpp_content_settings[bottom_bar_cta_text]" value="View Details" />
    <?php
    }

    public function renderPaywallOverlayTextField()
    {
    ?>
    <textarea class="width-100-pc" name="wpp_content_settings[paywall_overlay_text]" placeholder="Please enter the copy to be used"></textarea>
    <?php
    }

    public function renderStylesSettings()
    {
        echo '<p>' . __( 'Update our default styles in line with your own preferences.', 'wp-paywall' ) . '</p>';    
    }

    public function renderBottomBarCTABackgroundTextField()
    {
    ?>
    <input type="text" name="wpp_styles_settings[bottom_bar_cta_background]" /> 
    <?php
    }

    public function renderPaywallOverlayBackgroundTextField()
    {
    ?>
    <input type="text" name="wpp_styles_settings[paywall_overlay_background]" /> 
    <?php
    }
}
