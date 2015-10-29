<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<header>
	<?php 
	require_once("../wp-load.php");
	?>
	</header>
	<body>
	<div id="button">
	</div>
		<div id = "home">
			<table>
				<tr>
				<!-- home -->
						<td id="home" width=60%>
							<FORM method="POST" target="_parent" action="http://<?php echo $_SERVER['SERVER_NAME']; ?>"><input type="image" src="images/r.png" title="Home" height="140">
							</FORM>
						</td>
				<!-- end home -->
				<!-- login -->
				<?php 
				//current user
				$curruser = get_current_user_id();
				if($curruser == 0 or $curruser == NULL){
				?>
					<td>
						<div id = "login">
							<FORM method="POST" target="_parent" action="../wp-login.php" name="login"><input type="image" src="images/login2.png" title="Login" width="48" height="48" >
							</FORM>
						</div>
					</td>
				<?php
				}
				?>
				<!-- end login -->
				</tr>	  
			</table>
		</div>
	</body>
</html>
