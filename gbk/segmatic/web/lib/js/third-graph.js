(function () {

    if (!$('.ea-third-graph').length) {
        return;
    }

    function drawChart(data,/* cpa,*/ flag) {
        
        var rawData;
        if (flag === 2) {
            rawData = data.concat(actualData());
        } else {
            rawData = data;
        }
        
        var minMax = getMinMax();
        var itemDummy = [
            -100,
            -100,
            'opacity: 0',
            '',
            ''
        ];

        google.charts.setOnLoadCallback(drawBasic);

        function getTooltip(val) {
            var tooltip;

            if (val.type === 'Brand') {
                tooltip = '<div  style="background: rgba(164,215,78,0.2); border: 1px solid #A4D74E; padding: 10px; min-width: 150px; text-align: left; z-index: 1000">' +
                        '<p>' + val.type + '</p>' +
                        '<p> COST: £' + val.y + '</p>' +
                        '<p> CPA: £' + val.x + '</p>' +
                        '<p> ROI: £' + val.roi + '</p>' +
                        '</div>';
            } else if (val.type === 'Generic') {
                tooltip = '<div  style="background: rgba(73,172,239,0.2); border: 1px solid #49ACEF; padding: 10px; min-width: 150px; text-align: left; z-index: 1000">' +
                        '<p>' + val.type + '</p>' +
                        '<p> COST: £' + val.y + '</p>' +
                        '<p> CPA: £' + val.x + '</p>' +
                        '<p> ROI: £' + val.roi + '</p>' +
                        '</div>';
            }

            return tooltip;

        }
        
        function getDataForRows() {
            var result = [];

            $.each(rawData, function (i, val) {
                var item = [];
                item.push(val.x);
                item.push(val.y);
                if (val.type === 'Brand') {
                    if (flag === 2 && val.flag === 'Reported') {
                        item.push('color: #A4D74E; opacity: 0.4');
                    } else {
                        item.push('color: #A4D74E; opacity: 0.9');
                    }
                } else {
                    if (flag === 2 && val.flag === 'Reported') {
                        item.push('color: #49ACEF; opacity: 0.4');
                    } else {
                        item.push('color: #49ACEF; opacity: 0.9');
                    }
                }

                if (flag === 1 && val.flag === 'reported') {
                    item.push('');
                } else {
                    item.push(val.type);
                }

                item.push(getTooltip(val));

                result.push(item);
                
                result.push(itemDummy);
            });

            return result;
        }

        function getTicks() {
            var result = [];
            $.each(data, function (i, val) {
                result.push(val.x);
            });
            return  result;
        }



        function drawBasic() {

            var gData = new google.visualization.DataTable();

            var dataForRows = getDataForRows();

            gData.addColumn('number', 'cpa');
            gData.addColumn('number', 'cost');
            gData.addColumn({type: 'string', role: 'style'});
            gData.addColumn({type: 'string', role: 'annotation'});
            gData.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});

            gData.addRows(dataForRows);

            var options = {
                hAxis: {
                    viewWindow: {
                        min: minMax.hMin,
                        max: minMax.hMax
                    },
                    textStyle: {
                        fontSize: 10
                    },
                    gridlines: {
                        count: 10,
                        color: '#EDEDED'
                    }
                },
                vAxis: {
                    viewWindow: {
                        min: minMax.vMin,
                        max: minMax.vMax
                    },
                    gridlines: {
                        count: 10,
                        color: '#EDEDED'
                    },
                    textStyle: {
                        fontSize: 10

                    }
                },
                bar: {
                    groupWidth: 40
                },
                legend: 'none',
                tooltip: {
                    isHtml: true
                },
                annotations: {
                    alwaysOutside: 'true',
                    stemColor: 'none',
                    auraColor: 'transparent'
                },
                animation: {
                    duration: 1000,
                    easing: 'out',
                    startup: true
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_third'));

            chart.draw(gData, options);
        }
        
        function getMinMax() {
            // defaults
            var minMax = {
                hMin: 100,
                hMax: 0,
                vMin: 0,
                vMax: 0
            };
            // counting
            rawData.forEach(function(item) {
                if (item.x < minMax.hMin) {
                    minMax.hMin = item.x;
                }
                if (item.x > minMax.hMax) {
                    minMax.hMax = item.x;
                }
                if (item.y > minMax.vMax) {
                    minMax.vMax = item.y;
                }
            });
            // adding small offset (20% / 20%)
            var hPerc = 0.2;
            var vPerc = 0.2;
            var hOffset = minMax.hMax ? minMax.hMax * hPerc : minMax.hMin * hPerc;
            hOffset = Math.round(hOffset);
            var vOffset = minMax.vMax ? minMax.vMax * vPerc : minMax.vMin * vPerc;
            vOffset = Math.round(vOffset);
            if (minMax.hMin) {
                minMax.hMin = minMax.hMin - hOffset < 0 ? 0 : Math.round(minMax.hMin - hOffset);
            }
            if (minMax.hMax) {
                minMax.hMax = Math.round(minMax.hMax + hOffset);
            }
            if (minMax.vMax) {
                minMax.vMax = Math.round(minMax.vMax + vOffset);
            }
            return minMax;
        }

    }
    
    var influenceSegment = $('.ea-third-graph-segment').first().data('segment');
    var influenceFlag = $('.ea-third-graph-flag').first().data('flag');
    var flag = 'Reported' == influenceFlag ? 1 : 2;
    var actualDataFuncName = 'getInfluence'+influenceSegment+'Reported';
    //var cpaBlock = $('#ea-cpa');
    //var brandCPA = cpaBlock.length ? parseFloat(cpaBlock.data('brand')) : 0;
    //var nonBrandCPA = cpaBlock.length ? parseFloat(cpaBlock.data('non-brand')) : 0;
    
    function influenceInit() {
        var funcName = 'getInfluence'+influenceSegment+influenceFlag;
        if (funcName in window) {
            var data = window[funcName](); // eval(funcName)();
            //var cpa = 'Brand' == influenceSegment ? brandCPA : nonBrandCPA;
            flag = 'Reported' == influenceFlag ? 1 : 2;
            drawChart(data, /*cpa, */flag);
        } else {
            console.log('Undefined function: '+funcName);
        }
    }
    
    function actualData() {
        actualDataFuncName = 'getInfluence'+influenceSegment+'Reported';
        if (actualDataFuncName in window) {
            return window[actualDataFuncName]();
        } else {
            return [];
        }
    }
    
    influenceInit();
    
    // on clicks
    $('.ea-third-graph').click(function(){
        if (!$(this).hasClass('isActive')) {
            var type = $(this).data('type');
            if ('segment' == type) {
                influenceSegment = $(this).data('segment');
                var flagObj = $('.ea-third-graph-flag.is_active').length == 1 ? $('.ea-third-graph-flag.is_active') : $('.ea-third-flag-label').first();
                influenceFlag = flagObj.data('flag');
            } else {
                influenceFlag = $(this).data('flag');
                var segmentObj = $('.ea-third-graph-segment.is_active').length == 1 ? $('.ea-third-graph-segment.is_active') : $('.ea-third-graph-segment').first();
                influenceSegment = segmentObj.data('segment');
            }
            influenceInit();
        }
    });

    $(window).resize(function () {
        if (this.resizeTO)
            clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function () {
            $(this).trigger('resizeEnd');
        }, 500);
    });


    $(window).on('resizeEnd', function () {
        influenceInit();
    });

})();