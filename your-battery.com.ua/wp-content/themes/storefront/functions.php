<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version' => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce = require 'inc/woocommerce/class-storefront-woocommerce.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';
}
add_action( 'widgets_init', 'register_my_widgets' );
function register_my_widgets(){
    register_sidebar( array(
        'name' => 'Номера телефонов',
        'id' => 'header-widget',
        'before_widget' => '<div id="%1$s" class="%2$s phone">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ) );
}
add_action( 'widgets_init', 'register_my_widgets_mail' );
function register_my_widgets_mail(){
    register_sidebar( array(
        'name' => 'Почта header',
        'id' => 'mail-header-widget',
        'before_widget' => '<div id="%1$s" class="%2$s mail">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ) );
}
add_action( 'widgets_init', 'register_my_widgets_address_header' );
function register_my_widgets_address_header(){
    register_sidebar( array(
        'name' => 'Адрес в шапке',
        'id' => 'address-header-widget',
        'before_widget' => '<div id="%1$s" class="%2$s address">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ) );
}

add_action( 'widgets_init', 'register_my_widgets_home_slider' );
function register_my_widgets_home_slider(){
    register_sidebar( array(
        'name' => 'Слайдер на главной странице',
        'id' => 'home-slider',
        'before_widget' => '<div id="%1$s" class="%2$s ">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ) );
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
