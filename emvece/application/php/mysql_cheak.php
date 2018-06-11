<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "config/database.php";
$GLOBALS['DB_DSN'] = $DB_DSN;
$GLOBALS['DB_USER'] = $DB_USER;
$GLOBALS['DB_PASSWORD'] = $DB_PASSWORD;
$GLOBALS['DB_OPT'] = $DB_OPT;

function db_query_select($fields, $table, $part) {
	try {
		$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_OPT']);
	} catch (PDOException $error) {
		exit("Connection failed: " . $error->getMessage());
	}
	if ($part == true)
		$sql = "SELECT $fields FROM $table WHERE $part";
	else
		$sql = "SELECT $fields FROM $table";
	$result = $pdo->query($sql)->fetchAll();
	$pdo = NULL;
	return ($result);
}

function db_pdo_helper($fields, &$values, $inserts = array()) {
	$prepare = '';
	$values = array();
	foreach ($fields as $name) {
		if (isset($inserts[$name])) {
			$prepare .= "`".str_replace("`","``",$name)."`". "=:$name, ";
			$values[$name] = $inserts[$name];
		}
	}
	return (substr($prepare, 0, -2)); 
}

function db_query_insert($table, $fields, $inserts) {
	try {
		$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_OPT']);
	} catch (PDOException $error) {
		exit("'Connect failed: " . $error->getMessage() . "'");
	}
	$stmt = $pdo->prepare("INSERT INTO $table SET".db_pdo_helper($fields, $values, $inserts));
	$stmt->execute($values);
	$stmt = NULL;
	$pdo = NULL;
}

function db_query_update($table, $fields, $inserts, $condition) {
	try {
		$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_OPT']);
	} catch (PDOException $error) {
		exit("Connection failed: ".$error->getMessage());
	}
	if (isset($condition))
		$stmt = $pdo->prepare("UPDATE $table SET".db_pdo_helper($fields, $values, $inserts)." WHERE ".$condition);
	else
		$stmt = $pdo->prepare("UPDATE $table SET".db_pdo_helper($fields, $values, $inserts));
	$stmt->execute($values);
	$stmt = NULL;
	$pdo = NULL;
}
?>