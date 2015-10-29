<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
		//nick from index
		$nick = $_GET["nick"];
?>
		<title> <?php echo $nick; ?> </title>
<?php
		//variabili per data
		$curmonth = date("m");
		$curyear = date("Y");
		
		//includes
		require_once("../wp-load.php");
		require_once("runner.class.php");
		require_once("run.class.php");
		require_once("functions.php");
		
		//current user
		$curruser = $current_user->ID;

		//runner object
		$runner = new runner;
		$runner = runner::runnerObj($nick);

		//userid from object
		$userid = $runner->getUserid();
		
		//wpuser from object
		$wpuser = $runner->getWpid();
		
		//user graph dates from object
		$startdate = $runner->getGraphStartDate();
		$enddate = $runner->getGraphEndDate();

		//runner totals
		$tot = runner::runnerTot($userid);

		//last ten runs
		$lastruns = array();
		$lastruns = run::tenrunObj($userid);
		
		//runs for chart
		$graphruns = array();
		$graphruns = run::graphRuns($userid, $startdate, $enddate);
		
		//scatter chart cvariable
		$avgscat = "";
		for ($i = 0; $i < count($graphruns); $i++){				
			$avgscat .= "[". $graphruns[$i]->getDistance() . ", " . ($graphruns[$i]->getDuration())/($graphruns[$i]->getDistance()) . "], ";
		}
		
		//error reporting
		//ini_set('display_errors', 1);
		//error_reporting(E_ALL|E_STRICT);
