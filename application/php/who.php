<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "application/php/mysql_cheak.php";

if ( isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] != "" ) {
	$request = db_query_select("confirm", "users", "username ='".$_SESSION['loggued_on_user']."'");
	if ( count( $request ) > 0 ) {
		if ( $request[0]['confirm'] == 1 )
			exit ( true );
	}
}
exit ( false );
?>
