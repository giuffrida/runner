<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Scarpiera</title>
		<?php
		//get userid from userpage
		include "dbcon.class.php";
		require_once "runner.class.php";
		$userid = $_GET['userid'];

		$runner = new runner;
		$runner = runner::usrObjUserid($userid);
		$nick = $runner->getNick();
		//error reporting
		//ini_set('display_errors', 1);
		//error_reporting(E_ALL|E_STRICT);
		?>
	</head>
	<body>
		<?php
			include ('header.php');
			include ('back.php');
		?>
		<div id="shoes">
		<!-- tabella principale 3 colonne 3 righe -->
		<table id="principale" align="center" border=0>
			<!-- tabella lista scarpe in uso -->
			<td rowspan=3 align="center">
				<!-- tabella sinistra per le scarpe in uso -->
				<table width="300" valign="top" align="center" cellspacing="0" border="0">
					<tr align="center" valign="top">
						<th align="center"><FONT COLOR=black SIZE=4>Le mie scarpe</th>
						<th align="center"><FONT COLOR=black SIZE=3>Km</th>
					</tr>
					<?
					$newshoes = runner::runnerShoesSum($userid);
					foreach ($newshoes as $usingshoes){
						echo "<tr><th>" . $usingshoes["shoes"] . "</th><th>" . $usingshoes["value"] . "</th></tr>";
					}			
					?>
				</table>
			</td>
			<!-- Tabella centrale form per inserimenti -->
			<td align="center" >
				<!-- Form per l' inserimento scarpe nell' armadio -->
				<table align="center" border=0 height="50%">
					<form action="newshoe.php" method="post">
					<input type="hidden" name="userid" value="<? echo $userid; ?>">
					<input type="hidden" name="nick" value="<? echo $nick; ?>">
						<td><strong>Quali scarpe vuoi aggiungere alla tua scarpiera?</td>
						<td>
							<select name="newshoe">
							<?
							$allshoes = runner::shoesList($userid);
							foreach ($allshoes as $shoes){
								echo "<option value=\"" . $shoes["shoe"] . "\">" . $shoes["shoe"] . "</option>";
							}	
							?>
							</select>
						</td>
						<td align="center" colspan="1" rowspan="1" "><input type="Submit" value="Comincia a correrci"></td>	
					</form>
				</table>
			</td>
			<!-- Tabella destra per le scarpe vecchie -->
				<td rowspan=3 align="center">
					<table width="300" valign="top" align="center" cellspacing="0" border="0">	
						<tr align="center" valign="top">
							<th align="center"><FONT COLOR=black FACE="Geneva, Arial" SIZE=4>Vecchie scarpe</th>
							<th align="center"><FONT COLOR=black FACE="Geneva, Arial" SIZE=3>Km</th>
						</tr>
					<?
					$oldshoes = runner::runnerShoesOldSum($userid);
					foreach ($oldshoes as $usedshoes){
						echo "<tr><th>" . $usedshoes["shoes"] . "</th><th>" . $usedshoes["value"] . "</th></tr>";
					}	
					?>
					</table>
				</td>
			<tr>
				<td align="center" >
			<!-- Form centrale riga centrale per l' inserimento in scarpe pensionate -->
					<table align="center" border=0 height="50%">
						<form action="removeshoe.php" method="post">
						<input type="hidden" name="userid" value="<? echo $userid; ?>">
						<input type="hidden" name="nick" value="<? echo $nick; ?>">
							<td><strong>Pensionare scarpe</strong></td>
							<td><select name="oldshoe">
							<?
										$myshoes = runner::shoesUserList($userid);
							
										foreach ($myshoes as $shoes){
											echo "<option value=\"" . $shoes["shoe"] . "\">" . $shoes["shoe"] . "</option>";
										}	
							?>
							</td>
							<td align="center" colspan="1" rowspan="1" "><input type="Submit" value="Pensiona"></td>
							</select>
						</form>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" >
			<!-- Form centrale riga sotto per la rimozione da scarpe pensionate e reinserimento in scarpe in uso-->
					<table align="center" border=0 height="50%">
						<form action="readdshoe.php" method="post">
						<input type="hidden" name="userid" value="<? echo $userid; ?>">
						<input type="hidden" name="nick" value="<? echo $nick; ?>">
							<td><strong>Quali scarpe rimettere in azione?</strong></td>
							<td><select name="readdshoe">
							<?
								$myshoes = runner::shoesOldUserList($userid);
								foreach ($myshoes as $shoes){
									echo "<option value=\"" . $shoes["shoe"] . "\">" . $shoes["shoe"] . "</option>";
								}	
							?>
							</td>
							<td align="center" colspan="1" rowspan="1" "><input type="Submit" value="Recupera"></td>
							</select>
						</form>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div>
		<table align="center" cellspacing="30">
		   <tr>
			   <td> <font size=5>Inserisci un nuovo modello di scarpe </td>
		  </tr>
		  <tr>
			   <td><form  method="POST" action="http://<? echo $_SERVER['SERVER_NAME']; ?>/runners/shoeinsert.php?userid=<? echo $userid; ?>&nick=<? echo $nick; ?>">Scarpa: <input type="text" name="newmodel" /><input type="submit" /></td>
		   </tr>
		</table>
	</div>

	</body>
</html>		



