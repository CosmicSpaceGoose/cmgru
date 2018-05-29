<?php

include_once "config/database.php";

function db_query_select($fields, $table, $part) {
	try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	} catch (PDOException $error) {
		exit("Connection failed: ".$error->getMessage());
	}
	if ($part == true)
		$sql = "SELECT $fields FROM $table WHERE $part";
	else
		$sql = "SELECT $fields FROM $table";
	$result = $pdo->query($sql)->fetchAll();
	$pdo = NULL;
	return ($result);
}

static function db_pdo_helper($fields, &$values, $inserts = array()) {
	$prepare = '';
	$values = array();
	foreach ($fields as $name) {
		if (isset($inserts[$name])) {
			$prepare .= "`".str_replace("`","``",$name)."`". "=:$field, ";
			$values[$name] = $inserts[$name];
		}
	}
	return substr($prepare, 0, -2); 
}

function db_query_insert($table, $fields, $inserts) {
	try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	} catch (PDOException $error) {
		exit("Connection failed: ".$error->getMessage());
	}
	$stmt = $pdo->prepare("INSERT INTO $table SET".db_pdo_helper($fields, $values, $inserts));
	$stmt->execute($values);
	$stmt = NULL;
	$pdo = NULL;
}

function db_query_update($table, $fields, $inserts) {
	try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
	} catch (PDOException $error) {
		exit("Connection failed: ".$error->getMessage());
	}
	$stmt = $pdo->prepare("UPDATE $table SET".db_pdo_helper($fields, $values, $inserts));
	$stmt->execute($values);
	$stmt = NULL;
	$pdo = NULL;
}

?>