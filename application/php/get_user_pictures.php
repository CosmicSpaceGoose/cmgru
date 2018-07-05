<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "application/php/mysql_cheak.php";
$result = db_query_select("*", "pictures", "uid = '".$_SESSION['uid']."'");
echo json_encode($result);
?>
