<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Style -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<!-- HighCharts -->
		<script type="text/javascript" src="../code/jquery.min.js"></script>
		<script type="text/javascript" src="../code/js/highcharts.js"></script>
		<script type="text/javascript" src="../code/js/modules/exporting.js"></script>
		<script type="text/javascript" src="../code/js/themes/grid.js"></script>

 
		
		<?
		//error reporting
		//ini_set('display_errors', 1);
		//error_reporting(E_ALL|E_STRICT);
		
		// runid from personalpage
		$runid = $_GET["runid"];

		require_once('../wp-blog-header.php');
		require_once('functions.php');
		require_once('dbcon.class.php');
		require_once('run.class.php');
		require_once('runner.class.php');
		require_once('garmin.class.php');
		require_once ('../../include/config.php');
		
		$therun = new run;
		$therun = run::runObj($runid);

		$device = $therun->getDevice();
		$date = $therun->getDate();
		$duration = $therun->getDuration();
		$diaryraw = $therun->getDiary();
		$diary = addslashes($diaryraw);
		$cdiary = str_replace("\\", "", $diary);
		$distance = $therun->getDistance();
		$shoes = $therun->getShoes();
		$startime = $therun->getStartime();
		$userid = $therun->getUserid();
		$avgspeed = sec2msp(round((($duration)/1000)/($distance)));
		
		$runner = new runner;
		$runner = runner::usrObjUserid($userid);
		
		$wpuser = $runner->getWpid();
		$userid = $runner->getUserid();
		$nick = $runner->getNick();
						
		$curruser = $current_user->ID;
		
		?>
		<title>Corsa del <? echo $date; ?> di <? echo $nick; ?></title>
	</head>
	<body onload="init();">
		<?
		include ("header.php");

		if($device == 'Garmin'){
			//GARMIN
			$run = new garmin;
			$graphavg = garmin::createRawGraph($runid);
			$graphbpm = garmin::createBpmGraph($runid);
			$graphlaps = garmin::createLapsGraph($runid);

			//garmin charts
			include ('garminchart.php');
			if ($graphbpm != NULL){
				include ('garminbpm.php');
			}
			//end Garmin

		}
		elseif($device == 'Gpx'){
			//GPX
			$xml = simplexml_load_file('gpxuploads/' . $runid . '.gpx');

			$altiarray = array();
			$lonarray = array();
			$latarray = array();
			$timearray = array();
			$diffarray = array();
			$mediamkm = array();
			$distarray = array();
			$graphavg = "";

			foreach($xml->trk->trkseg->trkpt as $item){
				$altiarray[] = (string)$item->ele;
				$timearray[] = strtotime($item->time);
				$lonarray [] = (string)$item->attributes()->lon;
				$latarray [] = (string)$item->attributes()->lat;
			}
			$startlon = $lonarray[0];
			$startlat = $latarray[0];

			$graphavg = "";
			for($i=0; $i<count($timearray)-1; $i++){

				$distarray[] = distance($latarray[$i], $lonarray[$i], $latarray[$i+1], $lonarray[$i+1]);
				$distarrayo[] = array_sum(array_slice($distarray, 0 , $i));

				$mediamkm[] = sec2msp(round((($timearray[$i+1] -$timearray[$i])*1000)/(distance($latarray[$i], $lonarray[$i], $latarray[$i+1], $lonarray[$i+1])), 0));
				$graphavg .= "[" . round($distarrayo[$i]/1000, 2) . ", " . $mediamkm[$i] . "], ";
			}
			//chart da gpx
			include ('gpxchart.php');
		}
		elseif($device == 'Nike' or $device == 'nike'){
			//Nike

			require_once '../code/nikeplus.php';
			date_default_timezone_set("Europe/Rome");


			$email = $runner->getEml();
			$aut = $runner->getAut();

			$pwd = rtrim (mcrypt_ecb(MCRYPT_DES, stringmod, $aut, MCRYPT_DECRYPT), "\0");

			$n = new NikePlusPHP($email, $pwd);
			$run = $n->activity($runid);

			
			$run = $n->activity($runid);

			//kmsplits
			$times = array();
			$dur = array();
			foreach($run->activity->snapshots->KMSPLIT->datasets as $run2){
				$times []= sec2msp(($run2->pace)/1000);
				$dur []= $run2->duration;
			}

			$y = "";
			for ($i = 1; $i < count($dur); $i++){
				$y .= sec2msp(round((($dur[$i])-($dur[$i-1]))/1000)) . ", ";
			}

			$x = "";
			for ($idx = 0; $idx < count($times); $idx++){
				$x .= ($idx+1) . ", ";
			}


include('nikechart.php');

}
if ($curruser == $wpuser and $curruser != 0){
?>

<!-- modifiyng table -->
<div id="modrun">
	<form action="runedit.php" method="post">
		<table>
			<td>
				<div id = "runsummary">
					<input type="hidden" name="runidmod" value="<? echo $runid; ?>">
					<font face="arial" size=3>Distanza: <? echo $distance; ?><br>Data: <? echo $startime; ?></font>
				</div>
			</td>
			<?
			if ($curruser == $wpuser and $curruser != 0){
			?>
			<td>		
				<div id = "rundesc">
					<h3><font face="arial" size=3>Descrivi la tua corsa</h3>
					<input type="text" size="30" maxlength="255" value="<? echo $cdiary; ?>" name="diarymod">
				</div>
			</td>
			<td>
				<div id = "runshoes">
					<h3><font face="arial" size=3>Inserisci le scarpe</h3>
					<?
					$usershoes = array();
					$usershoes = runner::runnerShoes($userid);
					?>
					<select name="shoemod">
					<?
					foreach ($usershoes as $usershoe) {
						if ($shoes == $usershoe["shoe"]){
							echo "<option value=" . $usershoes . " selected>" . $shoes . "</option>";
						}
						else{
							echo "<option value=\"" . $usershoe['shoe'] . "\">" . $usershoe['shoe'] . "</option>";
						}
					}
					?>
					</select>
				</div>
			</td>
			<td>
				<div id = "runupdate">
					<input type="image" src="../images/refresh.png" title="Aggiorna"><br>
				</div>
			</td>
			<?
			}
			?>
		</table>
	</form>
</div>
<?
}
?>

