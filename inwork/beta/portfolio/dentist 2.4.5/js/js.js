$(document).ready(function(){
    

$('.icon1').click(function (event) {
        event.preventDefault();
        $('#overlay').fadeIn(200,
            function () {
                $('#modal_form').css('display', 'block').animate({opacity: 1}, 200);
            });
    });
    $('#modal_close, #overlay').click(function () {
        $('#modal_form').animate({opacity: 0, top: '45%'}, 200,
            function () {
                $(this).css('display', 'none');
                $('#overlay').fadeOut(200);
            }
        );
    });


$('.servises').click(function () {
		$('body').animate({scrollTop: 1000}, 'slow');
		
	});


$('.btn').click(function(){
	if ($(".top-header .wrapper .top-nav ul").is(":hidden")) {
		$('.top-header .wrapper .top-nav ul').slideDown();

     } else {
 	$('.top-header .wrapper .top-nav ul').slideUp();
	}
	return false;
});


$('.owl-carousel').owlCarousel({
    items:1,
    dots:true,
    autoplay:true
});



$("#slider").slider({
     min: 10000,
     max: 600000,
     values: [10000,600000],
     range: true,
     stop: function(event, ui) {
         jQuery("input#minCost").val(jQuery("#slider").slider("values",0));
         jQuery("input#maxCost").val(jQuery("#slider").slider("values",1));
     },
     slide: function(event, ui){
         jQuery("input#minCost").val(jQuery("#slider").slider("values",0));
         jQuery("input#maxCost").val(jQuery("#slider").slider("values",1));
     }
    });


 if($(window).width() < 815){
    $('.container-box').removeClass('clearfix');
}
 if($(window).width() < 768){
    $('.remove').addClass('clear');
}

(function($) {
        $(function() {
            $('select').styler({
                selectSearch: true
            });
        });

        })(jQuery);

    $(function() {
    if (window.PIE) {
        $('.phone, .mybasket,input').each(function() {
            PIE.attach(this);
        });
    }
});


});