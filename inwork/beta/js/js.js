

/*plagin scroll*/
(function(e){e.extend({browserSelector:function(){var e=navigator.userAgent,t=e.toLowerCase(),n=function(e){return t.indexOf(e)>-1},r="gecko",i="webkit",s="safari",o="opera",u=document.documentElement,a=[!/opera|webtv/i.test(t)&&/msie\s(\d)/.test(t)?"ie ie"+parseFloat(navigator.appVersion.split("MSIE")[1]):n("firefox/2")?r+" ff2":n("firefox/3.5")?r+" ff3 ff3_5":n("firefox/3")?r+" ff3":n("gecko/index.html")?r:n("opera")?o+(/version\/(\d+)/.test(t)?" "+o+RegExp.jQuery1:/opera(\s|\/)(\d+)/.test(t)?" "+o+RegExp.jQuery2:""):n("konqueror")?"konqueror":n("chrome")?i+" chrome":n("iron")?i+" iron":n("applewebkit/index.html")?i+" "+s+(/version\/(\d+)/.test(t)?" "+s+RegExp.jQuery1:""):n("mozilla/index.html")?r:"",n("j2me")?"mobile":n("iphone")?"iphone":n("ipod")?"ipod":n("mac")?"mac":n("darwin")?"mac":n("webtv")?"webtv":n("win")?"win":n("freebsd")?"freebsd":n("x11")||n("linux")?"linux":"","js"];c=a.join(" ");u.className+=" "+c}})})(jQuery);(function(e){e.extend({smoothScroll:function(){function c(){var e=false;if(document.URL.indexOf("google.com/reader/view")>-1){e=true}if(t.excluded){var r=t.excluded.split(/[,\n] ?/);r.push("mail.google.com");for(var i=r.length;i--;){if(document.URL.indexOf(r[i])>-1){a&&a.disconnect();N("mousewheel",g);e=true;n=true;break}}}if(e){N("keydown",y)}if(t.keyboardSupport&&!e){T("keydown",y)}}function h(){if(!document.body)return;var e=document.body;var i=document.documentElement;var f=window.innerHeight;var l=e.scrollHeight;o=document.compatMode.indexOf("CSS")>=0?i:e;u=e;c();s=true;if(top!=self){r=true}else if(l>f&&(e.offsetHeight<=f||i.offsetHeight<=f)){var h=false;var p=function(){if(!h&&i.scrollHeight!=document.height){h=true;setTimeout(function(){i.style.height=document.height+"px";h=false},500)}};i.style.height="auto";setTimeout(p,10);var d={attributes:true,childList:true,characterData:false};a=new _(p);a.observe(e,d);if(o.offsetHeight<=f){var v=document.createElement("div");v.style.clear="both";e.appendChild(v)}}if(document.URL.indexOf("mail.google.com")>-1){var m=document.createElement("style");m.innerHTML=".iu { visibility: hidden }";(document.getElementsByTagName("head")[0]||i).appendChild(m)}else if(document.URL.indexOf("www.facebook.com")>-1){var g=document.getElementById("home_stream");g&&(g.style.webkitTransform="translateZ(0)")}if(!t.fixedBackground&&!n){e.style.backgroundAttachment="scroll";i.style.backgroundAttachment="scroll"}}function m(e,n,r,i){i||(i=1e3);k(n,r);if(t.accelerationMax!=1){var s=+(new Date);var o=s-v;if(o<t.accelerationDelta){var u=(1+30/o)/2;if(u>1){u=Math.min(u,t.accelerationMax);n*=u;r*=u}}v=+(new Date)}p.push({x:n,y:r,lastX:n<0?.99:-.99,lastY:r<0?.99:-.99,start:+(new Date)});if(d){return}var a=e===document.body;var f=function(s){var o=+(new Date);var u=0;var l=0;for(var c=0;c<p.length;c++){var h=p[c];var v=o-h.start;var m=v>=t.animationTime;var g=m?1:v/t.animationTime;if(t.pulseAlgorithm){g=P(g)}var y=h.x*g-h.lastX>>0;var b=h.y*g-h.lastY>>0;u+=y;l+=b;h.lastX+=y;h.lastY+=b;if(m){p.splice(c,1);c--}}if(a){window.scrollBy(u,l)}else{if(u)e.scrollLeft+=u;if(l)e.scrollTop+=l}if(!n&&!r){p=[]}if(p.length){M(f,e,i/t.frameRate+1)}else{d=false}};M(f,e,0);d=true}function g(e){if(!s){h()}var n=e.target;var r=x(n);if(!r||e.defaultPrevented||C(u,"embed")||C(n,"embed")&&/\.pdf/i.test(n.src)){return true}var i=e.wheelDeltaX||0;var o=e.wheelDeltaY||0;if(!i&&!o){o=e.wheelDelta||0}if(!t.touchpadSupport&&A(o)){return true}if(Math.abs(i)>1.2){i*=t.stepSize/120}if(Math.abs(o)>1.2){o*=t.stepSize/120}m(r,-i,-o);e.preventDefault()}function y(e){var n=e.target;var r=e.ctrlKey||e.altKey||e.metaKey||e.shiftKey&&e.keyCode!==l.spacebar;if(/input|textarea|select|embed/i.test(n.nodeName)||n.isContentEditable||e.defaultPrevented||r){return true}if(C(n,"button")&&e.keyCode===l.spacebar){return true}var i,s=0,o=0;var a=x(u);var f=a.clientHeight;if(a==document.body){f=window.innerHeight}switch(e.keyCode){case l.up:o=-t.arrowScroll;break;case l.down:o=t.arrowScroll;break;case l.spacebar:i=e.shiftKey?1:-1;o=-i*f*.9;break;case l.pageup:o=-f*.9;break;case l.pagedown:o=f*.9;break;case l.home:o=-a.scrollTop;break;case l.end:var c=a.scrollHeight-a.scrollTop-f;o=c>0?c+10:0;break;case l.left:s=-t.arrowScroll;break;case l.right:s=t.arrowScroll;break;default:return true}m(a,s,o);e.preventDefault()}function b(e){u=e.target}function S(e,t){for(var n=e.length;n--;)w[E(e[n])]=t;return t}function x(e){var t=[];var n=o.scrollHeight;do{var i=w[E(e)];if(i){return S(t,i)}t.push(e);if(n===e.scrollHeight){if(!r||o.clientHeight+10<n){return S(t,document.body)}}else if(e.clientHeight+10<e.scrollHeight){overflow=getComputedStyle(e,"").getPropertyValue("overflow-y");if(overflow==="scroll"||overflow==="auto"){return S(t,e)}}}while(e=e.parentNode)}function T(e,t,n){window.addEventListener(e,t,n||false)}function N(e,t,n){window.removeEventListener(e,t,n||false)}function C(e,t){return(e.nodeName||"").toLowerCase()===t.toLowerCase()}function k(e,t){e=e>0?1:-1;t=t>0?1:-1;if(i.x!==e||i.y!==t){i.x=e;i.y=t;p=[];v=0}}function A(e){if(!e)return;e=Math.abs(e);f.push(e);f.shift();clearTimeout(L);var t=f[0]==f[1]&&f[1]==f[2];var n=O(f[0],120)&&O(f[1],120)&&O(f[2],120);return!(t||n)}function O(e,t){return Math.floor(e/t)==e/t}function D(e){var n,r,i;e=e*t.pulseScale;if(e<1){n=e-(1-Math.exp(-e))}else{r=Math.exp(-1);e-=1;i=1-Math.exp(-e);n=r+i*(1-r)}return n*t.pulseNormalize}function P(e){if(e>=1)return 1;if(e<=0)return 0;if(t.pulseNormalize==1){t.pulseNormalize/=D(1)}return D(e)}var e={frameRate:150,animationTime:700,stepSize:80,pulseAlgorithm:true,pulseScale:8,pulseNormalize:1,accelerationDelta:20,accelerationMax:1,keyboardSupport:true,arrowScroll:50,touchpadSupport:true,fixedBackground:true,excluded:""};var t=e;var n=false;var r=false;var i={x:0,y:0};var s=false;var o=document.documentElement;var u;var a;var f=[120,120,120];var l={left:37,up:38,right:39,down:40,spacebar:32,pageup:33,pagedown:34,end:35,home:36};var p=[];var d=false;var v=+(new Date);var w={};setInterval(function(){w={}},10*1e3);var E=function(){var e=0;return function(t){return t.uniqueID||(t.uniqueID=e++)}}();var L;var M=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||function(e,t,n){window.setTimeout(e,n||1e3/60)}}();var _=window.MutationObserver||window.WebKitMutationObserver;T("mousedown",b);T("mousewheel",g);T("load",h)}})})(jQuery)
/* and plagin scroll*/
new WOW().init();
try {
    $.browserSelector();
    if($("html").hasClass("chrome")) {
        $.smoothScroll();
    }
} catch(err) {

}
// ------------- VARIABLES ------------- //

