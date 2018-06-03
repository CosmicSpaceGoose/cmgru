<?php

function cook_str($str)
{
	$rat = trim($str);
	$rat = stripslashes($rat);
	$rat = htmlspecialchars($rat);
	return ($rat);
}

include_once $_SERVET["DOCUMENT_ROOT"]."php/mysql_cheak.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'signup') {

	if (empty(cook_str($_POST['sign_name']))) {
		$nameErr = "Username reqired.";
	} else if (strlen(cook_str($_POST['sign_name'])) < 4)	{
		$nameErr = "Username must contain at least 4 symbols.";
	} else if (strlen(cook_str($_POST['sign_name'])) > 30) {
		$nameErr = "Whoa, chose shortener username.";
	} else if (mysqli_num_rows(db_query_select("*", "`users`", "`username` = '".cook_str($_POST['sign_name'])."'")) > 0) {
		$nameErr = "Username already in use.";
	} else {
		$name = cook_str($_POST['sign_name']);
	}

	if (empty($_POST['sign_mail'])) {
		$mailErr = "E-mail reqired";;
	} else if (!filter_var($_POST['sign_mail'], FILTER_VALIDATE_EMAIL)) {
		$mailErr = "Invalid e-mail adress.";
	} else if (mysqli_num_rows(db_query_select("*", "`users`", "`email` = '".$_POST['sign_mail']."'")) > 0) {
		$mailErr = "E-mail already registered.";
	} else {
		$mail = $_POST['sign_mail'];
	}

	if (empty($_POST['sign_pswd']))	{
		$psswdErr = "Password required.";
	} else if (strlen($_POST['sign_pswd']) < 6)	{
		$psswdErr = "Password must contain at least 6 symbols.";
	} else if ($_POST['sign_pswd'] !== $_POST['cnfrm']) {
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
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$name = $psswd = $mail = "";
	$nameErr = $psswdErr = $mailErr = "";
	if (isset($_GET['status']) && $_GET['status'] == 'success') {
?>
	<div class="schnelleReport">We've sent a massege on your e-mail. You must confirm it by clickin' on the link in massege.</div>
<?php	}}	?>

<form id="signup" method="POST" action="">
	<div><input type="text" placeholder="E-mail" name="sign_mail" value="<?php echo $_POST['mail'];?>">
		<span class="error"><?php echo $mailErr;?></span></div>
	<div><input type="text" placeholder="Username" name="sign_name" value="<?php echo $_POST['name'];?>">
		<span class="error"><?php echo $nameErr;?></span></div>
	<div><input type="password" placeholder="Password" name="sign_pswd" value="<?php echo $_POST['psswd'];?>"></div>
	<div><input type="password" placeholder="Confirm password" name="sign_cnfrm" value="<?php echo $_POST['cnfrm']; ?>">
		<span class="error"><?php echo $psswdErr;?></span></div>
	<button class="btns" type="submit" name="submit" value="signup">Sign Up</button>
</form>
