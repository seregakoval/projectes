
$(document).ready(function(){
    $(".images a").lightBox({
        overlayBgColor: '#333',
        overlayOpacity: 0.6,
        imageLoading: 'images/lightbox-ico-loading.gif',
        imageBtnClose: 'images/lightbox-btn-close.gif',
        imageBtnPrev: 'images/lightbox-btn-prev.gif',
        imageBtnNext: 'images/lightbox-btn-next.gif',
        containerResizeSpeed: 350,
        txtImage: 'Изображение',
        txtOf: 'из'
    });

(function(s) {
    var n;
    s(".tabs").on("click", "li:not(.active)", function() {
        n = s(this).parents(".tabs_block"), s(this).dmtabs(n)
    }), s.fn.dmtabs = function(n) {
        s(this).addClass("active").siblings().removeClass("active"), n.find(".box").eq(s(this).index()).show(1, function() {
            s(this).addClass("open_tab")
        }).siblings(".box").hide(1, function() {
            s(this).removeClass("open_tab")
        })
    }
})(jQuery);

});