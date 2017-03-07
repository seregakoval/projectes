$(function(){
    funcWidth();
});
$(window).resize(function(){
    funcWidth();
});
function funcWidth(){
    var windowWidth = $(window).width();
    console.log(windowWidth);
    if(windowWidth <= 991) {
        $(".menu__navigation > li > a:not(:first)").on('click',function(e){
            e.preventDefault();
        });
    } else {
        $("[data-scroll-nav] a").on('click', function(e) {
            // window.location = $(this).attr('href');
            var scrollTo = $(this).attr('href');
            $("body").animate({
                scrollTop: $(scrollTo).offset().top
            },500);

        });
    }
}

// $(function() {
//     var changeLocation = function() {
//         $("[data-scroll-nav] a").on('click', function(e) {
//             e.preventDefault();
//             var state = $(this).attr('href'),
//                 width = window.innerWidth,
//                 currentLocation = window.location.href,
//                 location = window.location.origin+'/pages/',
//                 stateStatic = location + state;
//             if(stateStatic != currentLocation) {
//                 window.location = stateStatic;
//             } else {
//                 $("body").animate({
//                     scrollTop: $(state).offset().top
//                 },500);
//             };
//         });
//     };
//     changeLocation();
//     $(window).resize(function() {
//         changeLocation();
//     });
// });