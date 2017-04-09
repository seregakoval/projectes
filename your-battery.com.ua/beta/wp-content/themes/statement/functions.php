<?php
/*

 It's not recommended to add functions to this file, as it will be lost if you ever update this child theme.
 Instead, consider adding your function into a plugin using Pluginception: https://wordpress.org/plugins/pluginception/
 
 */

add_action( 'admin_notices', 'statement_reset_customizer_settings' );
function statement_reset_customizer_settings() {
	global $pagenow;
	$generate_settings = get_option('generate_settings');
	
	if ( empty($generate_settings) )
		return;
		
	if ( is_admin() && $pagenow == "themes.php" && isset( $_GET['activated'] ) ) {
		?>
		<div class="updated settings-error notice is-dismissible">
			<p>
				<?php printf( __( '<strong>Almost done!</strong> Previous GeneratePress options detected in your database. Please <a href="%s">click here</a> to delete your current options for Statement to take full effect.','statement' ), admin_url('themes.php?page=generate-options#gen-delete') ); ?>
			</p>
		</div>
		<?php
	}
}

if ( !function_exists( 'statement_defaults' ) ) :
add_filter( 'generate_option_defaults','statement_defaults' );
function statement_defaults( $statement_defaults )
{
	$statement_defaults[ 'hide_title' ] = '';
	$statement_defaults[ 'hide_tagline' ] = '';
	$statement_defaults[ 'logo' ] = '';
	$statement_defaults[ 'container_width' ] = '1300';
	$statement_defaults[ 'header_layout_setting' ] = 'fluid-header';
	$statement_defaults[ 'center_header' ] = 'true';
	$statement_defaults[ 'center_nav' ] = 'true';
	$statement_defaults[ 'nav_alignment_setting' ] = 'center';
	$statement_defaults[ 'header_alignment_setting' ] = 'center';
	$statement_defaults[ 'nav_layout_setting' ] = 'fluid-nav';
	$statement_defaults[ 'nav_position_setting' ] = 'nav-below-header';
	$statement_defaults[ 'nav_search' ] = 'enable';
	$statement_defaults[ 'nav_dropdown_type' ] = 'hover';
	$statement_defaults[ 'content_layout_setting' ] = 'separate-containers';
	$statement_defaults[ 'layout_setting' ] = 'right-sidebar';
	$statement_defaults[ 'blog_layout_setting' ] = 'right-sidebar';
	$statement_defaults[ 'single_layout_setting' ] = 'right-sidebar';
	$statement_defaults[ 'post_content' ] = 'full';
	$statement_defaults[ 'footer_layout_setting' ] = 'fluid-footer';
	$statement_defaults[ 'footer_widget_setting' ] = '4';
	$statement_defaults[ 'back_to_top' ] = '';
	$statement_defaults[ 'background_color' ] = '#fafafa';
	$statement_defaults[ 'text_color' ] = '#3a3a3a';
	$statement_defaults[ 'link_color' ] = '#1da5bd';
	$statement_defaults[ 'link_color_hover' ] = '#000000';
	$statement_defaults[ 'link_color_visited' ] = '';
	
	return $statement_defaults;
}
endif;

/**
 * Set default options
 */
