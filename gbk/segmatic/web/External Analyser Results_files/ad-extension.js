(function () {
    
    /* Ad Copy */
    
    if ($('.ea-ad-copy-ad').length) {
    
        function adCopyInit(data) {
            $('.ea-google-item-term').text(data.term);
            $('.ea-google-item-term-placeholder').attr('placeholder', data.term);
            $('.ea-google-item-cost').text(data.cost);
            $('.ea-google-item-desc1').text(data.desc1);
            $('.ea-google-item-desc2').text(data.desc2);
            $('.ea-google-item-ad').text(data.ad);
            $('.ea-google-item-url').text(data.url);
            $('.ea-google-item-url-href').attr('href', data.url);
            var adCheckHtml = 'Not Present' == data.adCheck ? '<span class="text-danger">fail</span>' : '<span class="text-success">pass</span>';
            var urlCheckHtml = 'Not Present' == data.urlCheck ? '<span class="text-danger">fail</span>' : '<span class="text-success">pass</span>';
            $('.ea-google-item-ad-check').html(adCheckHtml);
            $('.ea-google-item-url-check').html(urlCheckHtml);
        }

        var adData = $('.ea-ad-copy-ad').first().data();

        $('.ea-ad-copy-ad').click(function() {
            if (!$(this).hasClass('current')) {
                $(this).parent().find('.current').removeClass('current');
                $(this).addClass('current');
                adData = $(this).data();
                adCopyInit(adData);
            }
        });

        $('.ea-ad-copy-type').click(function() {
            if (!$(this).hasClass('active')) {
                var type = $(this).data('type');
                var parentBlock = $(this).parents('.ea-google-items');
                parentBlock.find('.ea-ad-copy-items.current').removeClass('current');
                var currentItems = parentBlock.find('.ea-ad-copy-items-'+type);
                currentItems.addClass('current');
                adData = currentItems.find('.ea-ad-copy-ad.current').data();
                adCopyInit(adData);
            }
        });

        adCopyInit(adData);
        
    }
    
    /* Ad Extension */
    
    if ($('.ea-ad-extension-segment').length) {
    
        var sitelinkOk, calloutOk, strSnipOk;
        function adExtensionInit(data, type) {
            if ('current' == type) {
                sitelinkOk = 'Active' == data.sitelink;
                calloutOk = 'Active' == data.callout;
                strSnipOk = 'Active' == data.structuredSnippet;
            } else  {
                sitelinkOk = 'Active' == data.sitelink || 'Missing' == data.sitelink;
                calloutOk = 'Active' == data.callout || 'Missing' == data.callout;
                strSnipOk = 'Active' == data.structuredSnippet || 'Missing' == data.structuredSnippet;
            }
            if (strSnipOk) {
                extStrSnip.html('<span>Structured Snippets: Snippet1, Snippet2, Snippet3, Snippet4</span>');
            } else {
                extStrSnip.html('');
            }
            if (calloutOk) {
                extCallout.html('<span>Callout Ext 1 · Callout Ext 2 · Callout Ext 3</span>');
            } else {
                extCallout.html('');
            }
            if (sitelinkOk) {
                extSitelink.html('<span><a href="javascript: void(0)">Sitelink1</a> - <a href="javascript: void(0)">Sitelink2</a> - <a href="javascript: void(0)">Sitelink3</a> - <a href="javascript: void(0)">Sitelink4</a></span>');
            } else {
                extSitelink.html('');
            }
        }

        var extStrSnip = $('.ea-ext-structured-snippet');
        var extCallout = $('.ea-ext-callout');
        var extSitelink = $('.ea-ext-sitelink');
        var extSegmentData = $('.ea-ad-extension-segment.is_active').length ? $('.ea-ad-extension-segment.is_active').data() : $('.ea-ad-extension-segment').first().data();
        var extType = $('.ea-ad-extension-type.is_active').length ? $('.ea-ad-extension-type.is_active').data('type') : $('.ea-ad-extension-type').first().data('type');

        adExtensionInit(extSegmentData, extType);

        $('.ea-ad-extension-segment, .ea-ad-extension-type').click(function(){
            if (!$(this).hasClass('is_active')) {
                if ($(this).hasClass('ea-ad-extension-segment')) {
                    extSegmentData = $(this).data();
                } else {
                    extType = $(this).data('type');
                }
                adExtensionInit(extSegmentData, extType);
            }
        });

    }

})();
