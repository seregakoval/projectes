<?php
/* Template Name: front-page*/
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php bloginfo('name'); ?></title>
    <meta name="Description" content="<?php bloginfo('description'); ?>">
    <meta name="viewport" content="user-scalable=no, maximum-scale=1,  width=device-width, initial-scale=1"/>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <!--<link rel="stylesheet" href="<?php bloginfo("template_url"); ?>/style.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <?php wp_head(); ?>
</head>
<body>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '558508374320567',
            xfbml      : true,
            version    : 'v2.6'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div class="header">
    <div class="container">
        <div class="logo">
            <?php if ( function_exists( 'jetpack_the_site_logo' ) ) jetpack_the_site_logo(); ?>
        </div>
            <!--<a href="#" class="logo"><img src="<?php bloginfo("template_directory"); ?>/img/photo_2016-07-11_14-13-22.jpg" alt=""></a>-->
            <button type="button" class="btn toggle-button" data-toggle="collapse" data-target="#demo">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
        <div class="social social-header" style="float:right;margin-left:15px;margin-top:25px;">
            <div class="facebook">
                <a href="#">
                    <i class="fa fa-facebook"></i>
                </a>
            </div>
            <div class="twitter">
                <a href="#">
                    <i class="fa fa-twitter"></i>
                </a>
            </div>
            <div class="inst">
                <a href="https://www.instagram.com/travelafrique/" style="color:#fff;">
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>

            </div>
        </div>
            <nav class="nav collapse" id="demo">
                <?php wp_nav_menu("Primary Menu"); ?>
            </nav>


    </div>
</div>