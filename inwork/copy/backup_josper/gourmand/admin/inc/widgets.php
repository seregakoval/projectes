<?php
/*********************************************************************************************

Register Global Sidebars

*********************************************************************************************/
function site5framework_widgets_init() {
	
		register_sidebar(array(
			'name' => __( 'Sidebar', 'site5framework' ),
			'id' => 'sidebar',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		));
		
		register_sidebar( array (
			'name' => __( 'Page', 'site5framework' ),
			'id' => 'page',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		));
	
}

add_action( 'init', 'site5framework_widgets_init' );
?>