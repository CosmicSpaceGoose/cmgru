<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."php/mysql_cheak.php";
$img = $_POST['hidden_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = "pictures/" . mktime() . ".png";
$file_name = $_SERVER['DOCUMENT_ROOT'] . $file;
file_put_contents($file_name, $data);
db_query_insert("`pictures`",
	array("file_path", "username"),
	array("file_path" => $file, "username" => $_SESSION["loggued_on_user"])
);
?>