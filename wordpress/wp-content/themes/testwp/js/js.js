(function() {
    var _addClass, _doc_element, _find, _handleOrientation, _hasClass, _orientation_event, _removeClass, _supports_orientation, _user_agent;

    window.device = {};

    _doc_element = window.document.documentElement;

    _user_agent = window.navigator.userAgent.toLowerCase();

    device.ios = function() {
        return device.iphone() || device.ipod() || device.ipad();
    };

    device.iphone = function() {
        return _find('iphone');
    };

    device.ipod = function() {
        return _find('ipod');
    };

    device.ipad = function() {
        return _find('ipad');
    };

    device.android = function() {
        return _find('android');
    };

    device.androidPhone = function() {
        return device.android() && _find('mobile');
    };

    device.androidTablet = function() {
        return device.android() && !_find('mobile');
    };

    device.blackberry = function() {
        return _find('blackberry') || _find('bb10') || _find('rim');
    };

    device.blackberryPhone = function() {
        return device.blackberry() && !_find('tablet');
    };

    device.blackberryTablet = function() {
        return device.blackberry() && _find('tablet');
    };

    device.windows = function() {
        return _find('windows');
    };

    device.windowsPhone = function() {
        return device.windows() && _find('phone');
    };

    device.windowsTablet = function() {
        return device.windows() && _find('touch');
    };

    device.fxos = function() {
        return _find('(mobile; rv:') || _find('(tablet; rv:');
    };

    device.fxosPhone = function() {
        return device.fxos() && _find('mobile');
    };

    device.fxosTablet = function() {
        return device.fxos() && _find('tablet');
    };

    device.mobile = function() {
        return device.androidPhone() || device.iphone() || device.ipod() || device.windowsPhone() || device.blackberryPhone() || device.fxosPhone();
    };

    device.tablet = function() {
        return device.ipad() || device.androidTablet() || device.blackberryTablet() || device.windowsTablet() || device.fxosTablet();
    };

    device.portrait = function() {
        return Math.abs(window.orientation) !== 90;
    };

    device.landscape = function() {
        return Math.abs(window.orientation) === 90;
    };

    _find = function(needle) {
        return _user_agent.indexOf(needle) !== -1;
    };

    _hasClass = function(class_name) {
        var regex;
        regex = new RegExp(class_name, 'i');
        return _doc_element.className.match(regex);
    };

    _addClass = function(class_name) {
        if (!_hasClass(class_name)) {
            return _doc_element.className += " " + class_name;
        }
    };

    _removeClass = function(class_name) {
        if (_hasClass(class_name)) {
            return _doc_element.className = _doc_element.className.replace(class_name, "");
        }
    };

    if (device.ios()) {
        if (device.ipad()) {
            _addClass("ios ipad tablet");
        } else if (device.iphone()) {
            _addClass("ios iphone mobile");
        } else if (device.ipod()) {
            _addClass("ios ipod mobile");
        }
    } else if (device.android()) {
        if (device.androidTablet()) {
            _addClass("android tablet");
        } else {
            _addClass("android mobile");
        }
    } else if (device.blackberry()) {
        if (device.blackberryTablet()) {
            _addClass("blackberry tablet");
        } else {
            _addClass("blackberry mobile");
        }
    } else if (device.windows()) {
        if (device.windowsTablet()) {
            _addClass("windows tablet");
        } else if (device.windowsPhone()) {
            _addClass("windows mobile");
        } else {
            _addClass("desktop");
        }
    } else if (device.fxos()) {
        if (device.fxosTablet()) {
            _addClass("fxos tablet");
        } else {
            _addClass("fxos mobile");
        }
    } else {
        _addClass("desktop");
    }

    _handleOrientation = function() {
        if (device.landscape()) {
            _removeClass("portrait");
            return _addClass("landscape");
        } else {
            _removeClass("landscape");
            return _addClass("portrait");
        }
    };

    _supports_orientation = "onorientationchange" in window;

    _orientation_event = _supports_orientation ? "orientationchange" : "resize";

    if (window.addEventListener) {
        window.addEventListener(_orientation_event, _handleOrientation, false);
    } else if (window.attachEvent) {
        window.attachEvent(_orientation_event, _handleOrientation);
    } else {
        window[_orientation_event] = _handleOrientation;
    }

    _handleOrientation();

}).call(this);

