google.charts.load('current', {packages: ['corechart', 'bar']});
// https://developers.google.com/chart/interactive/docs/gallery/columnchart

(function () {

    if (!$('.ea-second-graph').length) {
        return;
    }

    function drawChart(data, cpa) {
        
        var minMax = getMinMax();
        var itemDummy = [
            -100,
            -100,
            '',
            'opacity: 0',
            ''
        ];

        google.charts.setOnLoadCallback(drawBasic);

        function getTooltip(item) {

            var tooltip;

            if (item.x >= cpa) {
                tooltip = '<div  style="background: rgba(238,49,17,0.2); border: 1px solid #EE3111; padding: 10px; min-width: 150px; text-align: left; z-index: 1000">' +
                        '<p>' + item.label + '</p>' +
                        '<p> COST: £' + item.y + '</p>' +
                        '<p> CPA: £' + item.x + '</p>' +
                        '<p> ROI: £' + item.roi + '</p>' +
                        '</div>';
            } else if (item.x < cpa) {
                tooltip = '<div  style="background: rgba(164,215,78,0.2); border: 1px solid #A4D74E; padding: 10px; min-width: 150px; text-align: left; z-index: 1000">' +
                        '<p>' + item.label + '</p>' +
                        '<p> COST: £' + item.y + '</p>' +
                        '<p> CPA: £' + item.x + '</p>' +
                        '<p> ROI: £' + item.roi + '</p>' +
                        '</div>';
            }

            return tooltip;
        }
        
        function getDataForRows() {

            var result = [];
            var rawData = data;

            $.each(rawData, function (i, val) {
                var item = [];
                item.push(val.x);
                item.push(val.y);

                item.push(val.label);

                if (val.x >= cpa) {
                    item.push('color: #EE3111; opacity: 0.8');
                } else if (val.x < cpa) {
                    item.push('color: #A4D74E; opacity: 0.8');
                }

                item.push(getTooltip(val));
                result.push(item);
                // we do this small trick because when two following items has close X value - thei width shrink
                result.push(itemDummy);
            });

            return result;
        }

        function drawBasic() {

            var data = new google.visualization.DataTable();

            var dataForRows = getDataForRows();

            data.addColumn('number', 'cpa');
            data.addColumn('number', 'cost');
            data.addColumn({type: 'string', role: 'annotation'});

            data.addColumn({type: 'string', role: 'style'});
            data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});

            data.addRows(dataForRows);

            var options = {
                hAxis: {
                    gridlines: {
                        count: 10,
                        color: '#EDEDED'

                    },
                    textStyle: {
                        fontSize: 10
                    },
                    viewWindow: {
                        min: minMax.hMin,
                        max: minMax.hMax
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
                    },

                },
                bar: {
                    groupWidth: 40
                },
                legend: 'none',
                /*isStacked: true,*/
                tooltip: {
                    isHtml: true
                },
                animation: {
                    duration: 1000,
                    easing: 'out',
                    startup: true
                },
                annotations: {
                    alwaysOutside: 'true',
                    stemColor: 'none',
                    textStyle: {
                        color: "#000000",
                        auraColor: 'transparent'
                    }
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_second'));
            chart.draw(data, options);
            
            var chartHeight = $('#chart_div_second').height();
            var chartOffset = 55; // distance from chart wrapper border to grid
            var cpaHeight = chartHeight - chartOffset * 2;
            var cpaTextTop = chartOffset - 23;
            
            var line = document.createElement("div");
            var text = document.createElement("span");
            var interface = chart.getChartLayoutInterface();
            var cli = chart.getChartLayoutInterface();
            line.style.borderLeft = "1px #49acee dashed";
            line.style.width = "1px";
            line.style.position = "absolute";
            line.style.left = (interface.getXLocation(cpa)) + "px";
            line.style.top = chartOffset + "px";
            line.style.height = cpaHeight + "px";

            text.style.position = "absolute";
            text.style.left = (interface.getXLocation(cpa) - 35) + "px";
            text.style.top = cpaTextTop + "px";
            text.innerHTML = 'CPA TARGET';
            text.style.color = '#49acee';
            $(line).insertBefore($('#chart_div_second').find('div').find('div').last());
            document.getElementById('chart_div_second').appendChild(text);
        }
        
        function getMinMax() {
            // defaults
            var minMax = {
                hMin: cpa,
                hMax: cpa,
                vMin: 0,
                vMax: 0
            };
            // counting
            data.forEach(function(item) {
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
            // adding small offset (5% / 20%)
            var hPerc = 0.05;
            var vPerc = 0.2;
            var hOffset = minMax.hMax ? minMax.hMax * hPerc : minMax.hMin * hPerc;
            hOffset = Math.round(hOffset);
            var vOffset = minMax.vMax ? minMax.vMax * vPerc : minMax.vMin * vPerc;
            vOffset = Math.round(vOffset);
            if (minMax.hMin) {
                minMax.hMin = minMax.hMin - hOffset;
            }
            if (minMax.hMax) {
                minMax.hMax = minMax.hMax + hOffset;
            }
            if (minMax.vMax) {
                minMax.vMax = minMax.vMax + vOffset;
            }
            return minMax;
        }

    }
    
    var performanceSegment = 1 == $('.ea-second-graph-segment.is_active').length ?$('.ea-second-graph-segment.is_active').data('segment') : $('.ea-second-graph-segment').first().data('segment');
    var performanceLabel = 1 == $('.ea-second-graph-label.is_active').length ? $('.ea-second-graph-label.is_active').first().data('label') : $('.ea-second-graph-label').first().data('label');
    var cpaBlock = $('#ea-cpa');
    var brandCPA = cpaBlock.length ? parseFloat(cpaBlock.data('brand')) : 0;
    var nonBrandCPA = cpaBlock.length ? parseFloat(cpaBlock.data('non-brand')) : 0;
    
    function performanceInit() {
        var funcName = 'getPerformance'+performanceLabel+performanceSegment;
        if (funcName in window) {
            var data = window[funcName](); // eval(funcName)();
            var cpa = 'Brand' == performanceSegment ? brandCPA : nonBrandCPA;
            drawChart(data, cpa);
        } else {
            console.log('Undefined function: '+funcName);
        }
    }
    
    performanceInit();

    // on clicks
    $('.ea-second-graph').click(function(){
        if (!$(this).hasClass('isActive')) {
            var type = $(this).data('type');
            if ('segment' == type) {
                performanceSegment = $(this).data('segment');
                var labelObj = $('.ea-second-graph-label.is_active').length == 1 ? $('.ea-second-graph-label.is_active') : $('.ea-second-graph-label').first();
                performanceLabel = labelObj.data('label');
            } else {
                $(this).parents('.multiple').find('.ea-second-graph-label.is_active').not(this).removeClass('is_active'); // small layout fix
                performanceLabel = $(this).data('label');
                var segmentObj = $('.ea-second-graph-segment.is_active').length == 1 ? $('.ea-second-graph-segment.is_active') : $('.ea-second-graph-segment').first();
                performanceSegment = segmentObj.data('segment');
            }
            performanceInit();
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
        performanceInit();
    });

})();
