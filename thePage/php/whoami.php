<?php
session_start();

if ($_SESSION["loggued_on_user"] == true && $_SESSION["loggued_on_user"] !== "") {
	return (true);
} else {
	return (false);
}

?>