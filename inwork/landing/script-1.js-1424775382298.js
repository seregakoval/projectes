$(function(){
    $('.s1feedback_cont input.intext').keyup(function(){
        $(this).removeClass('err');
    });
    $(document).mouseup(function (e) {
        var $cont = $(".s1fb_msg");
        //if ($cont.has(e.target).length === 0){$cont.fadeOut(200);}
        $cont.fadeOut(200);
    });
});