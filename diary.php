<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Style -->
		<link rel="stylesheet" type="text/css" href="style.css">
<?
	//get userid from personalpage
	$userid = $_GET['userid'];

	require_once('../wp-blog-header.php');
	require_once('dbcon.class.php');
	require_once('run.class.php');
	require_once('runner.class.php');
	$curruser = $current_user->ID;
			
	$runner = new runner;
	$runner = runner::usrObjUserid($userid);
	
	$wpuser = $runner->getWpid();
	$nick = $runner->getNick();
	
	//all runs
	$allruns = array();
	$allruns = run::allRunsObj($userid);
	
	// error reporting
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL|E_STRICT);
?>
	</head>
	<body>
		<?
			include ("header.php");
			include ("back.php");
		?>
			<div id="allruns" >
				<table>
					<?
					for ($i = 0; $i < count($allruns); $i++){				
						echo "<tr>";
							echo "<td><a href=rungraph.php?runid=". $allruns[$i]->getRunid() . ">" . $allruns[$i]->getStartime() . "</td>
									<td>" . $allruns[$i]->getDistance() . " Km</td>
									<td>" . $allruns[$i]->getDiary() . "</td>
									<td>" . $allruns[$i]->getShoes() . "</td>";
									if ($curruser == $wpuser and $curruser != 0){
										echo "<td>
												<FORM method=\"POST\" target=\"_self\" action=\"rundeletediary.php?runid=" . $allruns[$i]->getRunid() . "&nick=" . $nick . "&userid=" . $userid . "\"name=\"delete\"><input type=\"image\" src=\"../images/trashsmall.png\" title=\"Cancella la corsa\" >
												</FORM>
											</td>";
									}
						echo "<tr>";
					}
					?>
				</table>
			</div>
	</body>
</html>