$(document).ready(function(){
    if($("html").hasClass("ios")){
        $(".br").css({"display":"none"});
    }
       if($('html').hasClass("desktop")){
           $(".block-work .work .content .img").css({"width":"auto","position":"absolute","right":"-107px","bottom":"-60px"});
       }
    if($('html').hasClass("ios") || $('html').hasClass("android")){
       $(".header .wrapper").css({"min-width":"1300px"});
        $(".header").css({"min-width":"1300px"});
        $(".sell").css({"min-width":"1300px"});
        $(".sell .boxes,.info .boxes").css({"width":"1000px","margin":"0 auto"});
        $(".form-block").css({"min-width":"1300px"});
        $(".info").css({"min-width":"1300px"});
        $(".footer").css({"min-width":"1300px"});
        $(".top-f").css({"min-width":"1300px"});
        $(".gallery-block").css({"width":"1300px"});
        $(".center").css({"width":"1000px","margin":"0 auto"});
        $(".form-contact").css({"min-width":"1300px"});


    }
        if($("#menu-menugallery li").hasClass("current_page_item")){
            $("#menu-item-31").addClass("current_page_item");
        }

    jQuery(".right-gallery .box a").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 600,
        'speedOut': 200,
        'type': 'iframe'
        
    });
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL2(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image2').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL3(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image3').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL4(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image4').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInput1").change(function(){
        readURL(this);
    });
    $("#imgInput2").change(function(){
        readURL2(this);
    });
    $("#imgInput3").change(function(){
        readURL3(this);
    });
    $("#imgInput4").change(function(){
        readURL4(this);
    });
    $('.btn').click(function (event) {
        event.preventDefault();
        $('#overlay').fadeIn(200,
            function () {
                $('#modal_form').css('display', 'block').animate({opacity: 1}, 200);
            });
    });
    $('#modal_close, #overlay').click(function () {
        $('#modal_form').animate({opacity: 0}, 200,
            function () {
                $(this).css('display', 'none');
                $('#overlay').fadeOut(200);
            }
        );
    });
    $('.btn2').click(function (event) {
        event.preventDefault();
        $('#overlay').fadeIn(200,
            function () {
                $('#modal_form2').css('display', 'block').animate({opacity: 1}, 200);
            });
    });
    $('#overlay').click(function () {
        $('#modal_form2').animate({opacity: 0}, 200,
            function () {
                $(this).css('display', 'none');
                $('#overlay').fadeOut(200);
            }
        );
    });
    $('#modal_close2, #overlay').click(function () {
        $('#modal_form4-v').animate({opacity: 0}, 200,
            function () {
                $(this).css('display', 'none');
                $('#overlay').fadeOut(200);
            }
        );
    });
    $('.btn-v').click(function (event) {
        event.preventDefault();
        $('#overlay').fadeIn(200,
            function () {
                $('#modal_form4-v').css('display', 'block').animate({opacity: 1}, 200);
            });
    });
    $('.cell-btn').click(function (event) {
        event.preventDefault();
        $('#overlay').fadeIn(200,
            function () {
                $('#modal_form4').css('display', 'block').animate({opacity: 1}, 200);
            });
    });
    $('.footer-modal').click(function (event) {
        event.preventDefault();
        $('#overlay').fadeIn(200,
            function () {
                $('#modal_form4').css('display', 'block').animate({opacity: 1}, 200);
            });
    });
    $('#modal_close2, #overlay').click(function () {
        $('#modal_form4').animate({opacity: 0}, 200,
            function () {
                $(this).css('display', 'none');
                $('#overlay').fadeOut(200);
            }
        );
    });
    $("#modal4").submit(function(){
        var form = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/wp/wordpress/wp-content/themes/testwp/js/send.php',
            data:form,
            success: function(){
                alert("Cпециалист свяжется с вами в ближайшее время");
            }
        });
    });
    $("#modal3").submit(function(){
        var form = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/wp/wordpress/wp-content/themes/testwp/js/send.php',
            data:form,
            success: function(){
                alert("Cпециалист свяжется с вами в ближайшее время");
            }
        });
    });
    $("#ajaxform-modal").submit(function(){
        var form = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/wp/wordpress/wp-content/themes/testwp/js/send.php',
            data:form,
            success: function(){
                alert("Отправлено");
            }
        });
    });
    $("#ajaxform").submit(function(){
        var form = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/wp/wordpress/wp-content/themes/testwp/js/send.php',
            data:form,
            success: function(){
               alert("Отправлено");
            }
        });
    });

});
