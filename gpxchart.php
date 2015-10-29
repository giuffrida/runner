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
				borderColor: '#2a6969',
				borderRadius: 20
			},
			title: {
				text: '<? echo $diary; ?>   <? echo $startime; ?>'
			},
			credits: {
     					enabled: false
				},
			subtitle: {
				text: '<? echo $distance; ?> km  in <? echo sec2hms(round($duration/1000)); ?> -- Media: <? echo sec2msp(round((($duration)/1000)/($distance))); ?> -- <? echo $device; ?> -- <? echo $shoes; ?>'
			},
			legend: {
				enabled: false
			},
			exporting: {
				   	enabled: false
				   },
			xAxis: {
				type: 'linear',
				maxZoom: 0.5 //0.5km
			},
			yAxis:  { 
				type: 'linear',
				min: 2.00,
				max: 9.00,
				reversed: true,
				labels: {
					 style: {
					    color: 'black'
					 }
				 },
				 title: {
					 text: 'min/km',
					 style: {
					    color: '#2E496D'
					 }
				 },
				opposite: false
				   },
			tooltip: {
				formatter: function() {
						return this.x +'km - '+ this.y + 'm/km';
				}
			},
			plotOptions: {
				spline: {
					enableMouseTracking: true,
					color: '#2E496D',
					marker: {
						enabled: false,
					},
				},
				scatter: {
					dataLabels: {
						 enabled: true,
						formatter: function() {
							return Highcharts.numberFormat(this.y, 2);
						},
						rotation: 280,
						y: -40,
						x: -3,
						color: 'black',
					}	
				
				}
			
			},
			series: [{
				type: 'spline',
				name: 'vel2',
				lineWidth: 2,
				data:[<? echo $graphavg; ?>],
				enableMouseTracking: true
			}]
		
		});
	
	
	});
</script>
