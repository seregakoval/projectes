
/*! device.js 0.1.57 */
(function(){var a,b,c,d,e,f,g,h,i;window.device={},b=window.document.documentElement,i=window.navigator.userAgent.toLowerCase(),device.ios=function(){return device.iphone()||device.ipod()||device.ipad()},device.iphone=function(){return c("iphone")},device.ipod=function(){return c("ipod")},device.ipad=function(){return c("ipad")},device.android=function(){return c("android")},device.androidPhone=function(){return device.android()&&c("mobile")},device.androidTablet=function(){return device.android()&&!c("mobile")},device.blackberry=function(){return c("blackberry")||c("bb10")||c("rim")},device.blackberryPhone=function(){return device.blackberry()&&!c("tablet")},device.blackberryTablet=function(){return device.blackberry()&&c("tablet")},device.windows=function(){return c("windows")},device.windowsPhone=function(){return device.windows()&&c("phone")},device.windowsTablet=function(){return device.windows()&&c("touch")},device.fxos=function(){return c("(mobile; rv:")||c("(tablet; rv:")},device.fxosPhone=function(){return device.fxos()&&c("mobile")},device.fxosTablet=function(){return device.fxos()&&c("tablet")},device.mobile=function(){return device.androidPhone()||device.iphone()||device.ipod()||device.windowsPhone()||device.blackberryPhone()||device.fxosPhone()},device.tablet=function(){return device.ipad()||device.androidTablet()||device.blackberryTablet()||device.windowsTablet()||device.fxosTablet()},device.portrait=function(){return 90!==Math.abs(window.orientation)},device.landscape=function(){return 90===Math.abs(window.orientation)},c=function(a){return-1!==i.indexOf(a)},e=function(a){var c;return c=new RegExp(a,"i"),b.className.match(c)},a=function(a){return e(a)?void 0:b.className+=" "+a},g=function(a){return e(a)?b.className=b.className.replace(a,""):void 0},device.ios()?device.ipad()?a("ios ipad tablet"):device.iphone()?a("ios iphone mobile"):device.ipod()&&a("ios ipod mobile"):device.android()?device.androidTablet()?a("android tablet"):a("android mobile"):device.blackberry()?device.blackberryTablet()?a("blackberry tablet"):a("blackberry mobile"):device.windows()?device.windowsTablet()?a("windows tablet"):device.windowsPhone()?a("windows mobile"):a("desktop"):device.fxos()?device.fxosTablet()?a("fxos tablet"):a("fxos mobile"):a("desktop"),d=function(){return device.landscape()?(g("portrait"),a("landscape")):(g("landscape"),a("portrait"))},h="onorientationchange"in window,f=h?"orientationchange":"resize",window.addEventListener?window.addEventListener(f,d,!1):window.attachEvent?window.attachEvent(f,d):window[f]=d,d()}).call(this);



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
    }else{
        $("#first_name3").css("border-bottom","2px solid #EE3B24").effect("bounce", { direction:'down', times:3 }, 300);
        errorMail = false;
    }
}

$(document).ready(function(){

    (function() {

        var bodyEl = document.body,
            content = document.querySelector( '.content-wrap' ),
            openbtn = document.getElementById( 'open-button' ),
            closebtn = document.getElementById( 'close-button' ),
            isOpen = false;

        function init() {
            initEvents();
        }

        function initEvents() {
            openbtn.addEventListener( 'click', toggleMenu );
            if( closebtn ) {
                closebtn.addEventListener( 'click', toggleMenu );
            }

            // close the menu element if the target it´s not the menu element or one of its descendants..
            content.addEventListener( 'click', function(ev) {
                var target = ev.target;
                if( isOpen && target !== openbtn ) {
                    toggleMenu();
                }
            } );
        }

        function toggleMenu() {
            if( isOpen ) {
                classie.remove( bodyEl, 'show-menu' );
            }
            else {
                classie.add( bodyEl, 'show-menu' );
            }
            isOpen = !isOpen;
        }

        init();

    })();

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
    $(window).on('scroll', function(){
        if( $(window).scrollTop()>100 ){
            $('.header').addClass('animated fadeInDown').css({"box-shadow":"0 0 1px 2px rgba(0,0,0,0.25)","border-top":"4px solid #EE3B24","background":"#fff",'position':"fixed"});
            $('.left-bg').css({"display":"block"});
            $(".header-b").addClass('header-fix');
            $(".menu-button span").css({"background":"#EE4A34"});
            $(".nav-container ul li a i").css({'color':"#333"});
        }
        else {
            $('.header').removeClass('animated fadeInDown').css({"box-shadow":"none","background":"transparent",'position':"absolute","border-top":"none"});
            $(".header-b").removeClass('header-fix');
            $('.left-bg').css({"display":"none"});
            $(".menu-button span").css({"background":"#fff"});
            $(".nav-container ul li a i").css({'color':"#fff"});
        }
    });

});