jQuery(document).ready(function($){
    //set animation timing
    var animationDelay = 2500,
        //loading bar effect
        barAnimationDelay = 3800,
        barWaiting = barAnimationDelay - 3000, //3000 is the duration of the transition on the loading bar - set in the scss/css file
        //letters effect
        lettersDelay = 50,
        //type effect
        typeLettersDelay = 150,
        selectionDuration = 500,
        typeAnimationDelay = selectionDuration + 800,
        //clip effect 
        revealDuration = 600,
        revealAnimationDelay = 1500;
    
    initHeadline();
    

    function initHeadline() {
        //insert <i> element for each letter of a changing word
        singleLetters($('.cd-headline.letters').find('b'));
        //initialise headline animation
        animateHeadline($('.cd-headline'));
    }

    function singleLetters($words) {
        $words.each(function(){
            var word = $(this),
                letters = word.text().split(''),
                selected = word.hasClass('is-visible');
            for (i in letters) {
                if(word.parents('.rotate-2').length > 0) letters[i] = '<em>' + letters[i] + '</em>';
                letters[i] = (selected) ? '<i class="in">' + letters[i] + '</i>': '<i>' + letters[i] + '</i>';
            }
            var newLetters = letters.join('');
            word.html(newLetters).css('opacity', 1);
        });
    }

    function animateHeadline($headlines) {
        var duration = animationDelay;
        $headlines.each(function(){
            var headline = $(this);
            
            if(headline.hasClass('loading-bar')) {
                duration = barAnimationDelay;
                setTimeout(function(){ headline.find('.cd-words-wrapper').addClass('is-loading') }, barWaiting);
            } else if (headline.hasClass('clip')){
                var spanWrapper = headline.find('.cd-words-wrapper'),
                    newWidth = spanWrapper.width() + 10
                spanWrapper.css('width', newWidth);
            } else if (!headline.hasClass('type') ) {
                //assign to .cd-words-wrapper the width of its longest word
                var words = headline.find('.cd-words-wrapper b'),
                    width = 0;
                words.each(function(){
                    var wordWidth = $(this).width();
                    if (wordWidth > width) width = wordWidth;
                });
                headline.find('.cd-words-wrapper').css('width', width);
            };

            //trigger animation
            setTimeout(function(){ hideWord( headline.find('.is-visible').eq(0) ) }, duration);
        });
    }

    function hideWord($word) {
        var nextWord = takeNext($word);
        
        if($word.parents('.cd-headline').hasClass('type')) {
            var parentSpan = $word.parent('.cd-words-wrapper');
            parentSpan.addClass('selected').removeClass('waiting'); 
            setTimeout(function(){ 
                parentSpan.removeClass('selected'); 
                $word.removeClass('is-visible').addClass('is-hidden').children('i').removeClass('in').addClass('out');
            }, selectionDuration);
            setTimeout(function(){ showWord(nextWord, typeLettersDelay) }, typeAnimationDelay);
        
        } else if($word.parents('.cd-headline').hasClass('letters')) {
            var bool = ($word.children('i').length >= nextWord.children('i').length) ? true : false;
            hideLetter($word.find('i').eq(0), $word, bool, lettersDelay);
            showLetter(nextWord.find('i').eq(0), nextWord, bool, lettersDelay);

        }  else if($word.parents('.cd-headline').hasClass('clip')) {
            $word.parents('.cd-words-wrapper').animate({ width : '2px' }, revealDuration, function(){
                switchWord($word, nextWord);
                showWord(nextWord);
            });

        } else if ($word.parents('.cd-headline').hasClass('loading-bar')){
            $word.parents('.cd-words-wrapper').removeClass('is-loading');
            switchWord($word, nextWord);
            setTimeout(function(){ hideWord(nextWord) }, barAnimationDelay);
            setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('is-loading') }, barWaiting);

        } else {
            switchWord($word, nextWord);
            setTimeout(function(){ hideWord(nextWord) }, animationDelay);
        }
    }

    function showWord($word, $duration) {
        if($word.parents('.cd-headline').hasClass('type')) {
            showLetter($word.find('i').eq(0), $word, false, $duration);
            $word.addClass('is-visible').removeClass('is-hidden');

        }  else if($word.parents('.cd-headline').hasClass('clip')) {
            $word.parents('.cd-words-wrapper').animate({ 'width' : $word.width() + 10 }, revealDuration, function(){ 
                setTimeout(function(){ hideWord($word) }, revealAnimationDelay); 
            });
        }
    }

    function hideLetter($letter, $word, $bool, $duration) {
        $letter.removeClass('in').addClass('out');
        
        if(!$letter.is(':last-child')) {
            setTimeout(function(){ hideLetter($letter.next(), $word, $bool, $duration); }, $duration);  
        } else if($bool) { 
            setTimeout(function(){ hideWord(takeNext($word)) }, animationDelay);
        }

        if($letter.is(':last-child') && $('html').hasClass('no-csstransitions')) {
            var nextWord = takeNext($word);
            switchWord($word, nextWord);
        } 
    }

    function showLetter($letter, $word, $bool, $duration) {
        $letter.addClass('in').removeClass('out');
        
        if(!$letter.is(':last-child')) { 
            setTimeout(function(){ showLetter($letter.next(), $word, $bool, $duration); }, $duration); 
        } else { 
            if($word.parents('.cd-headline').hasClass('type')) { setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('waiting'); }, 200);}
            if(!$bool) { setTimeout(function(){ hideWord($word) }, animationDelay) }
        }
    }

    function takeNext($word) {
        return (!$word.is(':last-child')) ? $word.next() : $word.parent().children().eq(0);
    }

    function takePrev($word) {
        return (!$word.is(':first-child')) ? $word.prev() : $word.parent().children().last();
    }

    function switchWord($oldWord, $newWord) {
        $oldWord.removeClass('is-visible').addClass('is-hidden');
        $newWord.removeClass('is-hidden').addClass('is-visible');
    }
});

