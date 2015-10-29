<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Style -->
		<link rel="stylesheet" type="text/css" href="style.css">
<?
		$userid = $_GET['userid'];

		include ('runner.class.php');
		include ('functions.php');

		$runner = new runner;
		$runner = runner::usrObjUserid($userid);
		$nick = $runner->getNick();
		$profile = $runner->getProfile();
		$pb5k = explode(":", sec2hms($runner->getPb5k()));
		$pb10k = explode(":", sec2hms($runner->getPb10k()));
		$pbhalf = explode(":", sec2hms($runner->getPbhalf()));
		$pbmarathon = explode(":", sec2hms($runner->getPbmarathon()));
		
?>
	</head>
	<body>
	<?
		include ("header.php");
	?>
		<div id="pbeprofile">	
			<table id="profile">
				<tr>
					<form action="profileupdate.php" method="post">
						<input type="hidden" name="userid" value="<? echo $userid; ?>">
						<input type="hidden" name="nick" value="<? echo $nick; ?>">
						<th><font face="arial" size=3>Descriviti in poche parole</th>
						<th colspan= "4"><input type="text" size="70" maxlength="300" value="<? echo $profile; ?>" name="profile"></th>
						<th><input type="submit" value="Aggiorna"></th>
					</form>
				</tr>
				<tr>
					<form action="pbupdate.php" method="post">
						<th>Inserisci il tuo PB sui 5k </th>
						<input type="hidden" name="userid" value="<? echo $userid; ?>">
						<input type="hidden" name="nick" value="<? echo $nick; ?>">
						<input type="hidden" name="race" value="5k">       
						<th>hh <input type="text" name="hh" size="2" value="<? echo $pb5k[0]; ?>"/></th>
						<th>mm<input type="text" name="mm" size="2" value="<? echo $pb5k[1]; ?>"/></th>
						<th>ss<input type="text" name="ss" size="2" value="<? echo $pb5k[2]; ?>"/></th>
						<th>gara<input type="text" name="event" size="30" value="<? echo $runner->getPb5kevent(); ?>"/></th>
						<th><input type="submit" value="Aggiorna"></th>
					</form>
				</tr>
				<br>
				<tr>
					<form action="pbupdate.php" method="post">
						<th>Inserisci il tuo PB sui 10k </th>
						<input type="hidden" name="userid" value="<? echo $userid; ?>">
						<input type="hidden" name="nick" value="<? echo $nick; ?>">
						<input type="hidden" name="race" value="10k">       
						<th>hh <input type="text" name="hh" size="2" value="<? echo $pb10k[0]; ?>"/></th>
						<th>mm<input type="text" name="mm" size="2" value="<? echo $pb10k[1]; ?>"/></th>
						<th>ss<input type="text" name="ss" size="2" value="<? echo $pb10k[2]; ?>"/></th>
						<th>gara<input type="text" name="event" size="30" value="<? echo $runner->getPb10kevent(); ?>"/></th>
						<th><input type="submit" value="Aggiorna"></th>
					</form>
				</tr>
				<tr>
					<form action="pbupdate.php" method="post">
						<th>Inserisci il tuo PB sulla mezza maratona</th>
						<input type="hidden" name="userid" value="<? echo $userid; ?>">
						<input type="hidden" name="nick" value="<? echo $nick; ?>">
						<input type="hidden" name="race" value="half">			
						<th>hh <input type="text" name="hh" size="2" value="<? echo $pbhalf[0]; ?>"/></th>
						<th>mm<input type="text" name="mm" size="2" value="<? echo $pbhalf[1]; ?>"/></th>
						<th>ss<input type="text" name="ss" size="2" value="<? echo $pbhalf[2]; ?>"/></th>
						<th>gara<input type="text" name="event" size="30" value="<? echo $runner->getPbhalfevent(); ?>"/></th>
						<th><input type="submit" value="Aggiorna"></th>
					</form>					
				</tr>
				<tr>
					<form action="pbupdate.php" method="post">
						<th>Inserisci il tuo PB in Maratona</th>
						<input type="hidden" name="userid" value="<? echo $userid; ?>">
						<input type="hidden" name="nick" value="<? echo $nick; ?>">
						<input type="hidden" name="race" value="marathon">					
						<th>hh <input type="text" name="hh" size="2" value="<? echo $pbmarathon[0]; ?>"/></th>
						<th>mm<input type="text" name="mm" size="2" value="<? echo $pbmarathon[1]; ?>"/></th>
						<th>ss<input type="text" name="ss" size="2" value="<? echo $pbmarathon[2]; ?>"/></th>
						<th>gara<input type="text" name="event" size="30" value="<? echo $runner->getPbmarathonevent(); ?>"/></th>
						<th><input type="submit" value="Aggiorna"></th>
					</form>
				</tr>
			</table>
		</div>
		<?
		include "back.php";
		?>
	</body>
</html>
