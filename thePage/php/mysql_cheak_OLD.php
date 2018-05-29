<?php

function db_query_select($request, $querry, $part) {
	$servername = 'localhost';
	$username = 'root';
	$password = 'qwertyuiop';
	$link = mysqli_connect($servername, $username, $password, 'db_camagru');
	if (mysqli_connect_errno() > 0) {
		exit('Error: '.mysqli_connect_error()."\n");
	}
	if ($part == true)
		$sql = "SELECT $request FROM $querry WHERE $part";
	else
		$sql = "SELECT $request FROM $querry";
	$result = mysqli_query($link, $sql);
	mysqli_close($link);
	return ($result);
}

function db_query_insert($table, $fields, $values) {
	$servername = 'localhost';
	$username = 'root';
	$password = 'qwertyuiop';
	$link = mysqli_connect($servername, $username, $password, 'db_camagru');
	if (mysqli_connect_errno() > 0) {
		exit('Error: '.mysqli_connect_error()."\n");
	}
	$sql = "INSERT INTO $table ( $fields ) VALUES ( $values )";
	$ret = mysqli_query($link, $sql);
	mysqli_close($link);
	return ($ret);
}
?>