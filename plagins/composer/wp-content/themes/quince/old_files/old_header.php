<header id="site-header" class="<?php echo trim($header_class); ?>" role="banner">
    <div id="header-wrapper">
        <div id="header-container" class="clearfix">
            <div id="site-logo">
                <?php get_template_part( 'logo' ); // Include logo.php ?>
            </div>

            <nav id="site-navigation" role="navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu-container', 'fallback_cb' => 'mnky_no_menu') ); ?>

                <?php if( class_exists( 'WooCommerce' ) && ot_get_option('cart_button') != 'off' ) : ?>
                    <div class="header_cart_wrapper">
                        <?php global $woocommerce; ?>
                        <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php _e( 'View your shopping cart', 'quince' ); ?>" class="header_cart_link" >
                            <?php woocommerce_cart_button(); ?>
                        </a>
                        <?php if( ot_get_option('cart_widget') != 'off' ) {
                            woocommerce_cart_widget();
                        } ?>
                    </div>
                <?php endif; ?>

                <?php if( ot_get_option('search_button') != 'off' ) : ?>
                    <button id="trigger-header-search" class="search_button" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                <?php endif; ?>
            </nav><!-- #site-navigation -->

            <?php if( ot_get_option('search_button') != 'off' ) : ?>
                <div class="header-search">
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>

            <a href="#mobile-site-navigation" class="toggle-mobile-menu"><i class="fa fa-bars"></i></a>
        </div><!-- #header-container -->
    </div><!-- #header-wrapper -->
</header><!-- #site-header -->	