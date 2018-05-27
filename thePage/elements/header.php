<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>thePage</title>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="shortcut icon" href="">
</head>

<body>
<div id="header">
	<a class="link" href="index.php?page=gallery">Gallery</a>
</div>
<div id="session">
<?php
	if ($_SESSION["loggued_on_user"] == true
	&& $_SESSION["loggued_on_user"] !== "") {	?>
	<div class="drpdwn">Hello <i><?php echo $_SESSION["loggued_on_user"]; ?></i></div>
<!-- 	<div class="btns" href="index.php?page=account">Account</div>
	<div class="btns" href="index.php">Logout</div> -->
<?php	} else {	?>
	<div class="drpdwn">Hello <b><i>Guest</i></b></div>
	<div id="login_form"><form method="POST">
		<input type="text" placeholder="E-mail" name="mail">
		<input type="password" placeholder="Password" name="passwd">
		<button class="btns" type="submit">Login</button>
	</form></div>
	<a href="index.php?page=signup">Sign Up</a>
	<a href="index.php?page=resent">Forgot Password?</a>
<?php	}	?>
</div>
