<?php

//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
		
ob_start();

require_once("runner.class.php");
require_once("run.class.php");
require_once("functions.php");
require_once("dbcon.class.php");

$runid = $_POST['runid'];
$userid = $_POST['runner'];
$nick = $_POST['nick'];

require_once ('../code/nikeplus.php');
date_default_timezone_set("Europe/Rome");

//runner object
$runner = new runner;
$runner = runner::runnerObj($nick);

$email = $runner->getEml();
$aut = $runner->getAut();

$pwd = decrypt($aut);

$n = new NikePlusPHP($email, $pwd);
$run = $n->activity($runid);

$startime = $run->activity->startTimeUtc;
$duration = $run->activity->duration;
$distance = $run->activity->distance;
$device = "Nike";


run::runInsert($userid, $runid, $startime, $duration, $distance, $device);
run::delOld();
header("Location: personalpage.php?nick=$nick");
ob_end_flush();
?>
