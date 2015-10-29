<?
ob_start();
require_once("runner.class.php");
require_once("dbcon.class.php");

ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);

$userid = $_POST['userid'];
$nick = $_POST['nick'];
$newshoe = $_POST['oldshoe'];
echo $userid . " " . $nick . " " . $newshoe;
runner::removeShoe ($newshoe, $userid);

header("Location: shoes.php?userid=$userid&nick=$nick");
ob_end_flush();
?>
