// Myriad Pro font
try{Typekit.load({ async: true });}catch(e){}

// ga + hotjar
window.onload = function(){
    // We need this timeout to make sure all graphs are loaded
    // because this script is universal and graphs are loaded later in ExternalAnalyserResultsAsset
    setTimeout(function(){
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-PQPXSP');
    }, 3000);
};

(function($) {
    // tooltips
    function infoHover() {
        var self = $(this);
        var parent = self.parents('.tooltip-block');
        var infoBlock = parent.find('div[class^="info-rerfgraph"]');
        var text = self.data('hover-text');
        infoBlock.empty();
        infoBlock.text(text);
        infoBlock.show();
    }
    function infoHoverRemove() {
        var self = $(this);
        var parent = self.parents('.tooltip-block');
        var infoBlock = parent.find('div[class^="info-rerfgraph"]');
        infoBlock.hide();
    }
    $(document).on('mouseover', '.fa-info', infoHover);
    $(document).on('mouseleave', '.fa-info', infoHoverRemove);
})(jQuery);


// fixed table
jQuery.fn.extend({
    fixedTable: function() {
        this.each(function(){
            var width = $(this).find('table').width(),
                firstTable = $(this).find('table')
                widthOffset = 10;
            if(width <= ($(this).width() + widthOffset)) {
                $(this).find('table').clone().addClass('fixed-table').appendTo(this);
                var fixedTable = $(this).find('.fixed-table');
                $(fixedTable).css({
                    'left': '50%',
                    'margin-left': (width / -2),
                    'width': width
                });
                $(window).scroll(function(){
                    var scrollTop = $(window).scrollTop(),
                        offsetTop = $(firstTable).offset().top,
                        offsetTopSecond = $(firstTable).offset().top + $(fixedTable).height() - $(fixedTable).find('thead').height();
                    (scrollTop >= offsetTop && scrollTop < offsetTopSecond) ? $(fixedTable).addClass('active') : $(fixedTable).removeClass('active');
                });
            }
        });
    }
});

$('[data-fixed-table]').fixedTable();