/*    ANIMATION-TEXT   */
var index = 0;
var captionLength = 0;
var captionOptions = ["Portfolio Developer :)", "Portfolio Developer :)", "Portfolio Developer :)","Protfolio Developer :)","Portfolio Developer :)"]

// this will make the cursor blink at 400ms per cycle
function cursorAnimation() {
    $('#cursor').animate({
        opacity: 0
    }, 400).animate({
        opacity: 1
    }, 400);
}
// this types the caption
function type() {
    $caption.html(caption.substr(0, captionLength++));
    if(captionLength < caption.length+1) {
        setTimeout('type()', 70);
    }
}
// this erases the caption
function erase() {
    $caption.html(caption.substr(0, captionLength--));
    if(captionLength >= 0) {
        setTimeout('erase()', 50);
    }
}
// this instigates the cycle of typing the captions
function showCaptions() {
    caption = captionOptions[index];
    type();
    if (index < (captionOptions.length - 1)) {
        index++
        setTimeout('erase()', 4000);
        setTimeout('showCaptions()', 6000)
    } else {
        setTimeout(function(){
            $('#cursor').remove()
        }, 1500)
    }
}
function resizeWindow() {
    var widthResize = $(this).width();
    if(widthResize <= 991) {
        $(".pt-wrapper section").removeClass("background");

    }
}
$(window).resize(function() {
    resizeWindow();
});
$(document).ready(function(){
    resizeWindow();
    // use setInterval so that it will repeat itself
    setInterval('cursorAnimation()', 600);
    $caption = $('#caption');

    // use setTimeout so that it only gets called once
    setTimeout('showCaptions()', 1000);
});

