<!DOCTYPE html>
<html>
<head>
	<title>thePage</title>
	<link rel="stylesheet" href="/css/styles.css">
	<!-- <link rel="shortcut icon" type="image/ico" href="/favicon.ico"> -->
	<link rel="shortcut icon" type="image/png" href="/images/cont/ico.png">
</head>
<script src="/js/schnelle_reporta.js"></script>
<body>
<div id="header">
	<a class="link" href="/gallery">Gallery</a>
</div>
<div id="session">
<?php
	if (isset($_SESSION["loggued_on_user"])	&& $_SESSION["loggued_on_user"] !== "") {	?>
	<div class="drpdwn">Hello <span style="color: #1D2951; "><b><i><?php echo $_SESSION["loggued_on_user"]; ?></i></b></span></div>
	<a href="/account">Account</a>
	<a href="/auth/logout">Logout</a>
<?php	} else {	?>
	<div class="drpdwn">Hello <b><i>Guest</i></b></div>
	<a href="/auth?frm=signup">Sign Up</a>
	<a href="/auth?frm=login">Login</a>
	<a href="index.php">forgot password?</a>
<?php	}	?>
</div>
<?php
	include 'application/views/'.$contentView;
	if (isset($contentView) && $contentView != 'view_landing.php')	{	?>
	<a id="back" href="/">&#8617</a>
<?php	}	?>
<div id="footer">
	<div style="margin: 0 5vw 0 0">dlinkin 2018 &copy</div>
</div>
</body>
</html>
