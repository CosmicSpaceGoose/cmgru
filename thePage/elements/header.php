<?php	session_start();	?>
<!DOCTYPE html>
<html>
<head>
	<title>thePage</title>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="shortcut icon" href="ico.png">
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
	<a href="index.php?page=auth&frm=signup">Sign Up</a>
	<a href="index.php?page=auth&frm=login">Login</a>
	<a href="index.php">forgot password?</a>
<?php	}	?>
</div>
