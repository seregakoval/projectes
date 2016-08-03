(function(e,p){e.extend({lockfixed:function(a,b){b&&b.offset?(b.offset.bottom=parseInt(b.offset.bottom,10),b.offset.top=parseInt(b.offset.top,10)):b.offset={bottom:100,top:0};if((a=e(a))&&a.offset()){var n=a.css("position"),c=parseInt(a.css("marginTop"),10),l=a.css("top"),g=a.offset().top,h=!1;if(!0===b.forcemargin||navigator.userAgent.match(/\bMSIE (4|5|6)\./)||navigator.userAgent.match(/\bOS ([0-9])_/)||navigator.userAgent.match(/\bAndroid ([0-9])\./i))h=!0;e(window).bind("scroll resize orientationchange load lockfixed:pageupdate",
    a,function(k){if(!h||!document.activeElement||"INPUT"!==document.activeElement.nodeName){var d=0,d=a.outerHeight();k=a.outerWidth();var m=e(document).height()-b.offset.bottom,f=e(window).scrollTop();"fixed"!=a.css("position")&&(g=a.offset().top,c=parseInt(a.css("marginTop"),10),l=a.css("top"));f>=g-(c?c:0)-b.offset.top?(d=m<f+d+c+b.offset.top?f+d+c+b.offset.top-m:0,h?a.css({marginTop:parseInt((c?c:0)+(f-g-d)+2*b.offset.top,10)+"px"}):a.css({position:"fixed",top:b.offset.top-d+"px",width:k+"px"})):
        a.css({position:n,top:l,width:k+"px",marginTop:(c?c:0)+"px"})}})}}})})(jQuery);
jQuery.noConflict();
jQuery(function($) {
    $(document).ready( function() {
        $(".woocommerce ul.products li.product a img").wrap("<div class='wrap-img'></div>");
        $(".widget.woocommerce.widget_product_categories > ul > li > a").append('<i class="fa fa-angle-right" aria-hidden="true"></i>');
        $(".checkout.woocommerce-checkout").submit(function(){
            var form = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '/wp_site_lanselot/wp-content/themes/gourmand/js/mail.php',
                data:form,
                success: function(){
                    alert("Cпециалист свяжется с вами в ближайшее время");
                },
                error: function(){
                    alert('error');
                }
            });
            return false;
        });
        $(".upsells.products h2").html('С этим товаром покупают');
        $(".rem > p").remove();
        $(".related.products .products .product  p").addClass("text-info");

        (function($) {
            $.lockfixed(".sidebar",{offset: {top: 80, bottom: 10}});
        })(jQuery);

        $('ul.sf-menu').superfish({
            autoArrows:  true
        });
        
    $('.gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      closeOnContentClick: true,
      closeBtnInside: false,
      mainClass: 'mfp-with-zoom mfp-img-mobile',
      image: {
        verticalFit: true,
        titleSrc: function(item) {
          return item.el.attr('title') + '';
        }
      },
      gallery: {
        enabled: true
      },
      zoom: {
        enabled: true,
        duration: 300, // don't foget to change the duration also in CSS
        opener: function(element) {
          return element.find('img');
        }
      }

    });
        
      /* fix vertical when not overflow
      call fullscreenFix() if .fullscreen content changes */
      function fullscreenFix(){
          var h = $('body').height();
          // set .fullscreen height
          $(".homepage").each(function(i){
              if($(this).innerHeight() <= h){
                  $(this).closest(".fullscreen").addClass("not-overflow");
              }
          });
      }
      $(window).resize(fullscreenFix);
      fullscreenFix();
        
        resizeDiv();
        var setsmallwidth = "100%";

        vpw = $(window).width();
        vph = $(document).height();

        if(vpw<648) {
            setsmallwidth = "100%";
        }
        $('.small_menu').click(function(){
             $( ".mobile-sidebar" ).animate({
                 width: setsmallwidth,
                 display:"block",
                 left: "0"
              }, 500,function(){resizeDiv();});

        });
        $('.close_sidebar').click(function(){
             $( ".mobile-sidebar" ).animate({
                 width: "0",
                 display:"block"
              }, 500);
        });


    });

    function resizeDiv() {
        vpw = $(document).width();
        vph = $(document).height();
        $('.mobile-sidebar').css({'height': vph + 'px'});
    }

    
      /********** sticky Header  **********/
      $(window).scroll(function() {
      if ($(this).scrollTop() > $(window).height() - $('header').height()){
          $('header').addClass("sticky");
        }
        else{
          $('header').removeClass("sticky");
        }
      });
    
});

