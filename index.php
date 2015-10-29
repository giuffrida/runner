<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Stile -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<?
		require_once("runner.class.php");
		require_once("run.class.php");
		require_once('../wp-blog-header.php');
		
		//current user
		$curruser = $current_user->ID;
		?>
		<title> Lista runners </title>
	</head>
<body>

<div id = "principale">
	<table>
		<tr>
			<td width=75%>
				<?php
				echo "<div><h1>Link alle pagine personali</h1><div>";
				echo "<BR>";
	
				$numcols = 6;
				$numcolsprinted = 0;
				$runnersList = array();
				$runnersList = runner::runnerObjList();
	
				echo "<table>";
				foreach($runnersList as $singlerunner){
					if ($numcolsprinted == $numcols) {
						print "</tr>\n<tr>\n";
						$numcolsprinted = 0;
					}
				echo "<td><FORM method=\"POST\" target=\"_parent\" action=\"personalpage.php?nick=".$singlerunner->getNick()."\" name=\"frm2\"> <input type=\"image\" src=\"../../images/rsmall.png\" title=".$singlerunner->getNick()."></FORM>
				<a href=personalpage.php?nick=".$singlerunner->getNick()." target=\"_top\">" . $singlerunner->getNick() . "</a></TD>";
				$numcolsprinted++;
					}
				echo "</table>";
				?>
			</td>
			<td width=25%>
				<div style='color:#FFF;text-align:center;'>
					<h2 class="widgettitle">Le ultime corse</h2>			
						<div>
							<iframe height="620" src="sidebar.php">
							</iframe>
						</div>
				</div>
			</td>
		</tr>
	</table>
	</body>
</html>
