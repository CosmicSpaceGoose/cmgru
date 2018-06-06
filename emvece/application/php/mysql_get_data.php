<?php
include_once $_SERVER['DOCUMENT_ROOT']."php/mysql_cheak.php";

$data = file_get_contents("php://input");
$data = json_decode($data);
$result = db_query_select($data[0], $data[1], $data[2]);
echo json_encode($result);
?>
