<?
ob_start();

	include "functions.php";
	include "dbcon.class.php";
	include "run.class.php";
	include "runner.class.php";
	include "../../include/.conn.php";

	$userid = $_GET["userid"];
	$nick = $_GET["nick"];

	$con = mysql_connect($dbhost, $dblogin, $dbpass);
if (!$con){
  die('Could not connect: ' . mysql_error());
}
mysql_select_db($db, $con);

mysql_query("INSERT IGNORE INTO `runnerpl_newruns`.`runs`(`userid`,`runid`,`startime`, `duration`,`distance`,`shoes`,`diary`,`device`,`swimnote`,`bikenote`)
SELECT `runs`.`userId`, `runs`.`runid`, `runs`.`startTime`, `runs`.`duration`, `runs`.`distance`, `runs`.`scarpe`, `runs`.`diario`, `runs`.`device`, `runs`.`swimnote`,`runs`.`bikenote` FROM `runs` WHERE userid = $userid");

header("Location: personalpage.php?nick=$nick");
ob_end_flush();

?>
