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
add_action( 'widgets_init', 'register_my_widgets_search' );
function register_my_widgets_search(){
	register_sidebar( array(
		'name' => 'Поиск товаров',
		'id' => 'search',
		'before_widget' => '<div id="%1$s" class="%2$s ">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	) );
}
add_action( 'widgets_init', 'register_my_widgets_home_main_category' );
function register_my_widgets_home_main_category(){
    register_sidebar( array(
        'name' => 'Категории на главной странице',
        'id' => 'home_main_category',
        'before_widget' => '<div id="%1$s" class="%2$s ">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ) );
}
add_action( 'widgets_init', 'register_my_widgets_home_filter' );
function register_my_widgets_home_filter(){
    register_sidebar( array(
        'name' => 'Фильтр',
        'id' => 'filter-product',
        'before_widget' => '<div id="%1$s" class="%2$s ">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ) );
}
register_nav_menus(array(
	'top'    => 'Меню категорий',    //Название месторасположения меню в шаблоне
));
//DELET button add to cart
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
function replace_excerpt($content) {
    return str_replace('Read more', '<a href="'. get_permalink() .'">Читать далее</a>',
        $content ); }
add_filter('the_excerpt', 'replace_excerpt');


//Убрать пополнительное описание
//remove_action( 'woocommerce_product_tabs', 'woocommerce_product_attributes_tab', 20 );
//remove_action( 'woocommerce_product_tab_panels', 'woocommerce_product_attributes_panel', 20 );
//
/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
