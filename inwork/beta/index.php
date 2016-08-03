<?php

include 'simple_html_dom.php';

/*
$ch = curl_init ("https://www.weblancer.net/users/seregakoval96/reviews/");
$fp = fopen ("people.html", "w");
curl_setopt ($ch, CURLOPT_FILE, $fp);
curl_setopt ($ch, CURLOPT_HEADER, 0);
curl_exec ($ch);
curl_close ($ch);
fclose ($fp);
$arr = array();
$zp_weather = file_get_html('people.html');
foreach($zp_weather->find('.user_brief') as $e) {
    $arr[] = $e->innertext;
}
foreach($zp_weather->find('.username') as $b){
    $arr[] = $b->innertext;
}
*/

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Sergey Koval - Front-end Developer</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sergey Koval - Верстка, натяжка Wordpress" />
    <meta name="keywords" content="html,Koval Sergey Front-end Developer, " />
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,300,400,500,700' rel='stylesheet' type='text/css'>
    <!--<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,600&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>-->

</head>
<body>
<!--<iframe style="width:1000px;height: 600px;overflow:hidden; " src="https://www.weblancer.net/users/seregakoval96/reviews/" frameborder="0"></iframe>-->
<div class="wrap-container">
    <div class="menu-wrap">
        <nav class="menu">
            <div class="title-menu clearfix">
                <div class="avatar-menu ">
                    <img src="img/IMG_20140917_223455.jpg" alt="">
                </div>
                <h1 class="name">Sergey Koval</h1>
            </div>
            <div class="icon-list">
                <li>
                    <a href="http://koval.urich.org/portfolio/">
                             <span class="icon">
                                <i aria-hidden="true" class="icon-home"></i>
                             </span>
                        <span>home</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="btn1 historyAPI">
                             <span class="icon">
                                <i aria-hidden="true" class="icon-portfolio"></i>
                             </span>
                        <span>Portfolio</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="btn2 historyAPI">
                             <span class="icon">
                                <i aria-hidden="true" class="icon-home"></i>
                            </span>
                        <span>About</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                             <span class="icon">
                            <i aria-hidden="true" class="icon-contact"></i>
                            </span>
                        <span>Contact</span>
                    </a>
                </li>
            </div>
        </nav>
    </div>
    <div class="content-wrap">
        <header class="header">
            <div class="left-bg"></div>
            <div class="container header-b clearfix">
                <div class="logo-b">
                    <div class="avatar clearfix">
                        <a href="#">
                            <div class="sniper"></div>
                            <img src="img/IMG_20140917_223455.jpg" alt="">
                        </a>
                    </div>
                    <div class="logo-text">
                        <p class="name">Sergey Koval</p>
                        <p class="position">Web Developer</p>
                    </div>
                </div>
                <!--<button class="menu-button cmn-toggle-switch cmn-toggle-switch__htx" id="open-button">
                    <span>toggle menu</span>
                </button>-->
                <button class="menu-button" id="open-button">

                </button>
                <div class="nav-container">

                    <div style="clear: both;"></div>
                    <nav class="menu clearfix">
                        <ul>
                            <li>
                                <a href="http://koval.urich.org/portfolio/">
                             <span class="icon">
                                <i aria-hidden="true" class="icon-home"></i>
                             </span>
                                    <span>home</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn1 historyAPI">
                             <span class="icon">
                                <i aria-hidden="true" class="icon-portfolio"></i>
                             </span>
                                    <span>Portfolio</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn2 historyAPI">
                             <span class="icon">
                                <i aria-hidden="true" class="icon-home"></i>
                            </span>
                                    <span>About</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                             <span class="icon">
                            <i aria-hidden="true" class="icon-contact"></i>
                            </span>
                                    <span>Contact</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </header>
        <section  class="parallax clearfix" data-parallax="scroll" >
            <div class="title-head">
                <h2 class="animated wow fadeInDown"  data-wow-delay="1.8s">Portfolio Developer</h2>
            </div>
            <div class="swiper-slide dark">
                <div class="slider-caption slider-caption-center">
                    <div id="particles" class="slider-caption" style="height: 400px;width:100%;overflow: hidden;"></div>
                    <div class="container">
                        <div class="mobile-slider">
                            <div class="html5">
                                <p class="text-html animated wow" data-wow-delay="1.8s">html5</p>
                                <p class="text-css animated wow" data-wow-delay="2s">css3</p>
                                <img src="img/slide_img1.png" class="slide-img1 animated wow" data-wow-delay="0.4s"  alt="">
                                <img src="img/slide_img2.png" class="slide-img2 animated wow" data-wow-delay="0.4s" alt="">
                                <img src="img/slide_img3.png" class="slide-img3 animated wow" data-wow-delay="1.3s" alt="">
                                <img src="img/slide_img4.png" class="slide-img4 animated wow" data-wow-delay="1.3s" alt="">
                                <img src="img/slide_img5.png" class="slide-img5 animated wow" data-wow-delay="0.8s" alt="">
                                <img src="img/slide_img6.png" class="slide-img6 animated wow" data-wow-delay="0.8s" alt="">
                            </div>
                            <img src="img/plus.png" class="plus-img animated wow fadeInDown" data-wow-delay="2.5s" alt="">
                            <div class="js">
                                <img src="img/js-left.png" class="left-js animated wow" data-wow-delay="1.8s" alt="">
                                <img src="img/js-right.png" class="right-js animated wow" data-wow-delay="1.8s" alt="">
                                <img src="img/js-right-b.png" class="right-js-b animated wow" data-wow-delay="2.1s" alt="">
                                <img src="img/js.png" class="js-b animated wow" data-wow-delay="2.4s" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="line_bg"></div>
        <div class="servises">
            <div class="container services2">
                <div class="col-md-2 col-sm-4 col-xs-6 service-content">
                    <div class="box animated wow fadeInDown" data-wow-offset="200">
                        <div class="icon-surround-1 new-lh"><i class="icon-embed2"></i></div>
                        <div class="services-popup">
                            <h4>Чистота и Семантичность</h4>
                            <p>Аккуратный, логичный, продуманный код</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 service-content">
                   <div class="box animated wow fadeInDown" data-wow-delay="0.4s" data-wow-offset="200">
                       <div class="icon-surround-1 new-lh"><i class="icon-mobile"></i></div>
                       <div class="services-popup">
                           <h4>Адаптивная верстка</h4>
                           <p>Адаптивная верстка под планшеты и мобильные устройства</p>
                       </div>
                   </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 service-content">
                    <div class="box animated wow fadeInDown" data-wow-delay="0.6s" data-wow-offset="200">
                        <div class="icon-surround-1 new-lh"><i class="icon-html-five"></i></div>
                        <div class="services-popup">
                            <h4>HTML5, CSS3, jQuery</h4>
                            <p>Использование новых технологий верстки</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 service-content">
                    <div class="box animated wow fadeInDown" data-wow-delay="0.8s" data-wow-offset="200" >
                        <div class="icon-surround-1 new-lh"><i class="icon-hammer"></i></div>
                        <div class="services-popup">
                            <h4>Исправления верстки</h4>
                            <p>Правки верстки на существующих сайтах любой сложности</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-6 service-content">
                    <div class="box animated wow fadeInDown" data-wow-delay="1s" data-wow-offset="200">
                        <div class="icon-surround-1 new-lh"><i class="icon-cogs"></i></div>
                        <div class="services-popup">
                            <h4>Установка на CMS WordPress</h4>
                            <p>Установка готового html кода на систему управления сайтов WordPress</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 service-content">
                    <div class="box animated wow fadeInDown" data-wow-delay="1.2s" data-wow-offset="200">
                        <div class="icon-surround-1 new-lh"><i class="icon-checkmark"></i></div>
                        <div class="services-popup">
                            <h4>Качество</h4>
                            <p>Код будет выполнен качественно и точно в срок!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="portfolio clearfix">
            <div class="title">
                <div class="icon">
                    <span class="icon-pentagon wow bounceIn animated" data-wow-offset="100"><i class="fa fa-suitcase"></i></span>
                </div>
                <div style="clear: both;"></div>
                <h1 class="animated wow bounceIn"  data-wow-offset="400">My Project</h1>
            </div>
            <div class="grid clearfix">
                <div class="box col-lg-4 col-sm-6 col-xs-6 animated wow fadeInUp" data-wow-offset="300">
                    <div class="scale-img">
                        <div class="top">
                            <h3>Safari</h3>
                            <ul class="navigation">
                                <a class="main" href="#url">All pages project:</a>
                                <li class="n1"><a href="#">item #1</a></li>
                                <li class="n2"><a href="#">item #2</a></li>
                                <li class="n3"><a href="#">item #3</a></li>
                                <li class="n4"><a href="#">item #4</a></li>
                                <li class="n5"><a href="#">item #5</a></li>
                            </ul>
                        </div>
                        <div class="img-n">
                            <img src="img/111.jpg" alt="">
                        </div>
                        <div class="bottom">
                            <h3>Safari</h3>
                            <a href="http://dribbble.com/shots/1116775-Safari">Demo</a>
                        </div>
                    </div>
                    <!--<figure>

                        <img src="http://tympanus.net/Tutorials/CaptionHoverEffects/images/4.png" alt="img03">
                        <figcaption>
                            <h3>Settings</h3>
                            <span>Jacob Cummings</span>
                            <a href="http://dribbble.com/shots/1116685-Settings">Take a look</a>
                        </figcaption>
                    </figure>-->
                </div>
                <div class="box col-lg-4 col-sm-6 col-xs-6 animated wow fadeInUp" data-wow-offset="300" data-wow-delay="0.2s" >
                    <div class="scale-img">
                        <div class="top">
                            <h3>Safari</h3>
                        </div>
                        <div class="img-n">
                            <img src="img/screencapture2.jpg" alt="">
                        </div>
                        <div class="bottom">
                            <h3>Safari</h3>
                            <a href="http://dribbble.com/shots/1116775-Safari">Demo</a>
                        </div>
                    </div>
                </div>
                <div class="box col-lg-4 col-sm-6 col-xs-6 animated wow fadeInUp" data-wow-offset="300" data-wow-delay="0.4s" >
                    <div class="scale-img">
                        <div class="top">
                            <h3>Safari</h3>
                        </div>
                        <div class="img-n">
                            <img src="img/screencapture3.jpg" alt="">
                        </div>
                        <div class="bottom">
                            <h3>Safari</h3>
                            <a href="http://dribbble.com/shots/1116775-Safari">Demo</a>
                        </div>
                    </div>
                </div>
                <div class="box col-lg-4 col-sm-6 col-xs-6 animated wow fadeInUp" data-wow-offset="300">
                    <div class="scale-img">
                        <div class="top">
                            <h3>Safari</h3>
                        </div>
                        <div class="img-n">
                            <img src="img/screencapture5.jpg" alt="">
                        </div>
                        <div class="bottom">
                            <h3>Safari</h3>
                            <a href="http://dribbble.com/shots/1116775-Safari">Demo</a>
                        </div>
                    </div>
                </div>
                <div class="box col-lg-4 col-sm-6 col-xs-6  animated wow fadeInUp" data-wow-offset="300" data-wow-delay="0.2s">
                    <figure>
                        <img src="http://tympanus.net/Tutorials/CaptionHoverEffects/images/4.png" alt="img04">
                        <figcaption>
                            <h3>Safari</h3>
                            <span>Jacob Cummings</span>
                            <a href="http://dribbble.com/shots/1116775-Safari">Take a look</a>
                        </figcaption>
                    </figure>
                </div>
                <div class="box col-lg-4 col-sm-6 col-xs-6  animated wow fadeInUp" data-wow-offset="300" data-wow-delay="0.4s">
                    <figure>
                        <img src="http://tympanus.net/Tutorials/CaptionHoverEffects/images/4.png" alt="img04">
                        <figcaption>
                            <h3>Safari</h3>
                            <span>Jacob Cummings</span>
                            <a href="http://dribbble.com/shots/1116775-Safari">Take a look</a>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>
        <div class="line_bg_2"></div>
        <section class="start_work clearfix">
            <div class="container">
                <div class="row">
                    <div class="left animated wow fadeInLeft" data-wow-offset="300" data-wow-delay="0.4s">
                        <h2>LIKE OUR WORKS?</h2>
                        <p class="sub-text">We are always open to interesting projects.</p>
                    </div>
                    <button class="button button--nuka button--round-s button--text-thick">Get In Touch</button>
                </div>
            </div>
        </section>
        <div class="line_bg_2"></div>
        <div class="title-about-us clearfix">
            <div class="icon"><span class="icon-pentagon wow bounceIn animated"><i class="fa fa-meh-o"></i></span></div>
            <div style="clear: both;"></div>
            <h1 class="animated wow bounceIn"  data-wow-offset="300">About Us</h1>
        </div>
        <div class="section-bg" data-parallax="scroll">
            <section class="about-us clearfix parallax2">
                <div class="container-b clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-6" style="position:relative;min-height: 327px;">
                        <div class="block-img-responsive">
                            <img src="img/flat-iphone.png" alt="Image 5" class="img4">
                            <img src="http://flathe.wpelement.com/wp-content/uploads/flat-ipad.png" alt="Image 3" class="img3">
                            <img src="http://flathe.wpelement.com/wp-content/uploads/flat-laptop.png" alt="Image 2" class="img2">
                            <img src="http://flathe.wpelement.com/wp-content/uploads/flat-pc.png" alt="Image 1" class="img1" >
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="space">
                            <h3>EXPERTISE</h3>

                            <h5>HTML / CSS3</h5>
                            <div class="progress progress-striped active" style="background-color: rgba(242,142,146,0.3);">
                                <div class="progress-bar progress-bar-danger" style="width: 90%"></div>
                            </div>

                            <h5>Javascript</h5>
                            <div class="progress progress-striped active" style="background-color: rgba(199,231,200,0.5);">
                                <div class="progress-bar progress-bar-success" style="width: 85%"></div>
                            </div>

                            <h5>PHP</h5>
                            <div class="progress progress-striped active" style="background-color: rgba(255,224,179,0.5);">
                                <div class="progress-bar progress-bar-warning" style="width: 80%"></div>
                            </div>

                            <h5>Angular JS</h5>
                            <div class="progress progress-striped active" style="background-color: rgba(202,230,252,0.5);">
                                <div class="progress-bar progress-bar-default" style="width: 70%"></div>
                            </div>
                            <h5>MySQL / NoSQL</h5>
                            <div class="progress progress-striped active" style="background-color: rgba(199,231,200,0.5);">
                                <div class="progress-bar progress-bar-success" style="width: 75%"></div>
                            </div>

                            <h5>.NET</h5>
                            <div class="progress progress-striped active" style="background-color: rgba(242,142,146,0.3);">
                                <div class="progress-bar progress-bar-danger" style="width: 90%"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </section>

            <div style="clear: both;"></div>
            <div class="title-contact clearfix">
                <div class="container" style="position: relative;">
                    <div class="icon">
                        <span class="icon-pentagon wow bounceIn animated" style="visibility: visible;"><i class="fa fa-pencil"></i></span>
                    </div>
                    <div style="clear: both;"></div>
                    <h1>Cntact Us</h1>
                    <div class="icon-gif"></div>
                </div>
            </div>
            <section class="contact right_bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="min-height: 400px;">
                            <div class="block_canvas" style="z-index:500;">
                                <canvas id="canvas"></canvas>
                            </div>
                            <div class="about-info">
                                <div class="head clearfix">
                                    <h2>Contact Details</h2>
                                </div>
                                <p><span>Full Name:</span> Koval Sergey</p>
                                <p><span> Birthday:</span> 21 January 1985</p>
                                <p><span>Job:</span> Frelancer</p>
                                <p><span>Website:</span> koval.urich.org</p>
                                <p><span>Email:</span> kovalsergeyy09@mail.ru</p>
                                <p><span>Skype:</span> serega_093</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="min-height: 400px;">
                            <div class="head-mail">
                                <p>Send us Message</p>
                    <span>
                        <i class="fa fa-angle-down fa-2x"></i>
                    </span>
                            </div>
                            <form action="#" class="form-contact" id="ajax-form">
                                <div class="input-field">
                                    <input  id="first_name2"  name="name"  type="text" class="validate">
                                    <label for="first_name2" class="lab1">Name</label>
                                </div>
                                <div class="input-field">
                                    <input  id="first_name3" name="email" type="text" class="validate">
                                    <label for="first_name3" class="lab2">Email</label>
                                </div>
                                <div class="input-field clearfix">
                                    <p>Message</p>
                                    <textarea name="message" id="keybord" cols="30" rows="10"></textarea>
                                </div>
                                <div class="sub">
                                    <input type="submit" class="submit" value="SEND">
                                    <div class="loader-inner ball-clip-rotate-multiple"><div></div><div></div></div>
                                    <i class="check_mark"></i>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="over"></div>
