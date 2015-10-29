<?
ob_start();
require_once("runner.class.php");
require_once("dbcon.class.php");

$userid = $_POST['userid'];
$nick = $_POST['nick'];
$newshoe = $_POST['newshoe'];
//echo $userid . " " . $nick . " " . $newshoe;
runner::addShoe ($newshoe, $userid);

header("Location: shoes.php?userid=$userid&nick=$nick");
ob_end_flush();
?>