?>
		<!-- Style -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<!-- Script Jquery e Highcharts  -->
		<script type="text/javascript" src="../code/jquery.min.js"></script>
		<script type="text/javascript" src="../code/js/highcharts.js"></script>
		<script type="text/javascript" src="../code/js/highcharts-more.js"></script>
		<script type="text/javascript" src="../code/js/themes/grid.js"></script>
		<link rel="stylesheet" href="../code/jquery/jquery-ui.min.css">
		<script src="../code/jquery/jquery-1.11.2.js"></script>
		<script src="../code/jquery/jquery-ui.js"></script>
		<script>
			$(function(){
				$( "#dateone,#datetwo" ).datepicker();
			});
		</script>

	</head>
	<body onLoad="javascript:showMonth(<?php echo $curmonth ?>, <?php echo $curyear ?>, <?php echo $userid ?>)">
		<?php
		include ("header.php");
		?>
		<div  id="mainprofile">
			<table>
				<tr>
					<td colspan="2"><?echo $runner->getProfile() ;?></td>
				</tr>
				<tr>
					<td colspan="2"><?echo $tot['conto'] . " corse per " . $tot['somma'] . "km";?></td>
				</tr>
				<tr>
					<td><?php echo "PB 5K: " . sec2hms($runner->getPb5k()) ;?>
					<td><?php echo "PB Mezza Maratona: " . sec2hms($runner->getPbhalf()) ;?>
				</tr>
				<tr>
					<td><?php echo "PB 10K: " . sec2hms($runner->getPb10k()) ;?>
					<td><?php echo "PB Maratona: " . sec2hms($runner->getPbmarathon()) ;?>
				</tr>
			</table>
		</div id="mainprofile">
		<?php
		include ("oldpage.php");
		?>
		
		<!-- chart script -->
		<script type="text/javascript">
			var chart0;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'avg',
						type: 'scatter',
						borderColor: '#2a6969',
						borderRadius: 20
					},
					title: {
						text: 'Media e Distanza nell intervallo'
					},
					yAxis: {
					type: 'datetime',
						dateTimeLabelFormats: { //force all formats to be minute:second
							second: '%M:%S',
							minute: '%M:%S',
							hour: '%M:%S',
							day: '%M:%S',
							week: '%M:%S',
							month: '%M:%S',
							year: '%M:%S'
						},
						reversed: true,
						title: {
						 text: 'min/km',
					 },
					 xAxis: {
						categories: ['KM']
					 }
					},
					tooltip: {
						formatter: function() {
							return this.x +'km - '+ Math.floor((this.y/1000)/60) + ':' + Math.floor((this.y/1000)%60) + ' m/km';
						}
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
					series: [{
						data: [<? echo $avgscat; ?>]
					}]
				});
			});				
		</script>
		<!-- end chart script -->
		<table id="extcal">
			<tr>
				<td><div id="avg"></div id="avg"></td>
				<td><div id="calendar"></div id="calendar"><td>
				
			</tr>
			<tr>
				<td>
					<form action="dateupdate.php" method="post" >
						<input type="hidden" name="runner" id="runner" value="<?php echo $userid; ?>">
						<input type="hidden" name="nick" id="nick" value="<?php echo $nick; ?>">
						Da: <input type="text" id="dateone" value="<?php echo date("d/m/y", strtotime($startdate)); ?>" name="dateone">A: <input type="text" id="datetwo" value="<?php echo date("d/m/y", strtotime($enddate)); ?>" name="datetwo">
						<input type="submit" id="submit" value="scegli">
					</form>
				</td>
			</tr>
		</table id="extcal">
		<div id="runslist">
			<table>
				<?php
				for ($i = 0; $i < 10; $i++){
					if (isset($lastruns[$i])){
						echo "<tr>";
							echo "<td><a href=rungraph.php?runid=". $lastruns[$i]->getRunid() . " target=\"_top\">" . $lastruns[$i]->getStartime() . "</td><td>" . $lastruns[$i]->getDistance() . " Km</td><td>" . str_replace("\\", "", $lastruns[$i]->getDiary()) . "</td><td>" . $lastruns[$i]->getShoes() . "</td>";
						echo "<tr>";
					}
				}
				?>
			</table>
		</div id="runslist">
		<!-- Insert run-->
		<?php
		if ($curruser == $wpuser or $curruser == 1 and $curruser != 0){
		?>
		<div id="putrun" >
				<table align="center" cellspacing="1" cellpadding="10" style="border-spacing: 12px;">
				<tr>
					<td width="33%">
						<form action="putgarmin.php" method="post">
							<font FACE="Geneva, Arial" SIZE=2 color="black">Garmin ID: </font>
							<input type="text" size="10" maxlength="20" name="garmin">
							<input type="hidden" name="runner" id="runner" value="<?php echo $userid; ?>">
							<input type="hidden" name="nick" id="nick" value="<?php echo $nick; ?>">
							<input type="image" src="../../images/Garminnew.png" style="vertical-align:middle"; title="Carica corsa da Garmin">
						</form>				
					</td>
					<?php
					if ($runner->getEml() != NULL){
					?>
						<td width="25%">
							<form action="putnike.php" method="post">
								<font FACE="Geneva, Arial" SIZE=2 color="black">Nike RunID: </font>
								<input type="text" size="10" maxlength="40" name="runid" id = "runid">
								<input type="hidden" name="runner" id="runner" value="<?php echo $userid; ?>">
								<input type="hidden" name="nick" id="nick" value="<?php echo $nick; ?>">
								<input type="image" src="../../images/nikenew.png" style="vertical-align:middle"; title="Carica corsa da Nike">
							</form>
						</td>
						<td  align="left" width="14%">
							<form method="post" action="resetnike.php">
								<input type="image" src="../../images/refresh.png" name="nikereset" value="<?php echo $userid; ?>" title="Reset delle credenziali Nike" >
								<input type="hidden"name="nick" value="<?php echo $nick; ?>">
								<input type="hidden"name="userid" value="<?php echo $userid; ?>">
							</form>						
						</td>
					<?php
					}
					else{
					?>
						<td>
							<a align="center"><font FACE="Geneva, Arial" SIZE=2>Inserisci le credenziali Nike</FONT></a>
						</td>
						<td>	
							<form action="addnikeuser.php" method="post">
								<font FACE="Geneva, Arial" SIZE=2>Login: </font><input type="text" size="10" maxlength="40" name="nikeeml">
								<br>
								<font FACE="Geneva, Arial" SIZE=2>Password: </font><input type="password" size="10" maxlength="40" name="nikepwd">
								<br>
								<input type="hidden"name="nick" value="<?php echo $nick; ?>">
								<input type="hidden"name="userid" value="<?php echo $userid; ?>">
								<input type="submit" value="Connetti Nike">
							</form>
						</td>
					<?php
					}
					?>
						<td>
							<form method="post" action="uploadgpx.php?userid=<?php echo $userid; ?>&nick=<?php echo $nick; ?>" name="gpx" enctype="multipart/form-data">
								Seleziona il file gpx:
								<input type="file" name="gpxupload" id="gpxupload">
								<input type="submit" value="Upload GPX" name="submit">
							</form>
						</td>
						<td width="33%">
							<form method="POST" target="_parent" action="putmanualform.php?userid=<?php echo $userid; ?>&nick=<?php echo $nick; ?>" name="manual"><input type="image" src="../../images/add.png" title="Inserimento manuale">
							</form>						
						</td>
					</tr>
				</table>
			</div id="putrun">
			<?php
			}
			
			?>			
			<div id = "functions">
				<table align="center" cellspacing="1" cellpadding="10" style="border-spacing: 12px;">
					<TR>
						<TD>
							<FORM method="POST" target="_parent" action="graph.php?userid=<?php echo $userid; ?>" name="frm2"> <input type="image" src="../../images/barchart.png" title="Statistiche"></FORM>
						</TD>
						<TD>
							<FORM method="POST" target="_parent" action="race.php?userid=<?php echo $userid; ?>" name="race"><input type="image" src="../../images/MedalBlue.png" title="Gare">
							</FORM>
						</TD>
						<TD>
							<FORM method="POST" target="_parent" action="diary.php?userid=<?php echo $userid; ?>" name="diario"><input type="image" src="../../images/book.png" title="Diario">
							</FORM>
						</TD>
						<?
						if ($curruser == $wpuser and $curruser != 0){
						?>
						<TD>
							<FORM method="POST" target="_parent" action="profile.php?userid=<?php echo $userid; ?>" name="profilo personale"><input type="image" src="../../images/profile.png" title="Profile">
							</FORM>
						</TD>
						<TD>
							<FORM method="POST" target="_parent" action="shoes.php?userid=<?php echo $userid; ?>" name="scarpe"><input type="image" src="../../images/RunningShoes.png" title="Scarpiera" >
							</FORM>
						</TD>
						<TD>
							<FORM method="POST" target="_parent" action="runsync.php?userid=<?php echo $userid; ?>&nick=<?php echo $nick; ?>" name="runsync"><input type="image" src="../../images/refresh.png" title="Sincronizzazione corse" >
							</FORM>
						</TD>
						<?
						}
						?>
					</TR>
				</table>
			</div id="functions">
<!-- fine inserimenti corse -->
<!-- DISQUS -->
    <div id="disqus_thread"></div>
		<script type="text/javascript">
		    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		    var disqus_shortname = 'runnerplus'; // required: replace example with your forum shortname

		    /* * * DON'T EDIT BELOW THIS LINE * * */
		    (function() {
		        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		    })();
		</script>
    	<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<!-- Fine DISQUS -->
	</body>
</html>
