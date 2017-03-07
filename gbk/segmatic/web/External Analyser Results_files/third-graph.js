(function () {
    //google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    var barColor = '#49ACEF';
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Performance, %', {role: 'style'}, {role: 'annotation'}/*, {role: 'tooltip', type: 'string', 'p': {'html': true}}*/],
            ['M1', 0, barColor, '0%'],
            ['M2', 150, barColor, '150%'],
            ['M3', 230, barColor, '230%'],
            ['M4', 290, barColor, '290%'],
            ['M5', 325, barColor, '325%'],
            ['M6', 375, barColor, '375%']
        ]);
        var options = {
            width: "100%",
            height: "100%",
            bar: {groupWidth: '40%'},
            legend: {position: 'none'},
            annotations: {alwaysOutside: true},
            /*tooltip: {isHtml: true},*/
            tooltip: {trigger: 'none'},
            vAxis: {
                viewWindow: {
                    min: 0,
                    max: 500
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
        var chart = new google.visualization.ColumnChart(document.getElementById('chart-results'));
        chart.draw(data, options);

    }
    $(window).resize(function(){
        drawChart();
        console.log(this);
    });
})();

