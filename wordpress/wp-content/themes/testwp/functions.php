<?php
function wp_corenavi() {
    global $wp_query, $wp_rewrite;
    $pages = '';
    $max = $wp_query->max_num_pages;
    if (!$current = get_query_var('paged')) $current = 1;
    $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
    $a['total'] = $max;
    $a['current'] = $current;

    $total = 0; //1 - выводить текст "Страница N из N", 0 - не выводить
    $a['mid_size'] = 1; //сколько ссылок показывать слева и справа от текущей
    $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
    $a['prev_text'] = ''; //текст ссылки "Предыдущая страница"
    $a['next_text'] = ''; //текст ссылки "Следующая страница"

    if ($max > 1) echo '<nav class="navigation">';
    if ($total == 1 && $max > 1) $pages = '<span class="pages">Страница ' . $current . ' из ' . $max . '</span>'."\r\n";
    echo $pages . paginate_links($a);
    if ($max > 1) echo '</nav>';
}
if(!is_admin()){

    function my_style(){
        wp_enqueue_style('style', get_template_directory_uri().'/style.css');
    }
    add_action('wp_enqueue_scripts','my_style');
    function myscript(){
        wp_enqueue_script("js",get_template_directory_uri()."/js/js.js");
        wp_enqueue_script("ajaxupload.3.5",get_template_directory_uri()."/js/ajaxupload.3.5.js");
    }
    add_action("wp_enqueue_scripts","myscript");
}
   function theme_register_nav_menu(){
       register_nav_menu("primary",'Primary Menu');
   }
    add_action("after_setup_theme", 'theme_register_nav_menu');

    add_filter( 'pre_get_document_title', function(){
        global $post;

        if( $post->ID != 21 ) return; // выходим если это не нужна нам страница

        return 'Контакты';
    } );
        add_theme_support( 'post-thumbnails' );
add_action( 'pre_get_posts', 'cr_custom_post_per_page' );


/*
function true_register_wp_sidebars() {


    register_sidebar(
        array(
            'id' => 'true_side',
            'name' => 'Боковая колонка',
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.',
            'before_widget' => '<div id="%1$s" class="side widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );


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
}

add_action( 'widgets_init', 'true_register_wp_sidebars' );


*/


