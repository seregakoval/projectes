
$(document).ready(function(){

    $(".search-input").focus(function(){
        $(this).css("border-color", "#16CAA6");
        $(".search .search-b .fa-search").animate({right:15},200);
    }).blur(function(){
        $(this).css("border-color", "#ccc");
        $(".search .search-b .fa-search").animate({right:10},200);
    });



});