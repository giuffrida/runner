<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Stile -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<?
		require_once('../wp-blog-header.php');
		require_once("dbcon.class.php");
		require_once("run.class.php");
		require_once("runner.class.php");
		require_once("race.class.php");
		require_once("functions.php");
	
		//get da userid userpage
		$userid = $_GET['userid'];
		$curruser = $current_user->ID;

		$runner = new runner;
		$runner = runner::usrObjUserid($userid);
		$nick = $runner->getNick();
		$wpuser = $runner->getWpid();
	
		//all races
		$allraces = array();
		$allraces = race::allRaces($userid);
?>
	</head>
	<body>
		<?
			include ("header.php");
			include ("back.php");
			if ($curruser == $wpuser and $curruser != 0){
		?>
			<div id = "raceinsert">
							<FORM method="POST" target="_parent" action="raceaddform.php?userid=<? echo $userid; ?>&nick=<? echo $nick; ?>" name="insertrace"><input type="image" src="../../images/add.png" title="Inserimento manuale gara">
							</FORM>	
			</div>
			<?
			}
			?>
			<div id="allraces" >
				<table>
					<?
					for ($i = 0; $i < count($allraces); $i++){				
						echo "<tr>";
							echo "<td>". $allraces[$i]->getName() . "</td>
									<td>" . $allraces[$i]->getDate() . "</td>
									<td>" . $allraces[$i]->getType() . "</td>
									<td>" . sec2hms($allraces[$i]->getTiming()) . "</td>";
									if ($curruser == $wpuser and $curruser != 0){
										echo "<td>
												<FORM method=\"POST\" target=\"_self\" action=\"racedelete.php?raceid=" . $allraces[$i]->getRaceid() . "&nick=" . $nick . "&userid=" . $userid . "\"name=\"delete\"><input type=\"image\" src=\"../images/trashsmall.png\" title=\"Cancella la gara\" >
												</FORM>
											</td>";
									}
						echo "<tr>";
					}
					?>
				</table>
			</div>
			<?
			include ("back.php");
			?>
	</body>
</html>
