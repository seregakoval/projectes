// hidden rows
var eaShow = $('.ea-show');
eaShow.click(function(){
    $(this).parent().find('.ea-hidden').show();
    $(this).hide();
    return false;
});
 