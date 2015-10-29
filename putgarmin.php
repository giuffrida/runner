<?
ob_start();
require_once("runner.class.php");
require_once("run.class.php");
require_once("functions.php");
require_once("dbcon.class.php");

ini_set('max_execution_time', 420);

//post da ID Garmin
	$runid = $_POST['garmin'];
	$userid = $_POST['runner'];
	$nick = $_POST['nick'];

date_default_timezone_set("Europe/Rome");
$device = "Garmin";

// recupero TCX
$tcx = simplexml_load_file("http://connect.garmin.com/proxy/activity-service-1.1/tcx/activity/$runid?full=true");

//recupera data
$startime = "";
$startime = date('Y-m-d H:i:s', strtotime($tcx->Activities->Activity->Id));//StartTime in DB

//recupero tempo totale in secondi e distanza totale
$duration = "";
$distance = "";
foreach ($tcx->Activities->Activity->Lap as $laps){
	$distance += round($laps->DistanceMeters/1000, 2);//distance in DB
	$duration +=1000*$laps->TotalTimeSeconds;//duration in DB
}

run::runInsert($userid, $runid, $startime, $duration, $distance, $device);
run::delOld();
header("Location: personalpage.php?nick=$nick");
ob_end_flush();
?>