if ( !function_exists( 'statement_get_color_defaults' ) ) :
add_filter( 'generate_color_option_defaults','statement_get_color_defaults' );
function statement_get_color_defaults( $statement_color_defaults )
{
	$statement_color_defaults[ 'header_background_color' ] = '#1da5bd';
	$statement_color_defaults[ 'header_text_color' ] = '#ffffff';
	$statement_color_defaults[ 'header_link_color' ] = '#ffffff';
	$statement_color_defaults[ 'header_link_hover_color' ] = '#222222';
	$statement_color_defaults[ 'site_title_color' ] = '#ffffff';
	$statement_color_defaults[ 'site_tagline_color' ] = '#ffffff';
	$statement_color_defaults[ 'navigation_background_color' ] = '#ffffff';
	$statement_color_defaults[ 'navigation_text_color' ] = '#222222';
	$statement_color_defaults[ 'navigation_background_hover_color' ] = '#ffffff';
	$statement_color_defaults[ 'navigation_text_hover_color' ] = '#1da5bd';
	$statement_color_defaults[ 'navigation_background_current_color' ] = '#ffffff';
	$statement_color_defaults[ 'navigation_text_current_color' ] = '#1da5bd';
	$statement_color_defaults[ 'subnavigation_background_color' ] = '#1da5bd';
	$statement_color_defaults[ 'subnavigation_text_color' ] = '#ffffff';
	$statement_color_defaults[ 'subnavigation_background_hover_color' ] = '#1da5bd';
	$statement_color_defaults[ 'subnavigation_text_hover_color' ] = '#222222';
	$statement_color_defaults[ 'subnavigation_background_current_color' ] = '#1da5bd';
	$statement_color_defaults[ 'subnavigation_text_current_color' ] = '#222222';
	$statement_color_defaults[ 'content_background_color' ] = '#FFFFFF';
	$statement_color_defaults[ 'content_text_color' ] = '#3a3a3a';
	$statement_color_defaults[ 'content_link_color' ] = '';
	$statement_color_defaults[ 'content_link_hover_color' ] = '';
	$statement_color_defaults[ 'content_title_color' ] = '';
	$statement_color_defaults[ 'blog_post_title_color' ] = '#222222';
	$statement_color_defaults[ 'blog_post_title_hover_color' ] = '#1da5bd';
	$statement_color_defaults[ 'entry_meta_text_color' ] = '#888888';
	$statement_color_defaults[ 'entry_meta_link_color' ] = '#666666';
	$statement_color_defaults[ 'entry_meta_link_color_hover' ] = '#1da5bd';
	$statement_color_defaults[ 'h1_color' ] = '';
	$statement_color_defaults[ 'h2_color' ] = '';
	$statement_color_defaults[ 'h3_color' ] = '';
	$statement_color_defaults[ 'sidebar_widget_background_color' ] = '#FFFFFF';
	$statement_color_defaults[ 'sidebar_widget_text_color' ] = '#3a3a3a';
	$statement_color_defaults[ 'sidebar_widget_link_color' ] = '';
	$statement_color_defaults[ 'sidebar_widget_link_hover_color' ] = '';
	$statement_color_defaults[ 'sidebar_widget_title_color' ] = '#000000';
	$statement_color_defaults[ 'footer_widget_background_color' ] = '#1da5bd';
	$statement_color_defaults[ 'footer_widget_text_color' ] = '#ffffff';
	$statement_color_defaults[ 'footer_widget_link_color' ] = '#ffffff';
	$statement_color_defaults[ 'footer_widget_link_hover_color' ] = '#222222';
	$statement_color_defaults[ 'footer_widget_title_color' ] = '#ffffff';
	$statement_color_defaults[ 'footer_background_color' ] = '#ffffff';
	$statement_color_defaults[ 'footer_text_color' ] = '#222222';
	$statement_color_defaults[ 'footer_link_color' ] = '#1da5bd';
	$statement_color_defaults[ 'footer_link_hover_color' ] = '#222222';
	$statement_color_defaults[ 'form_background_color' ] = '#FAFAFA';
	$statement_color_defaults[ 'form_text_color' ] = '#666666';
	$statement_color_defaults[ 'form_background_color_focus' ] = '#FFFFFF';
	$statement_color_defaults[ 'form_text_color_focus' ] = '#666666';
	$statement_color_defaults[ 'form_border_color' ] = '#CCCCCC';
	$statement_color_defaults[ 'form_border_color_focus' ] = '#BFBFBF';
	$statement_color_defaults[ 'form_button_background_color' ] = '#1da5bd';
	$statement_color_defaults[ 'form_button_background_color_hover' ] = '#847f67';
	$statement_color_defaults[ 'form_button_text_color' ] = '#FFFFFF';
	$statement_color_defaults[ 'form_button_text_color_hover' ] = '#FFFFFF';
	
	return $statement_color_defaults;
}
endif;

/**
 * Set default options
 */
