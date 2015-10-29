<?
ob_start();
require_once("runner.class.php");

$nick = $_POST['nick'];
$userid = $_POST['userid'];
$race = $_POST['race'];

$hhduration = $_POST['hh'];
$mmduration = $_POST['mm'];
$ssduration = $_POST['ss'];
$event = $_POST['event'];

$duration = (($hhduration * 3600) + ($mmduration * 60) + ($ssduration));

if($race == "5k"){
	runner::pb5kUpdate($duration, $event, $userid);
}
else if($race == "10k"){
	runner::pb10kUpdate($duration, $event, $userid);
}
else if ($race == "half"){
	runner::pbhalfUpdate($duration, $event, $userid);
}
else if($race == "marathon"){
	runner::pbmarathonUpdate($duration, $event, $userid);
}

header("Location: profile.php?userid=$userid");
ob_end_flush();
?>