/*---AND ANIMATION TEXT---*/

/*validate_name*/
errorName = false;
errorMail = false;
function checkname(name){
    var name_filter = $("#first_name2").val();
    var filter =  /[a-zA-Zа-яА-Я]+/;
    if(filter.test(name_filter)){
        $("#first_name2").css("border-bottom","2px solid #6BC3E9");
        errorName = true;
    }else{
        $("#first_name2").css("border-bottom","2px solid #EE3B24").effect("bounce", { direction:'down', times:3 }, 300);
        errorName = false;
    }
}
function validateEmail(){
    var name_filter = $("#first_name3").val();
    var email_filter = /\S+@[a-z]+.[a-z]+/;
    if(email_filter.test(name_filter)){
        $("#first_name3").css("border-bottom","2px solid #6BC3E9");
        errorMail = true;
    } else{
        $("#first_name3").css("border-bottom","2px solid #EE3B24").effect("bounce", { direction:'down', times:3 }, 300);
        errorMail = false;
    }
}
$(document).ready(function(){

    $('.close-carbon-adv').on('click', function(event){
        event.preventDefault();
        $('#carbonads-container').hide();
    });
    if($(".input-field input").val() != ""){
        $(".lab1").css({"top":"-17px","font-size":"12px"});
    }
    if($("#first_name3").val() != ""){
        $(".lab2").css({"top":"-17px","font-size":"12px"});
    }
    $(".input-field input").focus(function(){
        $(this).siblings().css({"top":"-17px","font-size":"12px"});
    }).blur(function(){
        /* */
        var val_n = $(this).val();
        if(val_n != ""){
        }else{
            $(this).siblings().css({"top":"0px","font-size":"14px"});
        }
    });
    $("#ajax-form").submit(function(){
        var name_filter = $("#first_name2").val();
        var filter =  /[a-zA-Zа-яА-Я]+/;
        if(filter.test(name_filter)){
            $("#first_name2").css("border-bottom","2px solid #6BC3E9");
            errorName = true;
        }else{
            $("#first_name2").css("border-bottom","2px solid #EE3B24").effect("bounce", { direction:'down', times:3 }, 300);
            errorName = false;
        }
        var name_filter = $("#first_name3").val();
        var email_filter = /\S+@[a-z]+.[a-z]+/;
        if(email_filter.test(name_filter)){
            $("#first_name3").css("border-bottom","2px solid #6BC3E9");
            errorMail = true;
        }else{
            $("#first_name3").css("border-bottom","2px solid #EE3B24").effect("bounce", { direction:'down', times:3 }, 300);
            errorMail = false;
        }
        if(errorName == true && errorMail == true){
            var form = $(this).serialize();
            $(".contact .form-contact .sub").animate({width:"138px"},300);
            $(".loader-inner").css("display","block").delay(200).animate({opacity:"1"},300);
            $.ajax({
                type: 'POST',
                url: 'mail.php',
                data:form,
                success: function(){
                    function hide_loader(){
                        $(".submit,.sub").css("background","#29ABA4").attr("value","SUCCEED");
                        $(".loader-inner").animate({opacity:"1"},200,function(){
                            $(this).css("display","none");
                        });
                        $(".check_mark").animate({opacity: "1"},200,function(){
                            $(this).css("display","block");
                        });
                    }
                    setTimeout(hide_loader,1000);
                    function reset_form(){
                        $('#ajax-form textarea, input[type="text"]').val('');
                    }
                    setTimeout(reset_form,1800);
                },
                complete:function(){
                    function hide_check(){
                        $(".loader-inner").animate({opacity:"0"},200,function(){
                            $(this).css("display","none");
                        });
                        $(".submit,.sub").css("background","#3A9AD9").attr("value","SEND");
                        $(".check_mark").css("display","none").animate({opacity: "0"},200);
                        $(".contact .form-contact .sub").animate({width:"100px"},300);
                    }
                    setTimeout(hide_check,2100);
                }
            });
        }else{
            console.log("ошибка");
        }
        return false;
    });

    /*$('#particles').particleground({
     dotColor: 'rgba(24,159,208,0.5)',
     lineColor: 'rgba(24,159,208,0.5)'
     });*/

    /*Toggle Menu*/
    var nav;
    var btnMenu = document.querySelector("#open-button");
    btnMenu.addEventListener('click', function() {
    this.classList.toggle("active");
    nav = document.querySelector('.header__nav-container');
        nav.classList.toggle('active');
    });
    var nav = document.querySelectorAll(".header__nav-container");
    for(i=0; i < nav.length; i++) {
        function clickNav () {
            nav.classList.remove("active");
        }
        nav[i].addEventListener('click', clickNav);
    }
    $(".scale-img .main").on("click",function(){
        document.querySelector(".main").parentNode.parentNode.classList.toggle('active');
        if(document.querySelector(".scale-img")
                .classList.contains("active")) {
                document.querySelector(".scale-img .hide-block")
                .classList.add("active");
        } else {
            document.querySelector(".scale-img .hide-block")
                .classList.remove("active");
        }

    });
    $('#home').parallax("0%", 0.1);
    $('.section-bg').parallax("0%", 0.1);
    $(".pt-trigger").on("click", function() {
        $('html, body').animate({scrollTop: 0}, 0);
        // $(".pt-page").each(function() {
        //     if($(this).hasClass("pt-page-current")) {
        //         $(".header").animate({top: "15px"},200);
        //         $("body").addClass("activePage");
        //         // $(".background, .background.scroll, .parallax-mirror").css({"display":"none"});
        //         // var ElementBody = $("body");
        //         // ElementBody.addClass("hidden-body");
        //         var homeButton = $(".pt-trigger").first();
        //         homeButton.on("click", function() {
        //             $("body").removeClass("activePage");
        //             // $(".background, .background.scroll, .parallax-mirror").css({"display":"block"});
        //         });
        //     }
        // });
        var numberPage = this.getAttribute('data-goto');
        if(numberPage == 2) {
            $(".pt-page-2 .portfolio__box").removeClass("fadeOutLeft");
            $(".pt-page-2 .portfolio__box").removeClass("bounceInUp");
            $(".pt-page-2 .portfolio__box").each(function(index, el) {
                    new Waypoint({
                        element: el,
                        handler: function() {
                            var element = $(this.element),
                                delay = element.attr('data-delay');

                            setTimeout(function() {
                                element.addClass('bounceInUp');
                            }, delay);
                            this.destroy();
                        },
                        offset: '65%'
                    });
                });
        } else {
            $(".pt-page-2 .portfolio__box").addClass("fadeOutLeft");
            console.log("not pt-page-2");
        }
        // if($('.pt-page-2').hasClass('pt-page-current')) {
        //     $(".pt-page-2 .portfolio__box").removeClass("fadeOutRight");
        //     // $(".pt-page-2 .portfolio__box").removeClass("bounceInUp");
        //     console.log("pt-page-2");
        //     // $(".pt-page-2 .portfolio__box").addClass("bounceInUp");
        // } else {
        //     console.log("not pt-page-2");
        //     $(".pt-page-2 .portfolio__box").addClass("fadeOutRight");
        // }
        // $(".pt-page-2 .portfolio__box").each(function(index, el) {
        //     new Waypoint({
        //         element: el,
        //         handler: function() {
        //             var element = $(this.element),
        //                 delay = element.attr('data-delay');
        //
        //             setTimeout(function() {
        //                 element.addClass('bounceInUp');
        //             }, delay);
        //             this.destroy();
        //         },
        //         offset: '70%'
        //     });
        // });
    });
    var widthWindow = $(window).width();
    if(widthWindow <= 991) {
        $(".servises-animation").removeClass("animated");
    }
    $(".header").waypoint(function(direction){
        if (direction === 'down') {
            $(this.element).css({"transform":"translateX(0)"});
        }
        else {
           $(this.element).css({"transform":"translateX(-100%)"});
        }
        // $(".container-about")
    },{
        offset: "70%"
    });
    $(".header").waypoint(function(direction){
        if (direction === 'down') {
            $(this.element).css({"position":"fixed",});
        }
        else {
            $(this.element).css({"position":"absolute"})  
        }
        // $(".container-about")
    },{
        offset: "10%"
    });
    $(".main-block .servises .item").each(function(index, el) {
        new Waypoint({
            element: el,
            handler: function() {
                var element = $(this.element),
                    delay = element.attr('data-delay');
                setTimeout(function() {
                    element.addClass('fadeInUp');
                }, delay);
                this.destroy();
            },
            offset: '750px'
        });
    });
    $(".main-block .portfolio__box").waypoint(function(direction){
        if (direction === 'down') {
            $(".parallax-mirror:eq(1)").removeClass("active");
            var element = $(this.element);
            var delay = element.attr("data-delay");
            setTimeout(function(){
                element.removeClass("fadeOut");
                element.addClass("fadeInUp");
            },delay);
        }
        else {
            $(".parallax-mirror:eq(1)").addClass("active");
            $(this.element).removeClass("fadeInUp");
            $(this.element).addClass("fadeOut");
        }
        // $(".container-about")
    },{
        offset: "80%"
    });
    $(".space .space-row").waypoint(function(direction){
        if (direction === 'down') {
            $(".parallax-mirror:eq(1)").removeClass("active");
            var element = $(this.element);
            var delay = element.attr("data-delay");
            setTimeout(function(){
                element.removeClass("fadeOut");
                element.addClass("slideInRight");
            },delay);
        }
        else {
            $(this.element).removeClass("slideInRight");
            $(this.element).addClass("fadeOut");
        }
        // $(".container-about")
    },{
        offset: 800
    });
    $(".container-about").waypoint(function(direction){
        if (direction === 'down') {
            $(this.element).removeClass("fadeOutRight");
            $(this.element).addClass("slideInRight");
        }
        else {
            $(this.element).removeClass("slideInRight");
            $(this.element).addClass("fadeOutRight");
        }
        // $(".container-about")
    },{
        offset: 700
    });

});
$(document).on('opened', '.remodal', function () {

    setTimeout(show_loader, 200);
    function show_loader() {

        setTimeout(add_class_losder, 200);
    }
    function add_class_losder(){
        $(".svg-loading").addClass("bounceIn");
    }
    setTimeout(koval,300);
    function koval(){
        $('.dialog-iframe').attr('src', 'portfolio/dentist/index.html');
        $(".dialog-iframe").load(function(){
            setTimeout(showLoad,2000);
            function showLoad(){
                $(".svg-loading").addClass("bounceOut");
            }
            setTimeout(showframe,2700);
            function showframe(){
                $(".svg-loader").addClass("bounceOutLeft");
                $('.dialog-iframe').fadeIn();
            }
        });
    }
});

$(window).scroll(function(){
    // var heigthBlock = $(this).scrollTop();
    // if( heigthBlock > 1800) {
    //     var st = $(this).scrollTop();
    //       $(".about-us").css({
    //           "background-position-y":st/10 + "%"
    //       });
    //   // var st = $(this).scrollTop();
    //   //   $(".title-contact").css({
    //   //       "transform":"translate( 0%,-" + st/7 + "%"
    //   //   });
    // }
});
