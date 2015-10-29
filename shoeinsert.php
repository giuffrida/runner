<?
ob_start();

require_once("shoe.class.php");
require_once("dbcon.class.php");

$shoe = $_POST['newmodel'];
$userid = $_GET['userid'];
$nick = $_GET['nick'];
if(strlen($shoe)>0){
	shoe::shoeInsert($shoe);
}
header("Location: shoes.php?userid=$userid");
ob_end_flush();
?>
