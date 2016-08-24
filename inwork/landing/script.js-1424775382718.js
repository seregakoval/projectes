$(function(){
	$(".catalog_index").owlCarousel({
		navigation : true,
		pagination: true,
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		autoPlay:true,
		stopOnHover: true,
		transitionStyle : "fade" //fade, backSlide, goDown and fadeUp
	});
	$('.section_9 .item .btn').on('click', function(){
		var $elem = $(this).parents('.item');
		$('#foncy_form textarea').val($('.name', $elem).text());//.replace(/\s+/g,''));
		//alert('asdf');
		$.fancybox.open( $('#foncy_form'), {
			maxWidth	: 350,
			//maxHeight	: 450,
			fitToView	: true,
			//width		: '70%',
			//height		: '70%',
			autoSize	: true,
			closeClick	: false,
			openEffect	: 'none',
			closeEffect	: 'none'
		});
		return false;
	})
});