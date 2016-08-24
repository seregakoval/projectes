new WOW().init();
$(function(){
    $('.zz').on('click', function(){
        //alert('asdf');
        $.fancybox.open( $('#fancy_form'), {
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