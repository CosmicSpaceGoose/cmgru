<?php
$name = $psswd = $mail = "";
$nameErr = $psswdErr = $mailErr = "";

function cook_str($str) {
	$rat = trim($str);
	$rat = stripslashes($rat);
	$rat = htmlspecialchars($rat);
	return ($rat);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST['name']) || empty(cook_str($_POST['name'])))
		$nameErr = "Username reqired";
	else if (strlen($name) < 5)
			$nameErr = "Username must contain at least 4 symbols";
	} else
		$name = cook_str($_POST['name']);

	if (empty($_POST['mail']))
		$nameErr = "E-mail reqired";;
	else {
		$mail = cook_str($_POST['mail']);
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			$mailErr = "Invalid e-mail adress";
			unset($mail);
			$mail = "";
		}
	}

	if (empty($_POST['psswd']))
		$psswdErr = "Password required";
	else if (strlen($_POST['psswd']) < 7)
		$psswdErr = "Password must contain at least 6 symbols";
	else if ($_POST['psswd'] !== $_POST['cnfrm'])
		$psswdErr = "Passwords are not equal";
	else
		$psswd = hash('whirlpool', $_POST['psswd']);


}

?>
<form id="signup" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<input type="text" placeholder="E-mail" name="mail">
	<input type="text" placeholder="Username" name="name">
	<input type="password" placeholder="Password" name="psswd">
	<input type="password" placeholder="Confirm password" name="cnfrm">
	<button class="btns" type="submit">Sign Up</button>
</form>

<?php
	if ($nameErr == "" && $psswdErr == "" && $mailErr == "")
	{
		echo $name;
		echo "<br>";
		echo $name;
		echo "<br>";
		echo $name;
	}
?>
