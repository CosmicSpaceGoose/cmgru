<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "application/php/mysql_cheak.php";
$data = file_get_contents("php://input");
db_query_update(
		'`users`',
		array( 'reply' ),
		array( 'reply' => $data ),
		'`username`=\''.$_SESSION['loggued_on_user'].'\''
		);
?>
