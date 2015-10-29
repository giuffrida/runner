<?
ob_start();
require_once("runner.class.php");
require_once("run.class.php");
require_once("dbcon.class.php");
require_once("race.class.php");


	ini_set('display_errors', 1);
	error_reporting(E_ALL|E_STRICT);

$nick = $_GET['nick'];
$raceid = $_GET['raceid'];
$userid = $_GET['userid'];

race::raceDelete($raceid);

header("Location: race.php?userid=$userid&nick=$nick");
ob_end_flush();
?>
