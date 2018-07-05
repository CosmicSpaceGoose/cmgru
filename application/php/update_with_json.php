<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "application/php/mysql_cheak.php";
$data = file_get_contents("php://input");
$data = json_decode($data);
$request = db_query_select($data[0], $data[1], $data[2]);
if ( isset($request[0]))
{
	$rat = $request[0][$data[0]] + 1;
	db_query_update(
		$data[1],
		array( $data[0] ),
		array( $data[0] => $rat ),
		$data[2]
		);
}
else
	$rat = 0;
echo $rat;
?>
