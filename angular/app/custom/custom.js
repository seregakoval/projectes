




$(document).ready(function(){
    $(document).on("click","#openLeftNav", function(){
        $("#leftNav").animate({ left : "0"}, 100);
    });
    $(document).on("click",".close-sidebar-left", function(){
        $("#leftNav").animate({ left : "-230px"}, 100);
    });
    $(document).on("click","#openRightNav",function(){
        $(".asides-layout_right").animate({ right : "0"});
    });

    $(document).on("click",".aside-btn",function(){
        $(".asides-layout_right").animate({ right : "-230px"});
    });

    $(document).on("click","#toggle-btn", function(){
        $(this).parent().siblings().slideToggle();;
        $(".string_head .title .icon-down").toggleClass("open-body");
        return false;
    });


        //
        // $("#openLeftNav").click(function(){
        //     alert("koval");
        // });


    /*$(document).on('click','.left', function(event){
        $("#leftNav").animate({left: "0"}, 100);
    });
    $(document).on('click','body', function(event){
        if($("#leftNav").css('left') = ' 0 '){
            $("#leftNav").animate({left: "-230px"}, 100);
        }
    });*/





    /*$(document).click( function(event){
      if( $(event.target).closest("p").length )
        return;
      $("#openLeftNav").fadeOut("slow");
      event.stopPropagation();
  });*/
});