<!-- end run modification -->
<!-- Lower buttons -->
<table id= "backdelete">
	<tr>
		<?
			include ("back.php");
			if ($curruser == $wpuser and $curruser != 0){
		?>
<!-- Delete run -->
		<td>
			<div id = "rundelete">
				<FORM method="POST" target="_self" action="rundelete.php?runid=<? echo $runid; ?>&nick=<? echo $nick; ?>" name="delete"><input type="image" src="../images/trash_can.png" title="Cancella la corsa" >
				</FORM>
			</div>
		</td>
<!-- End Delete run -->
		
		<?php
		include ("share.php");
		}
		?>
	</tr>
</table>


<div id="runext">
	<?php
	if($device != "Manual"){
		?>
		<div id="rungraph" ></div>
		<?php
		if ($device == "Garmin"){
		?>	
			<div id="bpmgraph"></div>
			<?php
		}
	}
	else{
	?>
		<div id="manualrun" >
			<table>
				<tr>
					<td>Corsa inserita manualmente</td>
				</tr>
			</table>
		</div>
	<?php
	}
	?>
	</div>
    <div id="right">
	<?php
	if ($device == "Garmin"){
		?>
		<iframe width='475' height='565' frameborder='0' src="http://connect.garmin.com:80/activity/embed/<? echo $runid; ?>"></iframe>
		<?php
	}
	elseif ($device == "Gpx"){
		
		?>
		<iframe width='475' height='565' frameborder='1' src="http://iocorro.it/runners/gpxmap.php?runid=<?php echo $runid; ?>&lon=<?php echo $startlon; ?>&lat=<?php echo $startlat; ?>"></iframe>
		<?php
	}
	?>
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

	</div>
</div>
</body>

</html>

