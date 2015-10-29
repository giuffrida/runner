<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Stile -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Calendario personale</title>
	</head>
<?php

	//file inclusi
include "dbcon.class.php";

require_once("run.class.php");
require_once("functions.php");


$mese = $_GET["m"];
$anno = $_GET["y"];
$userid= $_GET["userid"];

	ini_set('display_errors', 1);
	error_reporting(E_ALL|E_STRICT);

?>
<body>
<?
$currDayTS = mktime(0,0,0,$mese,1,$anno);
$currDay = date_create(date("Y-m-d",$currDayTS)); 
$meseSucc = ($mese +1);
if($meseSucc>12) $meseSucc = 1;
$mesePrec = ($mese -1) % 12;
$annoSucc = $anno;
$annoPrec = $anno;
$meseStr = "";

switch($mese)
{
	case 1:
	$annoPrec = $anno-1;
	$mesePrec = 12;	
	$meseStr = "GENNAIO";
	break;
	case 2:
	$meseStr = "FEBBRAIO";
	break;
	case 3:
	$meseStr = "MARZO";
	break;
	case 4:
	$meseStr = "APRILE";
	break;
	case 5:
	$meseStr = "MAGGIO";
	break;
	case 6:
	$meseStr = "GIUGNO";
	break;
	case 7:
	$meseStr = "LUGLIO";
	break;
	case 8:
	$meseStr = "AGOSTO";
	break;
	case 9:
	$meseStr = "SETTEMBRE";
	break;
	case 10:
	$meseStr = "OTTOBRE";
	break;
	case 11:
	$meseStr = "NOVEMBRE";
	break;
	case 12:
	$annoSucc = $anno + 1;
	$meseStr = "DICEMBRE";
	break;

}

echo "<table class=\"calendario1\"  style=\"width:100%;height:300px\">";
echo "<tr><th  class=\"calendario1\" align=\"left\"  ><a class=\"calendario1\" href='#' onclick=\"showMonth(" . $mese ." , " .  ($anno-1) . " , '" . $userid . "')\">&lt;&lt;</a></th><th  class=\"calendario1\"><a class=\"calendario1\" href=\"#\" onclick=\"showMonth(" . $mesePrec ." , " .  $annoPrec . " , '" . $userid ."')\">&lt;</a></th><th  class=\"calendario1\"  colspan=\"4\" align=\"center\">";

echo $meseStr . " " . date_format($currDay,'Y') . "</th><th  class=\"calendario1\" align=\"right\" ><a class=\"calendario1\" href=\"#\" onclick=\"showMonth(" . $meseSucc ." , " .  $annoSucc . " , '" . $userid . "')\">&gt;</a></th><th  class=\"calendario1\"><a class=\"calendario1\" href=\"#\" onclick=\"showMonth(" . $mese ." , " .  ($anno+1) . " , '" . $userid . "')\">&gt;&gt;</a></th></tr>";

echo "<tr><th  class=\"calendario1\"  style=\"width:30px\">LU</th><th  class=\"calendario1\" style=\"width:30px\">MA</th><th  class=\"calendario1\" style=\"width:30px\">ME</th><th  class=\"calendario1\" style=\"width:30px\">GI</th><th  class=\"calendario1\" style=\"width:30px\">VE</th><th  class=\"calendario1\" style=\"width:30px\">SA</th><th  class=\"calendario1\" style=\"width:30px\">DO</th><th  class=\"calendario1\" style=\"width:30px\">&nbsp;</th></tr>";
$totkm = 0.0;
$weekkm = 0.0;
$totrows = 0.0;

for($i=1; $i<=31; $i++)
{
  $corseMese[$i] = 0;
}
//lista corse nel mese
$monthsrun = run::runnerMonth($userid, $mese, $anno);

foreach($monthsrun as $output){
	$corseMese[$output["GIORNO"]] = $output["KM"];
	$totkm += $output["KM"];
}

$newmm = date_format($currDay,"n");
$newyy = date_format($currDay,"Y");
$loopctrl = 0;


