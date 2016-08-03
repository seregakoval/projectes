<?php
/*
Plugin Name: Amazing Posts Widget
Plugin URI: http://wordpress.org/plugins/amazing-post-widget/
Author: Fauzi Nugroho
Author URI: http://profiles.wordpress.org/faugro-1
Version: 1.1.0
Description: Amazing way to show your post, you can easily set your column, row, option to show it as slideshow, also the best part is you also can choose custom post type.
License: GPL2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Contributors: faugro
*/

/*  
Copyright 2013  Fauzi Nugroho (email : fau.gro@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/ 

// Block direct requests
if( !defined('ABSPATH') )
	die('-1');

if( !defined('PJ_AP_Version') )
	define( 'PJ_AP_Version', '1.0.0' );
	
define( 'PJ_AP_PATH', plugin_dir_path(__FILE__) );

include PJ_AP_PATH.'aq_resizer.php';

/** Initialize the widget on widgets_init */
function pj_load_amazing_posts_widget() {
	register_widget('PJ_Amazing_Posts_Widget');
}
add_action('widgets_init', 'pj_load_amazing_posts_widget' );

/** Register styles & scripts */
function register_apw_style() {
	wp_register_style( 'amazing-pw-styles', plugins_url( 'css/amazing-pw.css', __FILE__ ) );
	wp_enqueue_style( 'amazing-pw-styles' );
}

function register_apw_jquery() {
	wp_enqueue_script ( 'jquery' );
}

function register_apw_script() {
	wp_register_script( 'jquery-touchSwipe', plugins_url( 'js/jquery.touchSwipe.min.js', __FILE__ ), array('jquery'), '', true );
	wp_register_script( 'jquery-ls', plugins_url( 'js/jquery.liquid-slider.min.js', __FILE__ ), array('jquery'), '', true );
	wp_register_script( 'jquery_easing', plugins_url( 'js/jquery.easing.1.3.js', __FILE__ ), array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'register_apw_style' );
add_action( 'wp_enqueue_scripts', 'register_apw_jquery' );
add_action( 'wp_enqueue_scripts', 'register_apw_script' );
		
global $pagenow;

if ( defined("WP_ADMIN") && WP_ADMIN ) {
	if ( 'widgets.php' == $pagenow || 'post.php' == $pagenow ) {
		function register_apw_admin_style( $dir ) {
			wp_register_style( 'amazing-posts-widget',  plugins_url( 'css/admin.css', __FILE__ ), array() );
			wp_enqueue_style( 'amazing-posts-widget' );
		}
		add_action( 'admin_enqueue_scripts', 'register_apw_admin_style' );
	}
}


/**
 * Amazing Posts Widget Class
 */
class PJ_Amazing_Posts_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		
		parent::__construct(
	 		'pj_ap_widget', // Base ID
			'Amazing Posts Widget', // Name
			array( 'description' => __( 'Display posts with Amazing way', 'pancenjoss_amazing' ) ) // Args
		);
		
		// Hooks fired when the Widget is activated and deactivated
		// register_activation_hook( __FILE__, array( $this, 'activate' ) );
		// register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		
		
		// $this->directory	= plugins_url( '/', __FILE__ );
		
	}
	

   /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
    function widget($args, $instance) {	
        extract( $args );
		extract( $instance );
				
		$title = apply_filters( 'widget_title', empty( $title ) ? '' : $title );
		
		// if ( empty($template) ) $template = 'amaz-columns.php';
		
		$post_types = get_post_types();
		unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
		
		if($post_type == 'all') {
			$post_type_array = $post_types;
		} else {
			$post_type_array = $post_type;
		}
		
		$number = $rows*$columns;

		// Setup the query
		$i=0;
		$argss=array();
		while($i<$pages_number)
		{
			$argss[$i] = array(
				'ignore_sticky_posts' => 1,
				'cat' 				=> $categories,
				'post_type'			=> $post_type_array,
				'post_status'		=> array('publish', 'inherit'),
				'posts_per_page'	=> $number,
				'offset'			=> $number*$i+$offset,
				'orderby'			=> $orderby,
				'order'				=> $order,
			);
			$i++;
		}
		
		// Get the posts for this instance
		
		echo $before_widget;

		if ( !empty($title) ) {
			echo $before_title . $title . $after_title; }
			
		include ( PJ_AP_PATH . 'views/'.$template );
        
		echo $after_widget;
    }

    /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
    function update( $new_instance, $old_instance ) {
		
		// Get our defaults to test against
		// $this->posttypes	= get_post_types( array('public' => true ), 'objects' );
		// $this->taxonomies	= get_taxonomies( array('public' => true ), 'objects' );
		// $this->thumbsizes	= get_intermediate_image_sizes();
		$this->orderbys		= array(
			'date'		 	=> __('Publish Date', 'pancenjoss_amazing'),
			'title'			=> __('Title', 'pancenjoss_amazing'),
			'menu_order'	=> __('Menu Order', 'pancenjoss_amazing'),
			'ID'			=> __('Post ID', 'pancenjoss_amazing'),
			'author'		=> __('Author', 'pancenjoss_amazing'),
			'name'	 		=> __('Post Slug', 'pancenjoss_amazing'),
			'comment_count'	=> __('Comment Count', 'pancenjoss_amazing'),
			'rand'			=> __('Random', 'pancenjoss_amazing'),
		);
		$this->orders		= array(
			'ASC'	=> __('Ascending', 'pancenjoss_amazing'),
			'DESC'	=> __('Descending', 'pancenjoss_amazing'),
		);
		
		$instance 				= $old_instance;
		$instance['title']		= strip_tags( $new_instance['title'] );
		$instance['categories']	= $new_instance['categories'];
		$instance['post_type']	= $new_instance['post_type'];
		$instance['offset']		= (int) $new_instance['offset'];
		$instance['orderby']	= ( array_key_exists( $new_instance['orderby'], $this->orderbys ) ? $new_instance['orderby'] : 'date' );
		$instance['order']		= ( array_key_exists( $new_instance['order'], $this->orders ) ? $new_instance['order'] : 'DESC' );
		$instance['thumbnail']	= ( isset(  $new_instance['thumbnail'] ) ? (int) $new_instance['thumbnail'] : '' ); // change to '', previously '0', due to a bug, when use siteorigin page builder, always return to default after saving the post.
		$instance['post_title']	= ( isset(  $new_instance['post_title'] ) ? (int) $new_instance['post_title'] : '' ); // change to '', previously '0'
		$instance['post_padding']		= (int) $new_instance['post_padding'];
		$instance['excerpt_length']		= (int) $new_instance['excerpt_length'];
		$instance['pages_number']		= (int) $new_instance['pages_number'];
		$instance['rows']		= (int) $new_instance['rows'];
		$instance['columns']		= (int) $new_instance['columns'];
		$instance['img_width']		= (int) $new_instance['img_width'];
		$instance['img_height']		= (int) $new_instance['img_height'];
		$instance['template']	= strip_tags( $new_instance['template'] );
        
        return $instance;
      
    }

	function get_amaz_templates(){
		$templates = array();

		foreach(glob(plugin_dir_path(__FILE__).'/views/amaz*.php') as $file) {
			$templates[] = basename($file);
		}
		foreach(glob(PJ_AP_PATH.'/views/amaz*.php') as $file){
			$templates[] = basename($file);
		}
		$templates = array_unique($templates);
		sort($templates);

		return $templates;
	}

    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
    function form( $instance ) {
    	
   		// $this->posttypes	= get_post_types( array('public' => true ), 'objects' );
		// $this->taxonomies	= get_taxonomies( array('public' => true ), 'objects' );
		// $this->thumbsizes	= get_intermediate_image_sizes();
		$this->orderbys		= array(
			'date'		 	=> __('Publish Date', 'pancenjoss_amazing'),
			'title'			=> __('Title', 'pancenjoss_amazing'),
			'menu_order'	=> __('Menu Order', 'pancenjoss_amazing'),
			'ID'			=> __('Post ID', 'pancenjoss_amazing'),
			'author'		=> __('Author', 'pancenjoss_amazing'),
			'name'	 		=> __('Post Slug', 'pancenjoss_amazing'),
			'comment_count'	=> __('Comment Count', 'pancenjoss_amazing'),
			'rand'			=> __('Random', 'pancenjoss_amazing'),
		);
		$this->orders		= array(
			'ASC'	=> __('Ascending', 'pancenjoss_amazing'),
			'DESC'	=> __('Descending', 'pancenjoss_amazing'),
		);
		
		$instance = wp_parse_args( (array) $instance, array(
			'title'		=> '',
			'categories' => 'all',
			'post_type' => 'post',
			'offset'	=> '0',
			'orderby'	=> 'date',
			'order'		=> 'DESC',
			'post_title' => '1',
			'post_padding' => '20',
			'excerpt_length' => '40',
			'pages_number' => '1',
			'rows'		=> '1',
			'columns'	=> '3',
			'thumbnail' => '1',
			'img_width' => '383',
			'img_height' => '200',
			'template'	=> 'amaz-columns.php',
		) );
		
		extract( $instance );

		$templates = $this->get_amaz_templates();
		
		include ( PJ_AP_PATH. 'views/admin-amazing.php' );
        
    }	

} // class PJ_Amazing_Posts_Widget

