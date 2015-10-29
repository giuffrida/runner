<?
ob_start();
require_once("race.class.php");
require_once("dbcon.class.php");

ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);

date_default_timezone_set("Europe/Rome");

$nick = $_POST['nick'];
$userid = $_POST['userid'];

$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];
$date = "$year-$month-$day 00:00:00";

$hhduration = $_POST['hh'];
$mmduration = $_POST['mm'];
$ssduration = $_POST['ss'];
$timing = ($hhduration * 3600) + ($mmduration * 60) + ($ssduration);

$type = $_POST['type'];
$event = $_POST['event'];

race::raceInsert($userid, $date, $type, $event, $timing);

header("Location: race.php?userid=$userid&nick=$nick");
ob_end_flush();
?>
