<?php
// Recipes Custom Post Type
$labels = array(
	'name' => _x('Recipes', 'post type general name', 'site5framework'),
    'singular_name' => _x('Recipes', 'post type singular name', 'site5framework'),
    'add_new' => _x('Add New', 'work', 'site5framework'),
    'add_new_item' => __('Add New Recipes', 'site5framework'),
    'edit_item' => __('Edit Recipes', 'site5framework'),
    'new_item' => __('New Recipes', 'site5framework'),
    'view_item' => __('View Recipes', 'site5framework'),
    'search_items' => __('Search Recipes', 'site5framework'),
    'not_found' =>  __('No work found', 'site5framework'),
    'not_found_in_trash' => __('No recipes entry found in Trash', 'site5framework'),
    'parent_item_colon' => ''
  );
register_post_type('recipes', array(
     'labels' => $labels,
     'singular_label' => __('recipes'),
     'public' => true,
     'show_ui' => true, // UI in admin panel
     '_builtin' => false, // It's a custom post type, not built in!
     '_edit_link' => 'post.php?post=%d',
     'capability_type' => 'post',
     'hierarchical' => false,
     'rewrite' => array("slug" => "recipes"), // Permalinks format
     'supports' => array('title','editor','thumbnail','comments')
));

register_taxonomy("recipescat", array("recipes"), array("hierarchical" => true, "label" => "Recipes Category", "singular_label" => "Recipes Category", "rewrite" => true));


/*******************************************************************************************

Registers Team Post Type

********************************************************************************************/
$labels = array(
	'name' => _x('Team', 'post type general name', 'site5framework'),
    'singular_name' => _x('Team', 'post type singular name', 'site5framework'),
    'add_new' => _x('Add New', 'team', 'site5framework'),
    'add_new_item' => __('Add New Team', 'site5framework'),
    'edit_item' => __('Edit Team', 'site5framework'),
    'new_item' => __('New Team', 'site5framework'),
    'view_item' => __('View Team', 'site5framework'),
    'search_items' => __('Search Team', 'site5framework'),
    'not_found' =>  __('No Team found', 'site5framework'),
    'not_found_in_trash' => __('No Team found in Trash', 'site5framework'),
    'parent_item_colon' => ''
  );

register_post_type('team', array(
     'labels' => $labels,
     'singular_label' => __('team'),
     'public' => true,
     'show_ui' => true, // UI in admin panel
     '_builtin' => false, // It's a custom post type, not built in!
     '_edit_link' => 'post.php?post=%d',
     'capability_type' => 'post',
     'hierarchical' => false,
     'rewrite' => array("slug" => "team"), // Permalinks format
     'supports' => array('title','editor','thumbnail')
));


/*******************************************************************************************

Registers Service Post Type

********************************************************************************************/
$labels = array(
	'name' => _x('Service', 'post type general name', 'site5framework'),
    'singular_name' => _x('Service', 'post type singular name', 'site5framework'),
    'add_new' => _x('Add New', 'service', 'site5framework'),
    'add_new_item' => __('Add New Service', 'site5framework'),
    'edit_item' => __('Edit Service', 'site5framework'),
    'new_item' => __('New Service', 'site5framework'),
    'view_item' => __('View Service', 'site5framework'),
    'search_items' => __('Search Service', 'site5framework'),
    'not_found' =>  __('No Service found', 'site5framework'),
    'not_found_in_trash' => __('No Service found in Trash', 'site5framework'),
    'parent_item_colon' => ''
  );

register_post_type('service', array(
     'labels' => $labels,
     'singular_label' => __('service'),
     'public' => true,
     'show_ui' => true, // UI in admin panel
     '_builtin' => false, // It's a custom post type, not built in!
     '_edit_link' => 'post.php?post=%d',
     'capability_type' => 'post',
     'hierarchical' => false,
     'rewrite' => array("slug" => "service"), // Permalinks format
     'supports' => array('title','editor','thumbnail')
));


//  Add Columns to Recipes Edit Screen
function recipes_edit_columns($recipes_columns){
	$recipes_columns = array(
		"cb" 				=> "<input type=\"checkbox\" />",
		"title" 			=> __('Title', 'site5framework'),
		"recipes-tags" 	=> __('Tags', 'site5framework'),
		"author" 			=> __('Author', 'site5framework'),
		"comments" 			=> __('Comments', 'site5framework'),
		"date" 				=> __('Date', 'site5framework'),
	);
	$recipes_columns['comments'] = '<div class="vers"><img alt="Comments" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>';
	return $recipes_columns;
}



// Styling for the custom post type icon
add_action( 'admin_head', 'wpt_portofolio_icons' );

function wpt_portofolio_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-recipes .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/admin/images/recipes-icon.png) no-repeat 6px 6px !important;
        }
		#menu-posts-recipes:hover .wp-menu-image, #menu-posts-recipes.wp-has-current-submenu .wp-menu-image {
            background-position:6px -16px !important;
        }
		#icon-edit.icon32-posts-recipes {background: url(<?php echo get_template_directory_uri(); ?>/admin/images/recipes-32x32.png) no-repeat;}
    </style>

<?php
}

// Styling for the custom post type icon
add_action( 'admin_head', 'wpt_slider_icons' );

function wpt_slider_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-slider .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/admin/images/slider-icon.png) no-repeat 6px 6px !important;
        }
		#menu-posts-slider:hover .wp-menu-image, #menu-posts-slider.wp-has-current-submenu .wp-menu-image {
            background-position:6px -16px !important;
        }
		#icon-edit.icon32-posts-slider {background: url(<?php echo get_template_directory_uri(); ?>/admin/images/slider-32x32.png) no-repeat;}
    </style>
<?php }
?>