<div id="loading">
    <div id="loader"></div>
</div>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/menu_sideslide.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/device.min.js"></script>
<script src="js/classie.js"></script>
<script src="js/wow.min.js"></script>
<script>
    new WOW().init();
    try {
        $.browserSelector();
        if($("html").hasClass("chrome")) {
            $.smoothScroll();
        }
    } catch(err) {

    };
   /* if($("html").hasClass("")){
        var script = document.createElement("script");
        script.src = "js/keybord.js";
        document.body .appendChild(script);
    }*/
    if($(window).width() <= 640){
       /* $(".parallax").attr("data-image-src","img/image-bg-mobile.jpg");
        $(".section-bg").attr("data-image-src","img/s3-mobile.jpg");*/
        $(".parallax").css({"background":"url('img/image-bg-mobile.jpg') no-repeat","background-size":"cover"});

    }else{


    }
</script>
<script>
    $(window).load(function() {
        function loadFile(){

            $('#loading-center-absolute,#loading').css({"display":"none"});
            add_class();
        }
        setTimeout(loadFile,1000);
        function add_class(){
            $(".text-html").addClass( "bounceInDown" );
            $(".text-css").addClass( "bounceInDown" );
            $(".slide-img1").addClass( "fadeInLeft" );
            $(".slide-img2").addClass( "fadeInRight" );
            $(".slide-img3").addClass( "fadeInLeft" );
            $(".slide-img4").addClass( "fadeInRight" );
            $(".slide-img5").addClass( "fadeInLeft" );
            $(".slide-img6").addClass( "fadeInRight" )
            $(".left-js").addClass( "fadeInLeft" );
            $(".right-js").addClass( "fadeInRight" );
            $(".right-js-b").addClass( "fadeInDown" );
            $(".js-b").addClass( "fadeInUp" );
        }
    });
</script>
<script src="js/jquery.particleground.min.js"></script>
<script>
    if($(window).width() >= 640){
        $(".parallax").attr("data-image-src","img/image-bg.jpg");
        $(".section-bg").attr("data-image-src","img/s3.jpg");
        document.write('<script type="text/javascript" src="js/parallax.min.js"><\x2fscript>');
    }
</script>
<!--<script src="js/parallax.min.js"></script>-->
<script src="js/plugins-scroll.js"></script>
<script src="js/js.js"></script>
