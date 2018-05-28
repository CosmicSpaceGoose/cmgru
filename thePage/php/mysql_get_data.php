<?php
include_once "mysql_cheak.php";

$data = file_get_contents("php://input");
$data = json_decode($data);
$arr = db_query_select($data[0], $data[1], $data[2]);
$result = array();
while ($row = mysqli_fetch_array($arr, MYSQLI_ASSOC)) {
	array_push($result, $row);
	mysqli_free_result($row);
}
echo json_encode($result);
?>
