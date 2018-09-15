<div class="wrap margin-right-300">
    <h1>
        <?php echo $title; ?>
    </h1>

    <div class="margin-top-20 width-100-pc">
        <div class="nav-tabs border-bottom-1 border-medium-grey">
            <span class="display-inline-block vertical-align-middle cursor-not-allowed">
                <a href="#" class="nav-tab active" data-tab="general">General</a>
            </span>

            <span class="display-inline-block vertical-align-middle">
                <a href="#" class="nav-tab" data-tab="content">Content</a>
            </span>

            <span class="display-inline-block vertical-align-middle">
                <a href="#" class="nav-tab" data-tab="styles">Styles</a>
            </span>
        </div>

        <div class="form-container">
            <form action="options.php" method="POST">
                <div data-tab-section="general">
                    <?php
                        include WP_PAYWALL_PLUGIN_DIR . '/admin/partials/section-general.php';
                    ?>
                </div>

                <div class="display-none" data-tab-section="content">
                    <?php
                        include WP_PAYWALL_PLUGIN_DIR . '/admin/partials/section-content.php';
                    ?>

                </div>        

                <div class="display-none" data-tab-section="styles">
                    <?php
                        include WP_PAYWALL_PLUGIN_DIR . '/admin/partials/section-styles.php';
                    ?>
                </div>

                <?php
                    submit_button();
                ?>
            </form> 
        </div>
    </div>
</div> 
