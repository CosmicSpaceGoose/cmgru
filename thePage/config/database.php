<?php
	$DB_TYPE = 'mysql';
	$DB_HOST_NAME = 'localhost';
	$DB_NAME = 'db_camagru';
	$DB_DSN = $DB_TYPE.':dbname='.$DB_NAME.';host='.$DB_HOST_NAME;
	$DB_USER = 'root';
	$DB_PASSWORD = 'qwertyuiop';
	$DB_OPT = [
		PDO::ATTR_ERRMODE				=>	PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE	=>	PDO::FETCH_ASSOC
	];
?>
