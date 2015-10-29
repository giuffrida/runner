<?php
		require_once("runner.class.php");
		require_once("run.class.php");
		require_once("functions.php");
		
?>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
	<table>
		<tr>
			<th align="center"><FONT>Data</FONT></th>
			<th align="center"><FONT>Km</FONT></th>
			<th align="center"><FONT>Runner</FONT></th>
		</tr>
	<?php

	//last runs from all users 
	$sideruns = array();
	$sideruns = run::sideRun();
	for ($i=0; $i<20; $i++){
		echo "<tr>";
		$userid = $sideruns[$i]->getUserid();
		$runner = runner::usrObjUserid($userid);
		$nick = $runner->getNick();
		$runid = $sideruns[$i]->getRunid();
		
		echo "<td align='center'><FONT><a href=rungraph.php?runid=". $runid . " target=\"_top\">" . $sideruns[$i]->getDate() . "</font></td>";
		
		echo "<td align='center'><FONT>" . $sideruns[$i]->getDistance() . "</font></td>";
		echo "<td align='center'><FONT><a href=personalpage.php?nick=" . $nick . " target='_top'>" . $nick . "</a></font></td>";
		echo "</tr>";
	}

	?>
	</table>
</body>
