$(function(){
	$('.section_4 .item .btn').on('click', function(){
		var $elem = $(this).parents('.item'),
			type = $(this).attr('data-type');
		$('#foncy_form textarea').val(type + $('.name', $elem).text());//.replace(/\s+/g,''));
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