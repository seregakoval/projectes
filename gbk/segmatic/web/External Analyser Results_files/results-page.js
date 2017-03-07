(function () {


    /*
     * Buttons click animation and info icon
     */

    function detectMobile() {
        return $(window).width() <= 600;
    }

    function setInfoIcons() {
        var a_btn = $('.active_btn').not('.no_info');
        var i = $('<i />').addClass('fa fa-info');
        a_btn.append(i);
    }



    function setActiveBtnCss() {
        var a_btn = $('.active_btn');
        var parents = a_btn.parent();
        var allActives = $('.active');

        parents.each(function (i, group) {
            var groupBtns = [];
            $(group).find('.btn').each(function (i, btn) {
                groupBtns.push($(btn).outerWidth());
            });
            var maxBtnWidth = Math.max.apply(Math, groupBtns);
            $(group).find('.btn').each(function (i, btn) {
                $(btn).css('width', maxBtnWidth);
            });
        });


        a_btn.each(function (i, val) {
            var btn = $(val).parent().find('.is_active');
            $(val).css('width', $(btn).outerWidth());
            $(val).css('height', $(btn).outerHeight());
            $(val).show();
        });

        allActives.removeClass('active');

        $('.second-line').find('.active_btn').hide();

    }

    function setMobileActive() {
        var active = $('.is_active');
        var a_btn = $('.active_btn');
        active.addClass('active');
        $('.multiple').find('.is_active').removeClass('active');
        $('.multiple').find('.is_active').first().addClass('active');
        a_btn.hide();
    }

    function setHover() {
//        $('div[class^="info-rerfgraph"]').hide();
    }

    function init() {
        if (!detectMobile()) {
            setActiveBtnCss();
            setInfoIcons();
            setHover();
        } else {
            setMobileActive();
        }
    }

    init();

    function buttonClick() {
        var self = $(this);
        if (!detectMobile()) {
            buttonAnimation(self);
        } else {
            buttonMobileClick(self);
        }
    }

    function buttonMobileClick(self) {
        if (!self.parents().hasClass('multiple')) {
            self.parent().find('.active').removeClass('active');
            self.addClass('active');
        } else {
            self.parents('.multiple').find('.active').removeClass('active');
            self.addClass('active');
        }

    }

    function buttonAnimation(self) {
        var parent = self.parent('div');
        var a_btn = parent.find('.active_btn');
        var futureIndex = self.index() - 1;
        var active = parent.find('.is_active');
        var currentIndex = active.index() - 1;
        var btn_width = self.outerWidth() - 1;
        var i = $('<i />').addClass('fa fa-info');


        a_btn.find('.fa-info').remove();
        active.removeClass('is_active');
        self.addClass('is_active');

       var leftAnimation = function() {
            if (currentIndex < futureIndex) {
                a_btn.animate({
                    left: self.position().left
                }, 500);
            } else {
                a_btn.animate({
                    left: self.position().left
                }, 500);
            }
       };

        a_btn.promise().done(function () {
            if (!a_btn.hasClass('no_info')) {
                a_btn.append(i);
            }
        });

        if (parent.hasClass('first-line') && a_btn.css('display') == 'none') {
            $('.second-line').find('.active_btn').animate({
                height: 0
            }, 200);
            setTimeout(function(){
                $('.second-line').find('.active_btn').hide();
            },200);
            $('.first-line').find('.active_btn').css("height", 0);
            $('.first-line').find('.active_btn').css({
                left: $('.second-line').find('.active_btn').css('left')
            });
            $('.first-line').find('.active_btn').show();
            $('.first-line').find('.active_btn').animate({
                'height': "32px"
            },200);
            setTimeout(function(){
                leftAnimation();
            },200);
        } else if (parent.hasClass('second-line') && a_btn.css('display') == 'none') {

            $('.first-line').find('.active_btn').animate({
                height: 0
            }, 200);
            setTimeout(function(){
                $('.first-line').find('.active_btn').hide();
            },200);
            $('.second-line').find('.active_btn').css("height", 0);
            $('.second-line').find('.active_btn').css({
                left: $('.first-line').find('.active_btn').css('left')
            });
            $('.second-line').find('.active_btn').show();
            $('.second-line').find('.active_btn').animate({
                'height': "32px"
            },200);
            setTimeout(function(){
                leftAnimation();
            },200);
        }else{
            leftAnimation();
        };
    }

    function infoHover() {
        var self = $(this);
        var parent = self.parents('.chart');
        var infoBlock = parent.find('div[class^="info-rerfgraph"]');
        var text = self.parents('.active_btn').parent().find('.is_active').attr('data-hover-text');
        infoBlock.empty();
        infoBlock.text(text);
        infoBlock.show();
    }

    function infoHoverRemove() {
        var self = $(this);
        var parent = self.parents('.chart');
        var infoBlock = parent.find('div[class^="info-rerfgraph"]');
        infoBlock.hide();
    }

    /*
     * dom events
     */

    $(document).on('click', '.chart a', buttonClick);
    $(document).on('mouseover', '.fa-info', infoHover);
    $(document).on('mouseleave', '.fa-info', infoHoverRemove);

    $(window).resize(function () {
        clearTimeout(window.resizedFinished);
        window.resizedFinished = setTimeout(function () {
            var label = $("tspan:contains('CPA')");
            label.attr('x', 15);
            $('#chart_div_first').find('a').remove();

            init();
        }, 100);
    });
    $(window).resize(function () {
        clearTimeout(window.resizedFinished);
        window.resizedFinished = setTimeout(function () {
            var label = $("tspan:contains('CPA')");
            label.attr('x', 15);
            $('#chart_div_first2').find('a').remove();

            init();
        }, 100);
    });

    
    /*
     * Buttons tabs
     */
    // 1
    $('.ea-btn-tab').click(function(){
        $(this).parent().find('.ea-btn-tab.tab-active').not($(this)).removeClass('tab-active');
        $(this).addClass('tab-active');
        var tabBlockId = $(this).data('tab-block');
        var tabLinkId = $(this).data('tab-link');
        if (!tabBlockId && tabLinkId) {
            var tabBlockLinks = $(this).parents('.row').find('.ea-btn-tab.tab-active[data-tab-link="'+tabLinkId+'"]');
            tabBlockLinks.each(function(){
                if ($(this).data('tab-block')) {
                    tabBlockId = $(this).data('tab-block');
                    return false;
                }
            });
        }
        if (tabBlockId) {
            var tabsAreValid = false;
            var parentRow = $(this).parents('.row');
            if (!tabLinkId) {
                tabsAreValid = true;
            } else {
                var activeTabs = parentRow.find('.tab-active.ea-btn-tab[data-tab-link="'+tabLinkId+'"]').not($(this));
                //console.log(activeTabs);
                tabsAreValid = activeTabs.length;
            }
            if (tabsAreValid) {
                parentRow.find('.ea-tab-block').not('[data-id="'+tabBlockId+'"]').hide();
                var activeTabBlock = parentRow.find('.ea-tab-block[data-id="'+tabBlockId+'"]');
                if (activeTabBlock.length) {
                    activeTabBlock.fadeIn('fast');
                    // fixed table
                    var fixedTable = activeTabBlock.find('[data-fixed-table]');
                    if (fixedTable.length && !fixedTable.hasClass('fixed-table')) {
                        fixedTable.fixedTable();
                    }
                }
            }
        }
    });
    $('.ea-btn-tab-hide').click(function(){
        $(this).parent().find('.ea-btn-tab.tab-active').removeClass('tab-active');
        $(this).parents('.row').find('.ea-tab-block:visible').fadeOut('fast');
    });
    // 2
    $('.ea-btn-tab-double').click(function(){
        $(this).parent().find('.ea-btn-tab-double.tab-active').not($(this)).removeClass('tab-active');
        $(this).addClass('tab-active');
        var parentRow = $(this).parents('.row');
        var tabBlockId1 = parentRow.find('.ea-btn-tab-double.tab-active[data-tab-double="1"]').length ? parentRow.find('.ea-btn-tab-double.tab-active[data-tab-double="1"]').data('tab-block') : parentRow.find('.ea-btn-tab-double[data-tab-double="1"]').first().data('tab-block');
        var tabBlockId2 = parentRow.find('.ea-btn-tab-double.tab-active[data-tab-double="2"]').length ? parentRow.find('.ea-btn-tab-double.tab-active[data-tab-double="2"]').data('tab-block') : parentRow.find('.ea-btn-tab-double[data-tab-double="2"]').first().data('tab-block');
        var tabBlockId = tabBlockId1+'-'+tabBlockId2;
        var activeTabBlock =  parentRow.find('.ea-tab-block[data-id="'+tabBlockId+'"]');
        parentRow.find('.ea-tab-block').not('.ea-tab-block[data-id="'+tabBlockId+'"]').removeClass('is_active').hide();
        if (activeTabBlock.length) {
            activeTabBlock.fadeIn('fast', function(){
                $(this).addClass('is_active');
            });
            // fixed table
            var fixedTable = activeTabBlock.find('[data-fixed-table]');
            if (fixedTable.length && !fixedTable.hasClass('fixed-table')) {
                fixedTable.fixedTable();
            }
        }
    });

})();
