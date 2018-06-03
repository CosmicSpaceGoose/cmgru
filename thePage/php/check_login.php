<?php
include_once $_SERVER['DOCUMENT_ROOT']."php/mysql_cheak.php";
$logErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'login') {
	$result = db_query_select("*", "`users`", "`email` = '".$_POST['login_mail']."'");
	if (isset($result[0]))
	{
		if ($result[0]['password'] == hash('whirlpool', $_POST['login_mail'].$_POST['login_pswd']))
			$_SESSION["loggued_on_user"] = $result[0]['username'];
		else
			$logErr = "incorect password";
	}
	else
		$logErr = "incorect e-mail";
	if ($logErr == "") {
		header("Location: ".$_SERVER['REQUEST_URI']);
		exit();
	}
}
?>
