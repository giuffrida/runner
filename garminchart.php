		<!-- HighCharts -->
		<script type="text/javascript" src="../code/jquery.min.js"></script>
		<script type="text/javascript" src="../code/js/highcharts.js"></script>
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
									min: '<? echo $avgspeed - 2; ?>',
									max: '<? echo $avgspeed + 3,5; ?>',
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
								series: [{

									name: 'vel2',
									enableMouseTracking: false,
									marker: {
				        			enabled: false
				    			},
									lineWidth: 0.5,
									data:[<? echo $graphavg; ?>],
								},
								{
									type: 'spline',
									name: 'laps',
									enableMouseTracking: true,
									marker: {
				        			symbol: 'circle'
				    			},
									lineWidth: 3,
									inverted: false,
									color: '#C50000',
									data:[<? echo $graphlaps; ?>]
								}]		
							});
						});
			</script>
