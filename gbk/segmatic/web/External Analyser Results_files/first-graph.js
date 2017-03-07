(function () {
    //https://docs.amcharts.com/3/javascriptcharts/AmCharts
    
    if (!$('.ea-first-graph-segment').length) {
        return;
    }

    function drawChart(data, cpa, label) {

        var v2args = {
            "id": "v2",
            "gridAlpha": 0.1,
            "axisAlpha": 1,
            "position": "right",
            "guides": [{
                "dashLength": 6,
                "inside": false,
                "fontSize": 14,
                "label": label,
                "lineColor": "#fc6051",
                "color": "#fc6051",
                "lineAlpha": 1,
                "value": cpa,
            }],
        };
        // if cpa is over y2 min / max - we should manually set minY2 / maxY2 so the CPA line will be on graph
        var minY2 = cpa;
        var maxY2 = cpa;
        var maxCpa = true;
        var minCpa = true;
        data.forEach(function(item){
            var y2 = item.y2;
            if (y2 > maxY2) {
                maxY2 = y2;
                maxCpa = false;
            }
            if (y2 < minY2) {
                minY2 = y2;
                minCpa = false;
            }
        });
        var y2offset = (maxY2 - minY2) * 0.1; // 10%
        if (maxCpa) {
            v2args.maximum = maxY2 + y2offset;
        }
        if (minCpa) {
            v2args.minimum = minY2 - y2offset < 0 ? 0 : minY2 - y2offset;
        }
        // building chart
        var chart = AmCharts.makeChart("chart_div_first", {
            "type": "serial",
            "theme": "light",
            "dataProvider": data,
            "fontFamily": "myriad-pro",
            "valueAxes": [
                {
                    "id": "v1",
                    "gridAlpha": 0,
                    "axisAlpha": 1,
                    "position": "left"
                },
                v2args
            ],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#49acef",
                "bullet": false,
                "title": "conversions",
                "valueField": "y",
                "fillAlphas": 0,
                "balloonFunction": function (graphDataItem, graph) {
                    var value = graphDataItem.values.value;
                    return "Conversions: " + value;
                }
            }, {
                "valueAxis": "v2",
                "lineColor": "#fc6051",
                "bullet": false,
                "title": "cpa",
                "valueField": "y2",
                "fillAlphas": 0,
                "balloonFunction": function (graphDataItem, graph) {
                    var value = graphDataItem.values.value;
                    return "CPA: " + value;
                }
            }],
            "chartCursor": {
                "cursorPosition": "mouse"
            },
            "categoryField": "x",
            "categoryAxis": {
                "axisColor": "#DADADA",
                "minorGridEnabled": false
            },
            "export": {
                "enabled": true,
                "position": "bottom-right"
            },
            "legend": false,
            "balloon": {
                borderThickness: 1
            }

        });

        // chart.addListener("rendered", function () {
        //     var lbl = $("tspan:contains('CPA')");
        //     lbl.attr('x', parseFloat(lbl.attr('x')) + 15);
        // });


    }
    function drawChart2(data2, cpa2, label2) {

        var v2args2 = {
            "id": "v2",
            "gridAlpha": 0.1,
            "axisAlpha": 1,
            "position": "right",
            "guides": [{
                "dashLength": 6,
                "inside": false,
                "fontSize": 14,
                "label": label2,
                "lineColor": "#fc6051",
                "color": "#fc6051",
                "lineAlpha": 1,
                "value": cpa2,
            }],
        };
        // if cpa is over y2 min / max - we should manually set minY2 / maxY2 so the CPA line will be on graph
        var minY2 = cpa2;
        var maxY2 = cpa2;
        var maxCpa = true;
        var minCpa = true;
        // data.forEach(function(item){
        //     var y2 = item.y2;
        //     if (y2 > maxY2) {
        //         maxY2 = y2;
        //         maxCpa = false;
        //     }
        //     if (y2 < minY2) {
        //         minY2 = y2;
        //         minCpa = false;
        //     }
        // });
        var y2offset = (maxY2 - minY2) * 0.1; // 10%
        if (maxCpa) {
            v2args2.maximum = maxY2 + y2offset;
        }
        if (minCpa) {
            v2args2.minimum = minY2 - y2offset < 0 ? 0 : minY2 - y2offset;
        }
        // building chart
        var chart2 = AmCharts.makeChart("chart_div_first6", {
            "type": "serial",
            "theme": "light",
            "dataProvider": data2,
            "fontFamily": "myriad-pro",
            "valueAxes": [
                {
                    "id": "v1",
                    "gridAlpha": 0,
                    "axisAlpha": 1,
                    "position": "left"
                },
                v2args2
            ],
            "graphs": [{
                "valueAxis": "v1",
                "lineColor": "#49acef",
                "bullet": false,
                "title": "conversions",
                "valueField": "y",
                "fillAlphas": 0,
                "balloonFunction": function (graphDataItem, graph) {
                    var value = graphDataItem.values.value;
                    return "Conversions: " + value;
                }
            }, {
                "valueAxis": "v2",
                "lineColor": "#fc6051",
                "bullet": false,
                "title": "cpa",
                "valueField": "y2",
                "fillAlphas": 0,
                "balloonFunction": function (graphDataItem, graph) {
                    var value = graphDataItem.values.value;
                    return "CPA: " + value;
                }
            }],
            "chartCursor": {
                "cursorPosition": "mouse"
            },
            "categoryField": "x",
            "categoryAxis": {
                "axisColor": "#DADADA",
                "minorGridEnabled": false
            },
            "export": {
                "enabled": true,
                "position": "bottom-right"
            },
            "legend": false,
            "balloon": {
                borderThickness: 1
            }
        });
    }

    var segment = $('.ea-first-graph-segment').first().data('segment');
    var date = $('.ea-first-graph-date').first().data('date');
    var date2 = $('.ea-first-graph-date').first().data('date');
    var cpaBlock = $('#ea-cpa');
    var brandCPA = cpaBlock.length ? parseFloat(cpaBlock.data('brand')) : 0;
    var nonBrandCPA = cpaBlock.length ? parseFloat(cpaBlock.data('non-brand')) : 0;
    var weekMonthBlock = $('#ea-week-month');

    function init() {
            var data = getGenericWeek(); // eval(funcName)();
            var data2 = getGenericWeek(); // eval(funcName)();
            var cpa = brandCPA;
            var cpa2 = nonBrandCPA;
            var label = $(window).width() <= 800 ? "" : "CPA TARGET";
            var label2 = $(window).width() <= 800 ? "" : "CPA TARGET";
            weekMonthBlock.text(date);
            drawChart(data, cpa, label);
            drawChart2(data2, cpa2, label2);
            var lbl = $("tspan:contains('CPA')");
            lbl.attr('x', parseFloat(lbl.attr('x')) + 15);


    }

    init();


    $(window).resize(function () {
        if(this.resizeTO) clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function() {
            $(this).trigger('resizeEnd');
        }, 500);
    });


    $(window).on('resizeEnd', function () {
        init();
    });

})();
