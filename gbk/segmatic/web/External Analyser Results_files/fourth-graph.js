(function () {
    
    var info = $('.graph-info');

    $('.column-block').on('mouseover', function () {
        var title = $(this).find('.title').text();
        var keyword = $(this).attr('data-keyword');
        var cost = $(this).attr('data-cost');
        var cpa = $(this).attr('data-cpa');
        var roi = $(this).attr('data-roi');
        info.find('.search').text(title);
        info.find('.keyword').text(keyword);
        info.find('.cost').text(cost);
        info.find('.cpa').text(cpa);
        info.find('.roi').text(roi);

        info.show();
    });

    $('.column-block').on('mouseout', function () {
        info.hide();
    });

})();