<?
ob_start();

require_once("runner.class.php");
require_once("run.class.php");
require_once("dbcon.class.php");

$runid = $_POST['runidmod'];
$shoes0 = $_POST['shoemod'];
$diary = $_POST['diarymod'];

if (strlen($shoes0)>0){
	$shoes = $shoes0;
}
else{
	$shoes = NULL;
}

run::runUpdate($diary, $shoes, $runid);

header("Location: rungraph.php?runid=$runid");
ob_end_flush();
?>