if ( !function_exists('statement_get_default_fonts') ) :
add_filter( 'generate_font_option_defaults','statement_get_default_fonts' );
function statement_get_default_fonts( $statement_font_defaults )
{
	$statement_font_defaults[ 'font_body' ] = 'Open Sans';
	$statement_font_defaults[ 'font_body_category' ] = 'sans-serif';
	$statement_font_defaults[ 'font_body_variants' ] = '300,300italic,regular,italic,600,600italic,700,700italic,800,800italic';
	$statement_font_defaults[ 'body_font_weight' ] = 'normal';
	$statement_font_defaults[ 'body_font_transform' ] = 'none';
	$statement_font_defaults[ 'body_font_size' ] = '17';
	$statement_font_defaults[ 'font_site_title' ] = 'inherit';
	$statement_font_defaults[ 'site_title_font_weight' ] = 'bold';
	$statement_font_defaults[ 'site_title_font_transform' ] = 'none';
	$statement_font_defaults[ 'site_title_font_size' ] = '55';
	$statement_font_defaults[ 'mobile_site_title_font_size' ] = '30';
	$statement_font_defaults[ 'font_site_tagline' ] = 'inherit';
	$statement_font_defaults[ 'site_tagline_font_weight' ] = '300';
	$statement_font_defaults[ 'site_tagline_font_transform' ] = 'none';
	$statement_font_defaults[ 'site_tagline_font_size' ] = '20';
	$statement_font_defaults[ 'font_navigation' ] = 'inherit';
	$statement_font_defaults[ 'navigation_font_weight' ] = 'bold';
	$statement_font_defaults[ 'navigation_font_transform' ] = 'none';
	$statement_font_defaults[ 'navigation_font_size' ] = '15';
	$statement_font_defaults[ 'font_widget_title' ] = 'inherit';
	$statement_font_defaults[ 'widget_title_font_weight' ] = 'bold';
	$statement_font_defaults[ 'widget_title_font_transform' ] = 'none';
	$statement_font_defaults[ 'widget_title_font_size' ] = '23';
	$statement_font_defaults[ 'widget_content_font_size' ] = '17';
	$statement_font_defaults[ 'font_heading_1' ] = 'inherit';
	$statement_font_defaults[ 'heading_1_weight' ] = 'bold';
	$statement_font_defaults[ 'heading_1_transform' ] = 'none';
	$statement_font_defaults[ 'heading_1_font_size' ] = '40';
	$statement_font_defaults[ 'mobile_heading_1_font_size' ] = '30';
	$statement_font_defaults[ 'font_heading_2' ] = 'inherit';
	$statement_font_defaults[ 'heading_2_weight' ] = 'bold';
	$statement_font_defaults[ 'heading_2_transform' ] = 'none';
	$statement_font_defaults[ 'heading_2_font_size' ] = '30';
	$statement_font_defaults[ 'mobile_heading_2_font_size' ] = '25';
	$statement_font_defaults[ 'font_heading_3' ] = 'inherit';
	$statement_font_defaults[ 'heading_3_weight' ] = 'bold';
	$statement_font_defaults[ 'heading_3_transform' ] = 'none';
	$statement_font_defaults[ 'heading_3_font_size' ] = '20';
	$statement_font_defaults[ 'font_heading_4' ] = 'inherit';
	$statement_font_defaults[ 'heading_4_weight' ] = 'normal';
	$statement_font_defaults[ 'heading_4_transform' ] = 'none';
	$statement_font_defaults[ 'heading_4_font_size' ] = '15';
	$statement_font_defaults[ 'footer_font_size' ] = '17';
	
	return $statement_font_defaults;
}
endif;

/**
 * Set default options
 */
if ( !function_exists( 'statement_get_spacing_defaults' ) ) :
add_filter( 'generate_spacing_option_defaults','statement_get_spacing_defaults' );
function statement_get_spacing_defaults( $statement_spacing_defaults )
{
	$statement_spacing_defaults[ 'header_top' ] = '60';
	$statement_spacing_defaults[ 'header_right' ] = '60';
	$statement_spacing_defaults[ 'header_bottom' ] = '60';
	$statement_spacing_defaults[ 'header_left' ] = '60';
	$statement_spacing_defaults[ 'menu_item' ] = '20';
	$statement_spacing_defaults[ 'menu_item_height' ] = '70';
	$statement_spacing_defaults[ 'sub_menu_item_height' ] = '10';
	$statement_spacing_defaults[ 'content_top' ] = '50';
	$statement_spacing_defaults[ 'content_right' ] = '50';
	$statement_spacing_defaults[ 'content_bottom' ] = '50';
	$statement_spacing_defaults[ 'content_left' ] = '50';
	$statement_spacing_defaults[ 'separator' ] = '40';
	$statement_spacing_defaults[ 'left_sidebar_width' ] = '25';
	$statement_spacing_defaults[ 'right_sidebar_width' ] = '25';
	$statement_spacing_defaults[ 'widget_top' ] = '50';
	$statement_spacing_defaults[ 'widget_right' ] = '50';
	$statement_spacing_defaults[ 'widget_bottom' ] = '50';
	$statement_spacing_defaults[ 'widget_left' ] = '50';
	$statement_spacing_defaults[ 'footer_widget_container_top' ] = '50';
	$statement_spacing_defaults[ 'footer_widget_container_right' ] = '0';
	$statement_spacing_defaults[ 'footer_widget_container_bottom' ] = '50';
	$statement_spacing_defaults[ 'footer_widget_container_left' ] = '0';
	$statement_spacing_defaults[ 'footer_top' ] = '20';
	$statement_spacing_defaults[ 'footer_right' ] = '0';
	$statement_spacing_defaults[ 'footer_bottom' ] = '20';
	$statement_spacing_defaults[ 'footer_left' ] = '0';
	
	return $statement_spacing_defaults;
}
endif;