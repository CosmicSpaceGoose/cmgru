<?php
session_start();
include "mysql_cheak.php";

$upload_dir = "../pictures/";
$img = $_POST['hidden_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir . mktime() . ".png";
file_put_contents($file, $data);
$file = substr($file, 3);
$values = "'".$file."', '".$_SESSION["loggued_on_user"]."'";
$rat = db_query_insert("`pictures`", "`file_path`, `username`", $values);
?>