/*-----------------------------------------------------------------------------------*/
// Latest Posts
// Example Use: [pj_apw post_title="true" excerpt_length="true" categories="all" thumbnail="true" img_width="250" img_height="150" rows="2" columns="1" pages_number="2" template="amaz-columns.php"]
/*-----------------------------------------------------------------------------------*/

function pj_apw_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'categories' => 'all',
		'post_type' => 'post',
		'offset'	=> '0',
		'orderby'	=> 'date',
		'order'		=> 'DESC',
		'post_title' => 'true',
		'post_padding' => '20',
		'excerpt_length' => '40',
		'pages_number' => '1',
		'rows'		=> '1',
		'columns'	=> '3',
		'thumbnail' => 'true',
		'img_width' => '383',
		'img_height' => '200',
		'template'	=> 'amaz-columns.php'
	), $atts));
	global $post;
	
		$post_types = get_post_types();
		unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
		
		if($post_type == 'all') {
			$post_type_array = $post_types;
		} else {
			$post_type_array = $post_type;
		}
		
		$number = $rows*$columns;

		// Setup the query
		$i=0;
		$argss=array();
		while($i<$pages_number)
		{
			$argss[$i] = array(
				'ignore_sticky_posts' => 1,
				'cat' 				=> $categories,
				'post_type'			=> $post_type_array,
				'post_status'		=> array('publish', 'inherit'),
				'posts_per_page'	=> $number,
				'offset'			=> $number*$i+$offset,
				'orderby'			=> $orderby,
				'order'				=> $order,
			);
			$i++;
		}
		
		// Get the posts for this instance
		
		include ( PJ_AP_PATH . 'views/'.$template );
		
}
add_shortcode("pj_apw", "pj_apw_shortcode");