<?
ob_start();

require_once("runner.class.php");

$profile = $_POST['profile'];
$userid = $_POST['userid'];
$nick = $_POST['nick'];

runner::profileUpdate($profile, $userid);

header("Location: profile.php?userid=$userid");
ob_end_flush();
?>
