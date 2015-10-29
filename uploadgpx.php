<?php

ob_start();
require_once("runner.class.php");
require_once("functions.php");
require_once("run.class.php");
require_once("dbcon.class.php");
date_default_timezone_set("Europe/Rome");

		//error reporting
		ini_set('display_errors', 1);
		error_reporting(E_ALL|E_STRICT);

$nick = $_GET['nick'];
$userid = $_GET['userid'];
$device = "Gpx";
$runid = "" . strtotime("now");

$new_file_name = $runid . ".gpx";
$target_path="gpxuploads/$new_file_name";
move_uploaded_file($_FILES['gpxupload']['tmp_name'], $target_path);

$xml = simplexml_load_file("gpxuploads/" . $new_file_name);
$altiarray = array();
$lonarray = array();
$latarray = array();
$originaltimearray = array();
$timearray = array();
$distarray = array();


foreach($xml->trk->trkseg->trkpt as $item){
	$altiarray[] = (string)$item->ele;
	$originaltimearray[] = (string)$item->time;
	$timearray[] = strtotime($item->time);
	$lonarray [] = (string)$item->attributes()->lon;
	$latarray [] = (string)$item->attributes()->lat;
}

//duration calculation
$duration =  ($timearray[count($timearray)-1] - $timearray[0])*1000;
for($i=0; $i<count($timearray)-1; $i++){
	$distarray[] = distance($latarray[$i], $lonarray[$i], $latarray[$i+1], $lonarray[$i+1]);
}
$distance = round(array_sum($distarray)/1000, 2);
$startime = date('Y-m-d H:i:s', strtotime($originaltimearray[0]));

run::runInsert($userid, $runid, $startime, $duration, $distance, $device);
header("Location: personalpage.php?nick=$nick");
ob_end_flush();
?> 
