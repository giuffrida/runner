<?
ob_start();
require_once("runner.class.php");
require_once("run.class.php");
require_once("functions.php");
require_once("dbcon.class.php");

$nick = $_POST['nick'];
$userid = $_POST['userid'];
date_default_timezone_set("Europe/Rome");
$device = "Manual";
$runid = date("Ymdhis");

$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];
$hh = $_POST['datehour'];
$mm = $_POST['dateminutes'];
$ss = $_POST['dateseconds'];
$startime = "$year-$month-$day $hh:$mm:$ss";

$hhduration = $_POST['hh'];
$mmduration = $_POST['mm'];
$ssduration = $_POST['ss'];
$duration = ($hhduration * 3600) + ($mmduration * 60) + ($ssduration);

$distance = $_POST['distance'];

run::runInsert($userid, $runid, $startime, $duration, $distance, $device);
run::delOld();
header("Location: personalpage.php?nick=$nick");
ob_end_flush();
?>
