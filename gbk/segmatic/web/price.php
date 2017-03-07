<!DOCTYPE html>
<html lang="en">
<head>
    <title>Price</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!--<link href="path/to/font" />-->
    <!-- COMPONENTS -->
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- STYLES -->
    <link href="./node_modules/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="lib/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="lib/css/ion.rangeSlider.skinFlat.css">
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
<header class="header">
    <div class="container">
        <div class="header__logo">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.html" class="header__log">
                <img src="img/logo.jpg" alt="">
            </a>
        </div> <!--./header__logo-->
        <div class="header__block-nav collapse navbar-collapse" id="navigation">
            <nav class="header__nav">
                <ul class="list-left">
                    <li><a href="#">Platform  </a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
                <ul class="list-right">
                    <li><a href="#">Segmatic</a></li>
                    <li><a href="#">Free AdWords Audit</a></li>
                </ul>
            </nav> <!--./nav-->
            <form action="#" class="header__search">
                <input type="text" placeholder="search">
                <i class="fa fa-search" aria-hidden="true"></i>
            </form> <!--./form-->
        </div> <!--./header__block-nav-->
    </div>
</header> <!--.header-->
<section class="menu">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12">
                <ul class="menu__navigation">
                    <li><a href="#">Overview</a></li>
                    <li><a href="#">Features</a></li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">Clients & Results </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Example</a></li>
                            <li><a href="#">Example sub menu</a></li>
                            <li><a href="#">Example II</a></li>
                        </ul>
                    </li>
                    <li><a href="#" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false">Pricing </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Example</a></li>
                            <li><a href="#">Example sub menu</a></li>
                            <li><a href="#">Example II</a></li>
                        </ul>
                    </li>
                    <li><a href="#" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"> About</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Example</a></li>
                            <li><a href="#">Example sub menu</a></li>
                            <li><a href="#">Example II</a></li>
                        </ul>
                    </li>
                </ul> <!--./navigation-->
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="menu__start">
                    <p>Start my <span>Free 30 days</span>trial</p>
                </div>
            </div>
        </div>
    </div>
</section> <!--./menu-->
<section class="Pricing-Slider">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="Pricing-Slider__title">Why should you use Segmatic?</h1>
                <p class="Pricing-Slider__sub-title"> CPA Targets test</p>
                <div class="block-slider">
                    <div class="block-slider__text-left">
                        <p>0k Target</p>
                    </div>
                    <div class="block-slider__string">
                        <div id="slider"></div>
                    </div>
                    <div class="block-slider__text-right">
                        <p>10k Target</p>
                    </div>

                </div>
                <div class="tarif">
                    <div class="tarif-row tarif-header">
                        <div class="tarif-col"></div>
                        <div class="tarif-col hover-col-1">
                            <p class="tarif__title">Managed Service</p>
                            <p class="tarif__price" data-currency="managed-service">$0</p>
                        </div>
                        <div class="tarif-col hover-col-2">
                            <p class="tarif__title">Self-Serve</p>
                            <p class="tarif__price" data-currency="self-serve">$0</p>
                        </div>
                    </div>
                    <div class="tarif-row">
                        <div class="tarif-col left">
                            <p class="tarif__item-text bold">Strategy</p>
                        </div>
                        <div class="tarif-col hover-col-1">
                            <p class="tarif__item-text">Strategy - Segmatic Consultants</p>
                        </div>
                        <div class="tarif-col hover-col-2">
                            <p class="tarif__item-text">Strategy - In-House</p>
                        </div>
                    </div>
                    <div class="tarif-row">
                        <div class="tarif-col left">
                            <p class="tarif__item-text bold">Implementation</p>
                        </div>
                        <div class="tarif-col hover-col-1">
                            <p class="tarif__item-text">Implementation - Segmatic Platform</p>
                        </div>
                        <div class="tarif-col hover-col-2">
                            <p class="tarif__item-text">Implementation - Segmatic Platform</p>
                        </div>
                    </div>
                    <div class="tarif-row">
                        <div class="tarif-col left">
                            <p class="tarif__item-text bold"> Risk & Reward</p>
                        </div>
                        <div class="tarif-col hover-col-1">
                            <p class="tarif__item-text">Risk & Reward - Shared</p>
                        </div>
                        <div class="tarif-col hover-col-2">
                            <p class="tarif__item-text">Risk & Reward - Shared</p>
                        </div>
                    </div>
                    <div class="tarif-row">
                        <div class="tarif-col left">
                            <p class="tarif__item-text bold"> Details</p>
                        </div>
                        <div class="tarif-col button hover-col-1">
                            <div class="tarif__text-block">
                            <p class="tarif__item-text">11% of Non Brand Media Spend <br>Only billing if CPA Targets are achieved<br>Minimum €10,000 per month media spend <br>Full details below</p>
                        </div>
                            <a href="#" class="item-btn">sign up</a>
                        </div>
                        <div class="tarif-col button hover-col-2">
                            <div class="tarif__text-block">
                                <p class="tarif__item-text">4% of Media Spend <br>30 Day Free Trial</p>
                            </div>
                            <a href="#" class="item-btn">sign up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--./pricing-->
