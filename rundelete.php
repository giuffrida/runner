<?
ob_start();
require_once("runner.class.php");
require_once("run.class.php");
require_once("dbcon.class.php");

$runid = $_GET['runid'];
$nick = $_GET['nick'];

run::runDelete($runid);

header("Location: personalpage.php?nick=$nick");
ob_end_flush();
?>
