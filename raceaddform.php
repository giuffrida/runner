<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Stile -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<?
		require_once("functions.php");
		require_once("runner.class.php");
		$userid = $_GET['userid'];

		$runner = new runner;
		$runner = runner::usrObjUserid($userid);
		$nick = $runner->getNick();


?>
	</head>
	<body>
		<?php
			include ("header.php");
			include ("back.php");
		?>
		<div id="putmanual">
			<table align="center" cellspacing="10">
				<tr>	
					<form name="user" action="raceinsert.php" method="post">
						<input type="hidden"name="nick" value="<? echo $nick; ?>">
						<input type="hidden"name="userid" value="<? echo $userid; ?>">
						<tr>
							<td align="center">	Data:  
								<?
									ShowFromDate(4,"Both");
								?>
							</td>
						</tr>
						<tr>
							<td align="center">Tempo ( 
								hh: <input type="text" name="hh" size="2"/>
								mm: <input type="text" name="mm" size="2"/>
								ss: <input type="text" name="ss" size="2"/>
							)
							</td>
						<tr/>
						<tr>
							<td align="center">Gara: <input type="text" name="event" size="30"/>
							</td>
						<tr/>
						<tr>
							<td align="center">Tipo di gara: <input type="text" name="type" size="15"/>
							</td>
						<br/>
						<tr/>
						<tr>
							<td align="center"><input type="submit" value="Inserisci gara"/>
							</td>
						<tr/>
					</form>
				</tr>
			</table>
		</div>
	</body>
</html>
