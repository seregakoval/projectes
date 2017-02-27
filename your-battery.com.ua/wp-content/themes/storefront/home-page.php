<?php
/*
Template Name: Home-page
*/
?>
<?php get_header(); ?>
<section class="home-slider">
    <?php if (!dynamic_sidebar("home-slider") ) : ?>
    <?php endif; ?>
</section>
<div style="clear: both;"></div>
<section class="main-category">
    <div class="category-container">
        <?php
        wp_nav_menu(
            array(
                'menu'	=> 'Main-images-menu',
            )
        );?>
<!--        --><?php //do_action( 'homepage-main' ); ?>
<!--        --><?php //echo do_shortcode('[wa-wps]'); ?>
<!--        --><?php //if (!dynamic_sidebar("home_main_category") ) : ?>
<!--        --><?php //endif; ?>
    </div>
</section>
<?php
///**
// * Functions hooked in to homepage action
// *
// * @hooked storefront_homepage_content      - 10
// * @hooked storefront_product_categories    - 20
// * @hooked storefront_recent_products       - 30
// * @hooked storefront_featured_products     - 40
// * @hooked storefront_popular_products      - 50
// * @hooked storefront_on_sale_products      - 60
// * @hooked storefront_best_selling_products - 70
// */
////do_action( 'homepage-main' ); ?>
<div class="wrapper">
    <div class="container">
        <?php
        do_action( 'storefront_sidebar' ); ?>
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <?php while ( have_posts() ) : the_post();

                    do_action( 'storefront_page_before' );

                    get_template_part( 'content', 'page' );

                    /**
                     * Functions hooked in to storefront_page_after action
                     *
                     * @hooked storefront_display_comments - 10
                     */
                    do_action( 'storefront_page_after' );

                endwhile; // End of the loop. ?>

            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
</div>
<?php get_footer(); ?>
<?php wp_footer(); ?>
