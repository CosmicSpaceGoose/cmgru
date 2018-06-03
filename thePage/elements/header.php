<?php
session_start();
include "php/check_login.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>thePage</title>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="shortcut icon" href="">
</head>
<script src="js/schnellereporter.js"></script>
<body>
<div id="header">
	<a class="link" href="index.php?page=gallery">Gallery</a>
</div>
<div id="session">
<?php
	if ($_SESSION["loggued_on_user"] == true
	&& $_SESSION["loggued_on_user"] !== "") {	?>
	<div class="drpdwn">Hello <span style="color: #1D2951; "><b><i><?php echo $_SESSION["loggued_on_user"]; ?></i></b></span></div>
	<a href="index.php?page=account">Account</a>
	<a href="php/logout.php">Logout</a>
<?php	} else {	?>
	<div class="drpdwn">Hello <b><i>Guest</i></b></div>
	<div id="login_form"><form method="POST">
		<input type="text" placeholder="E-mail" name="login_mail">
		<input type="password" placeholder="Password" name="login_pswd">
		<span style="color:red;"><?php echo $logErr ?></span>
		<button class="btns" type="submit" name="submit" value="login">Login</button>
	</form></div>
	<a href="index.php?page=auth">Sign Up</a>
	<a href="index.php">Forgot Password?</a>
	<div onclick="schnelleReporter('Some difusal text')">OK</div>
<?php	}	?>
</div>
