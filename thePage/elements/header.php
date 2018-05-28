<?php
session_start();

include_once "php/mysql_cheak.php";
$logErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$result = db_query_select("*", "`users`", "`email` = '".$_POST['mail']."'");
	if ($data = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		if ($data['password'] == hash('whirlpool', $_POST['passwd']))
			$_SESSION["loggued_on_user"] = $data["username"];
		else
			$logErr = "incorect password";
		mysqli_free_result($data);
	} else {
		$logErr = "incorect e-mail";
	}
	if ($logErr == "") {
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit();
	}
}
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
	<div class="drpdwn">Hello <span style="color: #1D2951; "><b><i><?php echo $_SESSION["loggued_on_user"]; ?></i></b></span></div>
	<a href="index.php?page=account">Account</a>
	<a href="php/logout.php">Logout</a>
<?php	} else {	?>
	<div class="drpdwn">Hello <b><i>Guest</i></b></div>
	<div id="login_form"><form method="POST">
		<input type="text" placeholder="E-mail" name="mail">
		<input type="password" placeholder="Password" name="passwd">
		<span style="color:red;"><?php echo $logErr ?></span>
		<button class="btns" type="submit">Login</button>
	</form></div>
	<a href="index.php?page=signup">Sign Up</a>
	<a href="index.php?page=resent">Forgot Password?</a>
<?php	}	?>
</div>
