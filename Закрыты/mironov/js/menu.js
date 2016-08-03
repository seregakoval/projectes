$(document).ready(function(){ 
	var touch 	= $('#touch-menu');
	var menu 	= $('.menu');

	$(touch).on('click', function(e) {
		e.preventDefault();
		menu.slideToggle();
	});
	
	$(window).resize(function(){
		var w = $(window).width();
		if(w > 767 && menu.is(':hidden')) {
			menu.removeAttr('style');
		}
	});
        $('.modal-show').click(function (event) {
		event.preventDefault();
		$('#overlay').fadeIn(200,
			function () {
				$('#modal_form').css('display', 'block').animate({opacity: 1}, 200);
			});
	});
	$('#modal_close, #overlay').click(function () {
		$('#modal_form').animate({opacity: 0, top: '30%'}, 200,
			function () {
				$(this).css('display', 'none');
				$('#overlay').fadeOut(200);
			}
		);
	});
	$('.modal-show2').click(function (event) {
		event.preventDefault();
		$('#overlay').fadeIn(200,
			function () {
				$('#modal_form2').css('display', 'block').animate({opacity: 1}, 200);
			});
	});
	$('#modal_close2, #overlay').click(function () {
		$('#modal_form2').animate({opacity: 0, top: '10%'}, 200,
			function () {
				$(this).css('display', 'none');
				$('#overlay').fadeOut(200);
			}
		);
	});
});