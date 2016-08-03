/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/*function name(){
    
    this.querySelector('.text').slideDown("slow");
    
    
}*/
$(document).ready(function(){
     
    
   /*$('#tab1').click(function(){
       
   });*/
$('.nav-tabs a').click(function (e) {
    e.preventDefault();
    //$(this).tab('show');
    var index = $(this).closest('.nav-tabs').find('a').index($(this));
    $('.nav-tabs').each(function() {
        $(this).find('a').eq(index).tab('show');
    });
});
    $('.click-about-us').click(function(){
       $('html, body').animate({scrollTop:1950}, 2000);
       return false;
});
$('.play').click(function(){
       $('html, body').animate({scrollTop:2500}, 2000);
return false;
});
$('.contact').click(function(){
       $('html, body').animate({scrollTop:3650}, 3500);
return false;
});

    new WOW().init();
    $(".owl-carousel").owlCarousel({
        items:6,
        loop:true,
        autoplay:true,
        
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        480:{
            items:2,
            nav:true
        },
        620:{
            items:3,
            nav:true
        },
        768:{
            items:3,
            nav:true
        },
        1020:{
            items:6,
            nav:true,
            loop:false
        }
    }
    });
    $('.owl-carousel2').owlCarousel({
        items:1,
        dots:true,
        loop:true
    });
    $('.owl-carousel3').owlCarousel({
        items:1,
        dots:true,
        loop:true,
        nav:true,
        autoplay:true
    });
    var $menu = $(".nav");
       $(window).scroll(function(){
           if ( $(this).scrollTop() > 650 && $menu.hasClass("default") ){
               $('.header-f').css({'border-bottom':'0'});
               $menu.removeClass("default").addClass("fixed");
               $('.start').css({'opacity':'1'});
           } else if($(this).scrollTop() <= 650 && $menu.hasClass("fixed")) {
               $('.header-f').css({'border-bottom':'1px solid #6e6082'});
               $menu.removeClass("fixed").addClass("default");
               $('.start').css({'opacity':'0'});

           }

     });
    
jQuery(function($){
   $("#mask").mask("+ 99 999 - 999 - 999");
   $("#phone").mask("+ 99 999 - 999 - 999");
});
$('#check').styler();

    (function() {

  "use strict";

  var toggles = document.querySelectorAll(".cmn-toggle-switch");

  for (var i = toggles.length - 1; i >= 0; i--) {
    var toggle = toggles[i];
    toggleHandler(toggle);
  };

  function toggleHandler(toggle) {
    toggle.addEventListener( "click", function(e) {
      e.preventDefault();
      (this.classList.contains("active") === true) ? this.classList.remove("active") : this.classList.add("active");
    });
  }

})();    


});

