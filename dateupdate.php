<?
ob_start();
date_default_timezone_set('Europe/Rome');
require_once("runner.class.php");

$userid = $_POST['runner'];
$nick = $_POST['nick'];
$firstdate0 = $_POST['dateone'];
$seconddate0 = $_POST['datetwo'];

$piecesstart = explode("/", $firstdate0);
$piecesend = explode("/", $seconddate0);

$firstdate = $piecesstart[2] . "-" . $piecesstart[1] . "-" . $piecesstart[0];
$seconddate = $piecesend[2] . "-" . $piecesend[1] . "-" . $piecesend[0];
if(strtotime($firstdate) < strtotime($seconddate) and strtotime($firstdate) > -62169987600 and strtotime($firstdate) > -62169987600){
	runner::setGraphStartDate($firstdate, $userid);
	runner::setGraphEndDate($seconddate, $userid);
}

header("Location: personalpage.php?nick=$nick");
ob_end_flush();
?>