while((date_format($currDay,"n") == $mese) && ($loopctrl <= 31))
{
	$loopctrl += 1;
	$gg = date_format($currDay,"j");
	if(date_format($currDay,"D") == "Mon") echo "<tr>";
	if($gg == 1)
	{
		switch(date_format($currDay,"D"))
		{
			case "Sun": echo "<tr><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td>";
			break;
			case "Mon":
			break;
			case "Tue": echo "<tr><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td>";
			break;
			case "Wed": echo "<tr><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td>";
			break;
			case "Thu": echo "<tr><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td>";
			break;
			case "Fri": echo "<tr><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td>";
			break;
			case "Sat": echo "<tr><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td><td  class=\"calendarioOld\" style=\"width:30px\">&nbsp;</td>";
			break;
		}
	}
	echo "<td  class=\"calendario\" > <span style=\"font-size:8px;\">" . $gg . "</span><br/>";
	if($corseMese[$gg]>0)
	{
		echo "<div style=\"text-align:right;width:95%;font-weight:bold;color:black;\">" . $corseMese[$gg] . "</b>";
		$weekkm += $corseMese[$gg];
	}
	else
		echo "&nbsp;";
	echo "</td>";
	if(date_format($currDay,"D") == "Sun")
	{
		echo "<th  class=\"calendario\" ><span style=\"font-size:8px;\">TOT</span><br/>" . round($weekkm, 1) . "</th></tr>";
		$weekkm = 0.0;
		$totrows = $totrows + 1;
	}
  // add a day

  $newgg = $gg+1;
  if($newmm == 2) //feb
  {
  	$num = cal_days_in_month(CAL_GREGORIAN, 2, $newyy);
  	if($gg == 28 && $num==28)
		{
			$newgg = 1;
			$newmm = $newmm + 1;
		}
 		if($gg>28)
		{
			$newgg = 1;
			$newmm = $newmm + 1;
		}
  }
  else if($gg==30 && ($newmm==11 || $newmm==4 || $newmm==6 || $newmm==9))
  {
			$newgg = 1;
			$newmm = $newmm + 1;
  }
  else if($gg>30)
  {
			$newgg = 1;
			$newmm = $newmm + 1;
  }

  $currDay = date_create(date("Y-m-d",mktime(0,0,0,$newmm,$newgg,$newyy)));

  //date_add($currDay, date_interval_create_from_date_string('1 days'));
}

	switch(date_format($currDay,"D"))
	{
		case "Sun": echo "<td class=\"calendarioOld\" >&nbsp;</td><th  class=\"calendario\" ><span style=\"font-size:8px;\">TOT</span><br/>" . $weekkm ."</th></tr>";
		break;
		case "Mon":
		 echo "</tr>";
		break;
		case "Tue": echo "<td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><th class=\"calendario\"><span style=\"font-size:8px;\">TOT</span><br/>" . $weekkm ."</th></tr>";
		break;
		case "Wed": echo "<td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><th class=\"calendario\"><span style=\"font-size:8px;\">TOT</span><br/>" . $weekkm ."</th></tr>";
		break;
		case "Thu": echo "<td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><th class=\"calendario\"><span style=\"font-size:8px;\">TOT</span><br/>" . $weekkm ."</th></tr>";
		break;
		case "Fri": echo "<td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><th class=\"calendario\"><span style=\"font-size:8px;\">TOT</span><br/>" . $weekkm ."</th></tr>";
		break;
		case "Sat": echo "<td class=\"calendarioOld\">&nbsp;</td><td class=\"calendarioOld\">&nbsp;</td><th class=\"calendario\"><span style=\"font-size:8px;\">TOT</span><br/>" .$weekkm ."</th></tr>";
		break;
	}

echo "<tr><th  class=\"calendario\" align=\"center\" colspan='8'><b>TOT " . $totkm  ."</b></th></tr>";
echo "</table>";

?>

</body>
</html> 
