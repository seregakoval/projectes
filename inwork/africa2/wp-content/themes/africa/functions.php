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
/*add_image_size( 'post_thumb', 263, 193, true );*/
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
