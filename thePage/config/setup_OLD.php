<?php
	$servername = 'localhost';
	$username = 'root';
	$password = 'qwertyuiop';
	$link = mysqli_connect($servername, $username, $password);
	if (mysqli_connect_errno() > 0){
		exit('cannot connect to mysql' . mysqli_connect_error());
	}
	$query = "CREATE DATABASE IF NOT EXISTS db_camagru";
	if (mysqli_query($link, $query)){
		echo "DATABASE created successfully!" . "<br>";
	}
	else{
		exit('DATABASE not created' . mysqli_error());
	}
	mysqli_close($link);
	$link = mysqli_connect($servername, $username, $password, 'db_camagru');
	if (mysqli_connect_errno() > 0){
		exit('cannot connect to mysql' . mysqli_connect_error());
	}
	$sql_u = "CREATE TABLE IF NOT EXISTS users (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			username VARCHAR(30) NOT NULL,
			password VARCHAR(30) NOT NULL,
			email VARCHAR(50) NOT NULL,
			confirm BOOLEAN NOT NULL DEFAULT 0
			)";
	if (mysqli_query($link, $sql_u)){
		echo "Table users created successfully" . "<br>";
	}
	else{
		echo "Error creating table: " . mysqli_error($link);
	}
	$sql_t = "CREATE TABLE IF NOT EXISTS pictures (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			file_path VARCHAR(500) NOT NULL,
			username VARCHAR(200) NOT NULL,
			comments VARCHAR(10) NOT NULL,
			likes INT(6) NOT NULL,
			dislikes INT(6) NOT NULL,
			date_create DATE NOT NULL
			)";
	if (mysqli_query($link, $sql_t)){
		echo "Table pictures created successfully" . "<br>";
	}
	else{
		echo "Error creating table: " . mysqli_error($link);
	}

	$sql_c = "CREATE TABLE IF NOT EXISTS images (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									name VARCHAR(50) NOT NULL,
									file_path VARCHAR(500) NOT NULL
									)";
	if (mysqli_query($link, $sql_c)){
		echo "Table images created successfully" . "<br>";
	}
	else{
		echo "Error creating table: " . mysqli_error($link);
	}
	if (mysqli_num_rows(mysqli_query($link, "SELECT * FROM images")) == '0'){
		if (mysqli_query($link, "INSERT INTO images (name, file_path)
			VALUES ('Doge', 'img/doge.png'),
			('Grumpy Cat', 'img/grumpy_cat.png'),
			('Stoned Fox', 'img/stoned_fox.png'),
			('Trololo', 'img/trollface.png');")){
			echo "New record images created successfully" . "<br>";
		}
		else{
			echo "Error: " . $sql_t . "<br />" . mysqli_error($link);
		}
	}
	echo "SUCCESSFULLY INSTALED!" . "<br>";
	mysqli_close($link);
?>