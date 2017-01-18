$('.block-loader').fadeIn();
$(window).load(function() {
    $(function() {
        $(window).on("scroll resize", function() {
            var o = $(window).scrollTop() / ($(document).height() - $(window).height());
            $(".progress-bar").css({
                "width": (100 * o | 0) + "%"
            });
            $('.progress-scroll')[0].value = o;
        })
    });
    function hideOverlay() {
        $('#loading').addClass("slideUpBlock");
    }
    function hideLoader() {
        $('.block-loader').fadeOut();
        setTimeout(hideOverlay, 400);
    }
    function loadFile() {
        setTimeout(hideLoader,200);
        add_class();
        setTimeout(animation_string, 1500);
    }
    setTimeout(loadFile, 1500);
    function add_class(){
//        $(".parallax-mirror:eq(2)").addClass("active");
        $(".parallax-mirror:eq(1)").addClass("active");
        $(".text-html").addClass( "bounceInDown" );
        $(".text-css").addClass( "bounceInDown" );
        $(".slide-img1").addClass( "fadeInLeft" );
        $(".slide-img2").addClass( "fadeInRight" );
        $(".slide-img3").addClass( "fadeInLeft" );
        $(".slide-img4").addClass( "fadeInRight" );
        $(".slide-img5").addClass( "fadeInLeft" );
        $(".slide-img6").addClass( "fadeInRight" );
        $(".left-js").addClass( "fadeInLeft" );
        $(".right-js").addClass( "fadeInRight" );
        $(".right-js-b").addClass( "fadeInDown" );
        $(".js-b").addClass( "fadeInUp" );
    }
    function animation_string(){
        $(".background-block").addClass("active-animation");
    }
});