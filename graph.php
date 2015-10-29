<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Stile -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Grafici</title>
		<!-- files necessari per highcharts -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script type="text/javascript" src="../code/jquery.min.js"></script>
		<script type="text/javascript" src="../code/js/highcharts.js"></script>
		<script type="text/javascript" src="../code/js/modules/exporting.js"></script>
		<script type="text/javascript" src="../code/js/themes/grid.js"></script>
		<?
		require_once('functions.php');
		require_once('dbcon.class.php');
		require_once('run.class.php');
		require_once('runner.class.php');
		require_once('runner.class.php');
		
		$userid = $_GET["userid"];
		
		$runner = new runner;
		$runner = runner::usrObjUserid($userid);
		$nick = $runner->getNick();
		
		$resultweek = run::graphWeek($userid);
		$datasett = "";
		$sommasett = "";
		foreach ($resultweek as $event){
			$datasett .= "'" . $event['datasett'] . "', ";
			$sommasett .= $event['sommasett'] . ", ";
		}

		$resultmonth = run::graphMonth($userid);
		$datamese = "";
		$sommamese = "";
		foreach ($resultmonth as $event1){
			$datamese .= "'" . $event1['datamese'] . "', ";
			$sommamese .= $event1['sommamese'] . ", ";
		}

		$resultyear = run::graphYear($userid);
		$dataanno = "";
		$sommaanno = "";
		foreach ($resultyear as $event2){
			$dataanno .= "'" . $event2['dataanno'] . "'" . ", ";
			$sommaanno .= $event2['sommaanno'] . ", ";
		}
		?>
	</head>
	<body>
	<!-- highcharts -->
	<script type="text/javascript">

	var chart;
	$(document).ready(function() {
	   chart = new Highcharts.Chart({
		  chart: {
		     renderTo: 'containersett',
		     defaultSeriesType: 'column',
			borderColor: '#2a6969',
			borderRadius: 20		     
		  },
		  credits: {
		    enabled: false
			},
		  title: {
		     text: 'Km nelle settimane'
		  },
		  legend: {
		  	enabled: false
		  },
		  exporting: {
		  	enabled: false
		  },
		  subtitle: {},
		  xAxis: {
		     type: 'linear',
		     categories: [<? echo $datasett; ?>]
		  },
		  yAxis: {
		     min: 0,
		     title: {
		        text: 'KM'
		     }
		  },
		  tooltip: {
		     enabled: false
		  },
		  plotOptions: {
		     column: {
		        pointPadding: 0.2,
		        borderWidth: 0
		     }
		  },
		       series: [{
		     name: '',
		     data: [<? echo $sommasett; ?>],
		     dataLabels: {
					enabled: true,
					rotation: 315,
					y: -20
					}
				}
				]
	   });
	});


	var chart;
	$(document).ready(function() {
	   chart = new Highcharts.Chart({
		  chart: {
		     renderTo: 'containermese',
		     defaultSeriesType: 'column',
			 borderColor: '#2a6969',
			 borderRadius: 20
		  },
		  credits: {
		    enabled: false
			},
		  title: {
		     text: 'Km nei mesi'
		  },
		  legend: {
		  	enabled: false
		  },
		  exporting: {
		  	enabled: false
		  },
		  subtitle: {},
		  xAxis: {
		  	type: 'linear',
		     categories: [<? echo $datamese; ?>]
		  },
		  yAxis: {
		     min: 0,
		     title: {
		        text: 'KM'
		     }
		  },
		  tooltip: {
		     enabled: false
		  },
		  plotOptions: {
		     column: {
		        pointPadding: 0.2,
		        borderWidth: 0
		     }
		  },
		       series: [{
		     name: '',
		     data: [<? echo $sommamese; ?>],
		     dataLabels: {
					enabled: true,
					rotation: 315,
					y: -20
					}
				}
				]
	   });
	});


	var chart;
	$(document).ready(function() {
	   chart = new Highcharts.Chart({
		  chart: {
		     renderTo: 'containeranno',
		     defaultSeriesType: 'column',
			 borderColor: '#2a6969',
			 borderRadius: 20
		  },
		  credits: {
		    enabled: false
			},
		  title: {
		     text: 'Km negli anni'
		  },
		  legend: {
		  	enabled: false
		  },
		  exporting: {
		  	enabled: false
		  },
		  subtitle: {},
		  xAxis: {
		     categories: [<? echo $dataanno; ?>]
		  },
		  yAxis: {
		     min: 0,
		     title: {
		        text: 'KM'
		     }
		  },
		  tooltip: {
		     enabled: false
		  },
		  plotOptions: {
		     column: {
		        pointPadding: 0.2,
		        borderWidth: 0
		     }
		  },
		       series: [{
		     name: '',
		     data: [<? echo $sommaanno; ?>],
		     dataLabels: {
					enabled: true,
					rotation: 315,
					y: -20
					}
				}
				]
	   });
	});

	</script>
		<?
		include ("header.php");
		include ("back.php");
		?>
		<div id="containersett" style="width: 900px; height: 300px; margin: 0 auto"></div>
		<br>
		<div id="containermese" style="width: 900px; height: 300px; margin: 0 auto"></div>
		<br>
		<div id="containeranno" style="width: 900px; height: 300px; margin: 0 auto"></div>
		<br>
	</body>
</html> 
