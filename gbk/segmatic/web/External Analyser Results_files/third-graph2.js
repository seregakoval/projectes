(function () {
    //google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    var barColor = '#49ACEF';
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Performance, %', {role: 'style'}, {role: 'annotation'}/*, {role: 'tooltip', type: 'string', 'p': {'html': true}}*/],
            ['Previous Account', 2, barColor, '2%'],
            ['Segmatic Account', 4, barColor, '4%']
        ]);
        var data2 = google.visualization.arrayToDataTable([
            ['Month', 'Performance, %', {role: 'style'}, {role: 'annotation'}/*, {role: 'tooltip', type: 'string', 'p': {'html': true}}*/],
            ['Previous Account', 2, barColor, '1.7%'],
            ['Segmatic Account', 4, barColor, '4.1%']
        ]);
        var data3 = google.visualization.arrayToDataTable([
            ['Month', 'Performance, %', {role: 'style'}, {role: 'annotation'}/*, {role: 'tooltip', type: 'string', 'p': {'html': true}}*/],
            ['Previous Account', 64, barColor, '64%'],
            ['Segmatic Account', 46, barColor, '46%']
        ]);
        var options3 = {
            width: 1000,
            height: 400,
            bar: {groupWidth: '40%'},
            legend: {position: 'none'},
            annotations: {alwaysOutside: true},
            /*tooltip: {isHtml: true},*/
            tooltip: {trigger: 'none'},
            vAxis: {
                viewWindow: {
                    min: 0,
                    max: 100
                },
                gridlines: {
                    count: 12/*,
                     color: '#EDEDED'*/
                }/*,
                 textStyle: {
                 fontSize: 10
                 }*/
            },
        };
        var options2 = {
            width: 1000,
            height: 400,
            bar: {groupWidth: '40%'},
            legend: {position: 'none'},
            annotations: {alwaysOutside: true},
            /*tooltip: {isHtml: true},*/
            tooltip: {trigger: 'none'},
            vAxis: {
                viewWindow: {
                    min: 0,
                    max: 5
                },
                gridlines: {
                    count: 12/*,
                     color: '#EDEDED'*/
                }/*,
                 textStyle: {
                 fontSize: 10
                 }*/
            },
        };
        var options = {
            width: 1000,
            height: 400,
            bar: {groupWidth: '40%'},
            legend: {position: 'none'},
            annotations: {alwaysOutside: true},
            /*tooltip: {isHtml: true},*/
            tooltip: {trigger: 'none'},
            vAxis: {
                viewWindow: {
                    min: 0,
                    max: 4
                },
                gridlines: {
                    count: 12/*,
                     color: '#EDEDED'*/
                }/*,
                 textStyle: {
                 fontSize: 10
                 }*/
            },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart-results2'));
        var chart2 = new google.visualization.ColumnChart(document.getElementById('chart-results3'));
        var chart3 = new google.visualization.ColumnChart(document.getElementById('chart-results4'));
        chart.draw(data, options);
        chart2.draw(data2, options2);
        chart3.draw(data3, options3);
    }

})();
