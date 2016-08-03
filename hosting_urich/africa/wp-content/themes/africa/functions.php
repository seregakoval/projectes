<?php

function my_style(){
    wp_enqueue_style("style", get_template_directory_uri()."/style.css");
    wp_enqueue_script("js", get_template_directory_uri()."/js/js.js");
}
add_action('wp_enqueue_scripts','my_style');

function theme_register_nav_menu(){
    register_nav_menu("primary", 'Primary Menu');
}
add_action("after_setup_theme", 'theme_register_nav_menu');
add_image_size( 'post_thumb', 350, 270, true );
if(is_home()){
    $query->set('posts_per_page',8);
}
register_sidebar(
    array(
        'id' => 'true_foot',
        'name' => 'Футер',
        'description' => 'Перетащите сюда виджеты, чтобы добавить их в футер.',
        'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    )
);
register_sidebar(
    array(
        'id' => 'widget-sidebar',
        'name' => 'Sidebar',
        'description' => 'Перетащите сюда виджеты, чтобы добавить их в футер.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    )
);
function true_apply_categories_for_pages(){
    add_meta_box( 'categorydiv', 'Категории', 'post_categories_meta_box', 'page', 'side', 'normal'); // добавляем метабокс категорий для страниц
    register_taxonomy_for_object_type('category', 'page'); // регистрируем рубрики для страниц
}
// обязательно вешаем на admin_init
add_action('admin_init','true_apply_categories_for_pages');

function true_expanded_request_category($q) {
    if (isset($q['category_name'])) // если в запросе присутствует параметр рубрики
        $q['post_type'] = array('post', 'page'); // то, помимо записей, выводим также и страницы
    return $q;
}

add_filter('request', 'true_expanded_request_category');


/**
 * Определим константу, которая будет хранить путь к папке single
 */
define( SINGLE_PATH, TEMPLATEPATH . '/single' );

/**
 * Добавим фильтр, который будет запускать функцию подбора шаблонов
 */
add_filter( 'single_template', 'my_single_template' );

/**
 * Функция для подбора шаблона
 */
function my_single_template( $single ) {
    global $wp_query, $post;

    /**
     * Проверяем наличие шаблонов по ID поста.
     * Формат имени файла: single-ID.php
     */
    if ( file_exists( SINGLE_PATH . '/single-' . $post->ID . '.php' ) ) {
        return SINGLE_PATH . '/single-' . $post->ID . '.php';
    }

    /**
     * Проверяем наличие шаблонов для категорий, ищем по ID категории или слагу
     * Формат имени файла: single-cat-SLUG.php или single-cat-ID.php
     */
    foreach ( (array) get_the_category() as $cat ) :

        if ( file_exists( SINGLE_PATH . '/single-cat-' . $cat->slug . '.php' ) ) {
            return SINGLE_PATH . '/single-cat-' . $cat->slug . '.php';
        } elseif ( file_exists( SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php' ) ) {
            return SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php';
        }

    endforeach;

    /**
     * Проверяем наличие шаблонов для тэгов, ищем по ID тэга или слагу
     * Формат имени файла: single-tag-SLUG.php или single-tag-ID.php
     */
    $wp_query->in_the_loop = true;
    foreach ( (array) get_the_tags() as $tag ) :

        if ( file_exists( SINGLE_PATH . '/single-tag-' . $tag->slug . '.php' ) ) {
            return SINGLE_PATH . '/single-tag-' . $tag->slug . '.php';
        } elseif ( file_exists( SINGLE_PATH . '/single-tag-' . $tag->term_id . '.php' ) ) {
            return SINGLE_PATH . '/single-tag-' . $tag->term_id . '.php';
        }

    endforeach;
    $wp_query->in_the_loop = false;

    /**
     * Если ничего не найдено открываем стандартный single.php
     */
    if ( file_exists( SINGLE_PATH . '/single.php' ) ) {
        return SINGLE_PATH . '/single.php';
    }

    return $single;
}
add_action('wp_ajax_myaction', 'action_handler'); //работает для авторизованных пользователей
add_action('wp_ajax_nopriv_myaction', 'action_handler');

/*add_logo*/
function my_after_setup_theme() {
    /*add_image_size( 'my-theme-logo-size', 400, 400, true );*/
    add_theme_support( 'site-logo' );
}
add_action( 'after_setup_theme', 'my_after_setup_theme' );

add_filter( 'post-content-shortcodes-defaults', 'add_cat_id_arg_to_pcs' );
function add_cat_id_arg_to_pcs( $defaults=array() ) {
    $defaults['cat_id'] = null;
    return $defaults;
}/*
function fb_change_search_url_rewrite() {
    if ( is_search() && ! empty( $_GET['s'] ) ) {
        wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) );
        exit();
    }
}
add_action( 'template_redirect', 'fb_change_search_url_rewrite' );*/

