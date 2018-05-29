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
