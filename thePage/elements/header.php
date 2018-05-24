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
<div id="menu">
	<a class="link" href="index.php?page=gallery">Gallery</a>
</div>
<div id="session">
<?php
	if ($_SESSION["loggued_on_user"] == true
	&& $_SESSION["loggued_on_user"] !== "") {	?>
	<a class="btns" href="index.php?page=account">Account</a>
	<a class="btns" href="index.php">Logout</a>
<?php	} else {	?>
	<a class="btns" href="index.php?page=login">Login</a>
	<a class="btns" href="index.php?page=register">Register</a>
<?php	}	?>
</div>
