		<!-- HighCharts -->
		<script type="text/javascript" src="../code/jquery.min.js"></script>
		<script type="text/javascript" src="../code/js/highcharts.js"></script>
		<script type="text/javascript" src="../code/js/modules/exporting.js"></script>
		<script type="text/javascript" src="../code/js/themes/grid.js"></script>
		
					<!-- Grafico bpm -->	
<script type="text/javascript">
			var chart1;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'bpmgraph',
						marginBottom: 20,
						borderColor: '#2a6969',
						borderRadius: 20						
					},
					credits: {
        					enabled: false
    					},
    					title: {
						text: '' //titolo
					},
					subtitle: {
						text: ''
					},
					legend: {
						enabled: false
					},
					exporting: {
					      	enabled: false
					      },
					xAxis: {
						type: 'linear'
					},
					yAxis:  {
						type: 'linear',
						min: 60,
						max: 210,
						reversed: false,
						labels: {
						    style: {
						       color: 'red'
						    }
						 },
						 title: {
						    text: 'bpm',
						    style: {
						       color: 'red'
						    }
						 },
						opposite: false
					      },
					tooltip: {
						formatter: function() {
								return this.x +'km - '+ this.y + 'bpm';
						}
					},
					plotOptions: {
						spline: {
							enableMouseTracking: true,
							marker: {
								enabled: false
			                }
			            }
			        },
					series: [{
						type: 'spline',
						name: 'bpm',
						lineWidth: 4,
						color: 'red',
						data:[<? echo $graphbpm; ?>],
						enableMouseTracking: true
					}]				
				});				
			});
		</script>