<section class="Pricing-Grid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="plan">
                    <div class="plan__col">
                        <div class="hide-block">Plan Selected</div>
                        <div class="plan__head">
                            <p class="plan__title">Agencies</p>
                        </div> <!--./head-->
                        <div class="plan__content">
                            <p class="plan__content-text">Automation of all mundane <br> adwords-related tasks, so you
                                <br> can focus on strategy</p>
                        </div>  <!--./content-text-->
                        <div class="plan__content-cols  button">
                            <div class="plan__content">
                                <p class="plan__content-text">Tools to aggregate small gains that add up to big wins</p>
                            </div> <!--./content-text-->
                            <div class="plan__content">
                                <p class="plan__content-text">Tools that let you get the last 5% of optimisations that an agency wouldn't bother with.</p>

                            </div> <!--./content-text-->
                        </div>
                        <a href="#" class="item-btn">sign up</a>
                    </div>
                    <div class="plan__col">
                        <div class="hide-block">Plan Selected</div>
                        <div class="plan__head">
                            <p class="plan__title">SMEs</p>
                        </div> <!--./head-->
                        <div class="plan__content">
                            <p class="plan__content-text">Automation of all mundane <br> adwords-related tasks, so you
                                <br> can focus on strategy</p>
                        </div>  <!--./content-text-->
                        <div class="plan__content-cols  button">
                            <div class="plan__content">
                                <p class="plan__content-text">Best Practice - Access to Best Practice strategies previously restricted to agencies</p>
                            </div> <!--./content-text-->
                        </div>
                        <a href="#" class="item-btn">sign up</a>
                    </div> <!--plan__col-->
                    <div class="plan__col">
                        <div class="hide-block">Plan Selected</div>
                        <div class="plan__head">
                            <p class="plan__title">Agencies</p>
                        </div> <!--./head-->
                        <div class="plan__content">
                            <p class="plan__content-text">Automation of all mundane <br> adwords-related tasks, so you
                                <br> can focus on strategy</p>
                        </div>  <!--./content-text-->
                        <div class="plan__content-cols  button">
                            <div class="plan__content">
                                <p class="plan__content-text">Tools to aggregate small gains that add up to big wins</p>
                            </div> <!--./content-text-->
                            <div class="plan__content">
                                <p class="plan__content-text">Tools that let you get the last 5% of optimisations that an agency wouldn't bother with.</p>
                            </div> <!--./content-text-->
                        </div>
                        <a href="#" class="item-btn">sign up</a>
                    </div> <!--plan__col-->
                </div> <!--./plan-->
            </div>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer__nav">
                <ul>
                    <li><a href="#">Terms & Conditions </a></li>
                    <li><a href="#">Privacy Statement</a></li>
                    <li><a href="#">How we use cookies</a></li>
                    <li><a href="#">Contact Us </a></li>
                    <li><a href="#"> Careers</a></li>
                    <li><a href="#">Testimonial Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- COMPONENTS SCRIPTS -->
<script type="text/javascript" src="vendor/jquery/dist/jquery.min.js"></script>
<script src="lib/js/third-graph.js"></script>
<script src="lib/js/amcharts.js"></script>
<script type="text/javascript" src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="lib/js/ion.rangeSlider.js"></script>

<script>
    $(document).ready(function(){
        $(".block-slider__string").append('<div class="test">'+ '</div>');
        var $range = $("#slider");

        function test(data) {
            var value = data.from,
                col1 = "$" + Math.round((value / 100) * 11),
                col2 = "$" + Math.round((value / 100) * 4),
                step = Math.round(data.from_percent / 10);
            $("[data-currency='managed-service']").text(col1);
            $("[data-currency='self-serve']").text(col2);
            return step;
        }
        $range.ionRangeSlider({
            min: 0,
            max: 150000,
            from: 0,
            to: 150000,
            prefix: "$",
            postfix: '<span id="bottomFix"></span>',
            onChange: function(data) {
                var step = test(data);
                var div = $('<div />').addClass('test-target').text(step + 'k Target');
                $(".irs-single").append(div);
                console.log('change')
            },
            onFinish: function(data) {
                var step = test(data);
                $(".test-target").empty();
                var div = $('<div />').addClass('test-target').text(step + 'k Target');
                $(".irs-single").append(div);
//                var div = $('<div />').addClass('test-target').text(step + 'k Target');
//                $(".irs-single").append(div);
            }
        });
        var hovercol1 = $(".hover-col-1");
        var hovercol2 = $(".hover-col-2");
        var hover_text1 = $(".hover-col-1:first p");
        var hover_text2 = $(".hover-col-2:first p");
        hovercol1.hover(function(){
            hovercol1.css({"background":"#fff"});
            hovercol1.first().css({"background":"#49acef"});
            hover_text1.css({"color":"#fff"});
        },function(){
            hovercol1.css({"background":"#e7f1f8"});
            hovercol1.first().css({"background":"#dee9f1"});
            hover_text1.css({"color":"#545d63"});
        });
        hovercol2.hover(function(){
            hovercol2.css({"background":"#fff"});
            hovercol2.first().css({"background":"#49acef"});
            hover_text2.css({"color":"#fff"});
        },function(){
            hovercol2.css({"background":"#e7f1f8"});
            hovercol2.first().css({"background":"#dee9f1"});
            hover_text2.css({"color":"#545d63"});
        });
    });
</script>
</body>
</html>
