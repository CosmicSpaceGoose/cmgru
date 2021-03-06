<?php
if (!file_exists("database.php"))
	exit("file 'database.php' is missing<br>");
include "database.php";

try {
	$pdo = new PDO($DB_TYPE.':host='.$DB_HOST_NAME, $DB_USER, $DB_PASSWORD, $DB_OPT);
} catch (PDOException $error) {
	exit("Connection failed: ".$error->getMessage());
}
echo "Connection successfull!" . "<br>";
$dbname = "`".str_replace("`", "``", $DB_NAME)."`";
try {
	$stmt = $pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
} catch (PDOException $error) {
	exit("Creation database failed: ".$error->getMessage());
}
echo "$dbname created successfully!" . "<br>";
$pdo->query("USE $dbname");
try {
	$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS users (
		userId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		username VARCHAR(16) NOT NULL,
		password VARCHAR(128) NOT NULL,
		email VARCHAR(50) NOT NULL,
		confirm BOOLEAN NOT NULL DEFAULT 0
		)");
} catch (PDOException $error) {
	exit("Error creating table: ".$error->getMessage());
}
echo "Table users created successfully<br>";
try {
	$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS pictures (
		pictId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		file_path VARCHAR(500) NOT NULL,
		username VARCHAR(16) NOT NULL,
		likes INT(6) NOT NULL DEFAULT 0,
		dislikes INT(6) NOT NULL DEFAULT 0,
		date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		)");
} catch (PDOException $error) {
	exit("Error creating table: ".$error->getMessage());
}
echo "Table pictures created successfully<br>";
try {
	$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS images (
		imgId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(50) NOT NULL,
		file_path VARCHAR(500) NOT NULL
		)");
} catch (PDOException $error) {
	exit("Error creating table: ".$error->getMessage());
}
echo "Table images created successfully<br>";
$stmt = $pdo->query("SELECT * FROM `images`");
if (!$stmt->fetch()) {
	try {
		$stmt = $pdo->prepare("INSERT INTO images (name, file_path)	VALUES (?, ?)");
		$stmt->execute(['Doge', 'images/cont/doge.png']);
		$stmt->execute(['Grumpy Cat', 'images/cont/grumpy_cat.png']);
		$stmt->execute(['Stoned Fox', 'images/cont/stoned_fox.png']);
		$stmt->execute(['Trololo', 'images/cont/trollface.png']);
	} catch (PDOException $error) {
		exit("Error inserting values: ".$error->getMessage());
	}
	echo "Data inserted<br>";
}
try {
	$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS comments (
		commId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		pictId INT(6) UNSIGNED NOT NULL,
		username VARCHAR(16) NOT NULL,
		comment VARCHAR(400) NOT NULL,
		posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		)");
} catch (PDOException $error) {
	exit("Error creating table: ".$error->getMessage());
}
echo "Table comments created successfully<br>";
echo "DATABSE $dbname SUCCESSFULLY INSTALED!<br>";
$stmt = NULL;
$pdo = NULL;
?>