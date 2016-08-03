<!DOCTYPE html>
<!--[if lt IE 7]><html class="ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->


<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="format-detection" content="telephone=no">

	<title><?php wp_title('-', true, 'right'); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!-- bootstrap cdn -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	
	<?php if (ot_get_option('favicon')){
		echo '<link rel="shortcut icon" href="'. esc_url(ot_get_option('favicon')) .'" />';
	} 

	if (ot_get_option('ipad_favicon_retina')){
		echo '<link rel="apple-touch-icon" sizes="152x152" href="'. esc_url(ot_get_option('ipad_favicon_retina')) .'" >';
	} 

	if (ot_get_option('iphone_favicon_retina')){
		echo '<link rel="apple-touch-icon" sizes="120x120" href="'. esc_url(ot_get_option('iphone_favicon_retina')) .'" >';
	}

	if (ot_get_option('ipad_favicon')){
		echo '<link rel="apple-touch-icon" sizes="76x76" href="'. esc_url(ot_get_option('ipad_favicon')) .'" >';
	} 

	if (ot_get_option('iphone_favicon')){
		echo '<link rel="apple-touch-icon" href="'. esc_url(ot_get_option('iphone_favicon')) .'" >';
	} ?>
		
	<?php echo ot_get_option('tracking_code'); ?>
	<?php wp_head(); ?>
</head>
	
<body <?php body_class(); ?>>
	<div id="wrapper">
		<?php
			$header_class = '';
			
			// Check if full width header selected
			if ( ot_get_option('layout_style') != 'boxed' && ot_get_option('header_style') == 'full-width' ){ 
				$header_class .= 'full-width';
			}
			
			// Check if overlay header selected
			if ( is_page() && ot_get_option('overlay_header') != 'off' && ( in_array( get_the_ID(), ot_get_option('overlay_header_pages', array()) ) ) ){ 
				$header_class .= ' overlay-header';
			}
		?>
		
		<?php if( ot_get_option('top_bar', 'off') != 'off' ) {
			get_sidebar('top');
		} ?>
		<!--start header -->
		<header class="header-m-wrapper">
			<div class="header-top">
				<div class="container">
					<div style="padding: 20px;text-align: center" class="col-xs-6">
						<img style="margin-top: 7px" src="<?php bloginfo("template_directory");?>/images/logo.350x76.jpg">
					</div>
					<div style="padding: 20px" class="col-xs-6">
						<div style="text-align: center" class="col-lg-12">
							<!--
							<ul class="header-top-menu">
								<li><a href="#">Team</a></li>
								<li><a href="#">F.A.Q.</a></li>
								<li><a href="#">Vacature</a></li>
								<li><a href="#">Contact</a></li>
								<li><a href="#">InLoggen</a></li>
							</ul>
							-->
							<?php
							wp_nav_menu( array(
								'menu' => 'h-top-menu',
								//'depth' => 2,
								'container' => false,
								'menu_class' => 'header-top-menu',
								//Process nav menu using our custom nav walker
								'walker' => new wp_bootstrap_navwalker()) //libs/wp-bootstrap
							);
							?>
						</div>
						<div style="text-align: center" class="col-lg-12">
							<a class="header-top-m-t" style="color:white;font-size: 20px;background-color: #ff5800;border-radius: 5px;padding: 10px 20px;font-family: 'Open Sans';font-weight: 700;display: inline-block" href="#">VRAAG EEN GRATIS PROEFLES AAN</a>
						</div>
					</div>
				</div>
			</div>
			<nav id="header-main-m" class="navbar navbar-default">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<img class="header-main-menu-l" src="<?php bloginfo("template_directory");?>/images/logo.350x76.jpg">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<!--
                        <a class="navbar-brand" href="#">Brand</a>
                        -->
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<!--
						<ul class="nav navbar-nav">
							<li class="active"><a href="#">EMS Training</a></li>
							<li><a href="#">Hoe werkt het</a></li>
							<li><a href="#">Voordelen</a></li>
							<div class="header-second-m" style="display: none">
								<li><a href="#">121212</a></li>
								<li><a href="#">567657</a></li>
							</div>
						</ul>
						-->
						<?php
						wp_nav_menu( array(
							'menu' => 'h-bottom-menu',
							//'depth' => 2,
							'container' => false,
							'menu_class' => 'nav navbar-nav',
							//Process nav menu using our custom nav walker
							'walker' => new wp_bootstrap_navwalker()) //libs/wp-bootstrap
						);
						?>
						<!--sum menu display in small screen -->
						<div class="h-sub-menu">
							<?php
							wp_nav_menu( array(
								'menu' => 'h-top-menu',
								//'depth' => 2,
								'container' => false,
								'menu_class' => 'header-top-menu',
								//Process nav menu using our custom nav walker
								'walker' => new wp_bootstrap_navwalker()) //libs/wp-bootstrap
							);
							?>
							<div>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</header>
		<!--end header -->
		
		<?php get_template_part( 'title' ); // Include title.php ?>
		
		<div id="main" class="clearfix">