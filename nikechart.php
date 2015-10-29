<!-- HighCharts -->
<script type="text/javascript" src="../code/jquery.min.js"></script>
<script type="text/javascript" src="../code/js/highcharts.js"></script>
<script type="text/javascript" src="../code/js/modules/exporting.js"></script>
<script type="text/javascript" src="../code/js/themes/grid.js"></script>

	
<script type="text/javascript">
	var chart0;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
    	    chart: {
				renderTo: 'rungraph',
            	type: 'spline',
				borderColor: '#2a6969',
				borderRadius: 20            	
        },
        title: {
            text:  '<? echo $diary; ?>   <? echo $startime; ?>'
        },
        subtitle: {
            text: '<? echo $distance; ?> km  in <? echo sec2hms(round($duration/1000)); ?> -- Media:<? echo sec2msp(round((($duration)/1000)/($distance))); ?> -- <? echo $device; ?> -- <? echo $shoes; ?>' 
        },
			credits: {
				enabled: false
			},
			legend: {
				enabled: false
			},
			exporting: {
		   	enabled: false
		   },
        xAxis: {
            categories: [<? echo $x; ?>]
        },
        yAxis: {
            title: {
                text: 'm/km'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            },
				reversed: true
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'm/km',
            marker: {
                symbol: 'square'
            },
            data: [<? echo $y; ?>]

        }]
    });
});
</script>
