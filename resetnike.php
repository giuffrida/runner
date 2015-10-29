<?
ob_start();

require_once("runner.class.php");
require_once("dbcon.class.php");

$userid = $_POST["userid"];
$nick = $_POST["nick"];

runner::nikeReset ($userid);

header("Location: personalpage.php?nick=$nick");
ob_end_flush();
?>