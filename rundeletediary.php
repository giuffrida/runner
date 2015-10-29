<?
ob_start();
require_once("runner.class.php");
require_once("run.class.php");
require_once("dbcon.class.php");

$runid = $_GET['runid'];
$nick = $_GET['nick'];
$userid = $_GET['userid'];

run::runDelete($runid);

header("Location: diary.php?userid=$userid");
ob_end_flush();
?>
