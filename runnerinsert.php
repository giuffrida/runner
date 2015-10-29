<?
ob_start();
	require_once("runner.class.php");
	$nick = $_GET["nick"];
	$id = $_GET["id"];
	
	runner::runnerInsert($id, $nick, $id);
header("Location: testwp.php");
ob_end_flush();
?>
