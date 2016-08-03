$(document).ready(function(){
    $("#range").ionRangeSlider({
        type: "double",
        grid: false,
        min: 20,
        max: 199,
        from: 66,
        to: 130,
        prefix: "$"
    });

    $(".hide-right-sidebar").click(function(){
        $(".right-sidebar").addClass("right-sidebar_open");
    });
    $(".right-sidebar .hide-button a").click(function(){
        $(".right-sidebar").removeClass("right-sidebar_open");
    });
    $(".toggle-sidebar").on("click", function(){
        $(".left-sidebar").addClass("left-sidebar_open");
    });
    $(" .left-sidebar .btn-close").on("click", function(){
        $(".left-sidebar").removeClass("left-sidebar_open");
    });

    /*$( function() {
        $( "#slider-range" ).slider({
            range: true,
            min: 20,
            max: 199,
            values: [ 75, 300 ],
            slide: function( event, ui ) {
                $( "#amount" ).val( "$" + ui.values[ 0 ] );
                $( "#amount2" ).val(" - $" + ui.values[ 1 ]);

            }
        });
        $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
            " - $" + $( "#slider-range" ).slider( "values", 1 ) );
    } );*/

   /* $(".hide-menu li").hover(function(){
        $(this).find('span').fadeIn().css({"display":"block"});
    },function(){
        $(this).find('span').fadeOut(300,function(){
            $(this).css({"display":"none"});
        })
    });
*//*
   $('.hide-menu li').hover(function(){

        $(this.querySelector('span')).slideToggle();

    });*/
});