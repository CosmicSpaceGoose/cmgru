<?php
session_start();

include ("auth.php");

if (auth($_POST["login"], $_POST["passwd"]) == true) {
	$_SESSION["loggued_on_user"] = $_POST["login"];
	return (true);
} else {
	$_SESSION["loggued_on_user"] = "";
	return (false);
}
?>