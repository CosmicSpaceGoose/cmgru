<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'config/database.php';
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
	$pdo = null;
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
	$stmt = null;
	$pdo = null;
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
	$stmt = null;
	$pdo = null;
}

function db_get_mail_by_comment( $pict_id ) {
	$email = null;
	try {
		$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_OPT']);
	} catch (PDOException $error) {
		exit("Connection failed: " . $error->getMessage());
	}
	$sql = "SELECT users.email, users.reply FROM users, pictures, comments WHERE users.userId = pictures.uid AND pictures.pictId = comments.pictId AND pictures.pictId = \"".$pict_id."\"";
	$result = $pdo->query($sql)->fetchAll();
	if ($result[0]['reply'] == 1)
		$email = $result[0]['email'];
	return ($email);
}

function db_del_from_db( $table, $column, $value ) {
	try {
		$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_OPT']);
	} catch (PDOException $error) {
		exit("Connection failed: " . $error->getMessage());
	}
	$stmt = $pdo->query("DELETE FROM ".$table." WHERE ".$column." = '".$value."'");
}
?>