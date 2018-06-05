<?php

function cook_str($str)
{
	$rat = trim($str);
	$rat = stripslashes($rat);
	$rat = htmlspecialchars($rat);
	return ($rat);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'signup') {
	include_once $_SERVER["DOCUMENT_ROOT"]."php/mysql_cheak.php";

	if (empty(cook_str($_POST['sign_name']))) {
		$nameErr = "Username reqired.";
	} else if (strlen(cook_str($_POST['sign_name'])) < 4)	{
		$nameErr = "Username must contain at least 4 symbols.";
	} else if (strlen(cook_str($_POST['sign_name'])) > 30) {
		$nameErr = "Whoa, chose shortener username.";
	} else if (count(db_query_select("*", "`users`", "`username` = '".cook_str($_POST['sign_name'])."'")) > 0) {
		$nameErr = "Username already in use.";
	} else {
		$name = cook_str($_POST['sign_name']);
	}

	if (empty($_POST['sign_mail'])) {
		$mailErr = "E-mail reqired";;
	} else if (!filter_var($_POST['sign_mail'], FILTER_VALIDATE_EMAIL)) {
		$mailErr = "Invalid e-mail adress.";
	} else if (count(db_query_select("*", "`users`", "`email` = '".$_POST['sign_mail']."'")) > 0) {
		$mailErr = "E-mail already registered.";
	} else {
		$mail = $_POST['sign_mail'];
	}

	if (empty($_POST['sign_pswd']))	{
		$psswdErr = "Password required.";
	} else if (strlen($_POST['sign_pswd']) < 6)	{
		$psswdErr = "Password must contain at least 6 symbols.";
	} else if ($_POST['sign_pswd'] !== $_POST['sign_cnfrm']) {
		$psswdErr = "Passwords are not equal.";
	} else {
		$psswd = hash('whirlpool', $_POST['sign_mail'].$_POST['sign_pswd']);
	}

	if ($nameErr == "" && $psswdErr == "" && $mailErr == "") {
		db_query_insert("`users`",
			array("username", "password", "email"),
			array("username" => $name, "password" => $psswd, "email" => $mail));
		header("Location: ".$_SERVER['REQUEST_URI']."&status=success");
		exit();
	}
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'login') {
	include_once $_SERVER["DOCUMENT_ROOT"]."php/check_login.php";
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$name = $psswd = $mail = "";
	$nameErr = $psswdErr = $mailErr = $logErr = "";
?>
	<script type="text/javascript">
	var url = new URL(window.location);
	if (url.searchParams.get( 'status' ) == 'success') {
		schnelleReporter( "We've sent a massege on your e-mail. You must confirm it by clickin' on the link in massege.", 'index.php' );
	} else if (url.searchParams.get( 'status' ) == 'login') {
		schnelleReporter( "Welcome! Wheneve U R..", 'index.php' );
	}
	</script>
<?php	}
if ($_GET['frm'] == 'signup') { ?>
	<div id="form_holder">
	<form class="formz" method="POST" action="">
		<div><input type="text" placeholder="E-mail" name="sign_mail" value="<?php echo $_POST['sign_mail'];?>">
			<span class="error"><?php echo $mailErr;?></span></div>
		<div><input type="text" placeholder="Username" name="sign_name" value="<?php echo $_POST['sign_name'];?>">
			<span class="error"><?php echo $nameErr;?></span></div>
		<div><input type="password" placeholder="Password" name="sign_pswd" value="<?php echo $_POST['sign_pswd'];?>"></div>
		<div><input type="password" placeholder="Confirm password" name="sign_cnfrm" value="<?php echo $_POST['sign_cnfrm']; ?>">
			<span class="error"><?php echo $psswdErr;?></span></div>
		<button class="btns" type="submit" name="submit" value="signup">Sign Up</button>
	</form>
	</div>
<?php	} else if ($_GET['frm'] == 'login') { ?>
	<div id="form_holder">
	<form class="formz" method="POST">
		<input type="text" placeholder="E-mail" name="login_mail" value="<?php echo $_POST['login_mail']?>">
		<input type="password" placeholder="Password" name="login_pswd" value="<?php echo $_POST['login_pswd']?>">
		<span class="error"><?php echo $logErr ?></span>
		<button class="btns" type="submit" name="submit" value="login">Login</button>
	</form>
	</div>
<?php	} else { ?>
	<div class="schnelleReport">When u read this massage 'til end, u'll understand, that it has no sense.</div>
<?php	}?>

