<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Stile -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<?
		require_once("functions.php");
		$userid = $_GET['userid'];
		$nick = $_GET['nick'];
		?>
	</head>
	<body>
		<?
			include ("header.php");
		?>
		<div id="putmanual">
			<table align="center" cellspacing="10">
				<tr>	
					<form name="user" action="putmanual.php" method="post">
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
							<td align="center">Ora: hh<input type="text" name="datehour" size="2"/>
												mm<input type="text" name="dateminutes" size="2"/>
												ss<input type="text" name="dateseconds" size="2"/>
							</td>
						<tr/>
						<tr>
							<td align="center">Durata: hh <input type="text" name="hh" size="2"/>
												mm<input type="text" name="mm" size="2"/>
												ss<input type="text" name="ss" size="2"/>
							</td>
						<tr/>
						<tr>
							<td align="center">Distanza km - esempio: 10.25 : <input type="text" name="distance" size="5"/>
							</td>
						<br/>
						<tr/>
						<tr>
							<td align="center"><input type="submit" value="Inserisci corsa"/>
							</td>
						<tr/>
					</form>
				</tr>
			</table>
		</div>
		<?
			include ("back.php");
		?>
	</body>
</html>
