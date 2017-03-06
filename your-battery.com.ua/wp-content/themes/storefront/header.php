<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php
	do_action( 'storefront_before_header' ); ?>
	<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
		<div class="container-header">
					<div class="header-row">
						<?php
						/**
						 * Functions hooked into storefront_header action
						 * @hooked storefront_social_icons                     - 10
						 * @hooked storefront_site_branding                    - 20
						 * @hooked storefront_secondary_navigation             - 30
						 * @hooked storefront_product_search                   - 40
						 * @hooked storefront_primary_navigation_wrapper       - 42
						 * @hooked storefront_primary_navigation               - 50
						 * @hooked storefront_header_cart                      - 60
						 * @hooked storefront_primary_navigation_wrapper_close - 68
						 */
						do_action( 'storefront_header' ); ?>
						<a class="button-call" data-toggle="modal" data-target="#myModal">
							Заказать звонок
						</a>
						<div class="header-widget">
							<div class="widget widget-phone">
								<?php if (!dynamic_sidebar("header-widget") ) : ?>
								<?php endif; ?>
							</div>
							<div class="widget">
								<?php if (!dynamic_sidebar("mail-header-widget") ) : ?>
								<?php endif; ?>
							</div>
							<div class="widget">
								<?php if (!dynamic_sidebar("address-header-widget") ) : ?>
								<?php endif; ?>
							</div>
							<div class="widget">
								<span class="address-text">Бесплатная доставка по городу!</span>
							</div>
						</div>
					</div>

					<?php do_action( 'storefront_headernav' ); ?>
		</div>
	</header><!-- #masthead -->

<!--	--><?php //while ( have_posts() ) : the_post(); ?>
<!--		--><?php //the_content() ?>
<!--	--><?php //endwhile; // End of the loop. ?>
<!--	--><?php
//	/**
//	 * Functions hooked in to storefront_before_content
//	 *
//	 * @hooked storefront_header_widget_region - 10
//	 */
//	do_action( 'storefront_before_content' ); ?>

<!--	<div id="content" class="site-content" tabindex="-1">-->
<!--		<div class="col-full">-->
<!--		--><?php
//		/**
//		 * Functions hooked in to storefront_content_top
//		 *
//		 * @hooked woocommerce_breadcrumb - 10
//		 */
//		do_action( 'storefront_content_top' );
