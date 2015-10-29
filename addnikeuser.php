<?
ob_start();

require_once("runner.class.php");
require_once("dbcon.class.php");
require_once("functions.php");
require_once ("../../include/config.php");

$nikeeml = $_POST["nikeeml"];
$nikepwd = $_POST["nikepwd"];
$nick = $_POST["nick"];
$userid = $_POST["userid"];

$npwd = encrypt($nikepwd);
runner::pwdUpdate ($nikeeml, $npwd, $userid);

header("Location: personalpage.php?nick=$nick");
ob_end_flush();
?>
