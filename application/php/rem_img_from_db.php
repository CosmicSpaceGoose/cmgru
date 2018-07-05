<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "application/php/mysql_cheak.php";
$data = file_get_contents("php://input");
$arr = explode('/', $data);
db_del_from_db('pictures', 'file_path', 'images/pics/'.rtrim(end($arr), "\""));
unlink($_SERVER["DOCUMENT_ROOT"] . 'images/pics/'.rtrim(end($arr), "\""));
?>
