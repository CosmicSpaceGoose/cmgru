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
	// $admin = "INSERT INTO users (username, password, email, type)
	// VALUES ('dlinkin', 'dlinkin', 'dlinkin@student.unit.ua', 'admin'),
	// ('abytko', 'abytko', 'abytko@student.unit.ua', 'admin')";
	// if (mysqli_query($link, $admin)){
	// 	echo "New record admin_users created successfully" . "<br>";
	// }
	// else{
	// 	echo "Error: " . $sql_u . "<br />" . mysqli_error($link);
	// }
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
	// if (mysqli_num_rows(mysqli_query($link, "SELECT * FROM pictures")) == '0'){
	// 	if (mysqli_query($link, "INSERT INTO pictures (name, description, img_path, price, article, category1, category2, category3)
 //            VALUES ('Book', 'very good product', './content/book.jpg', '80', '1', 'red', '', ''),
 //            ('Tongue', 'Some description of the product, take a lot of place.', './content/cat.jpg', '130', '2', 'red', '', ''),
 //            ('=Censored=', '============================[Censored]=================[Censored]===============', './content/cat.jpg', '20', '3', 'red', 'black', ''),
 //            ('Anchor', 'awesome product', './content/jakor.jpg', '50', '4', 'black', '', ''),
 //            ('Katyshkii', 'amasy katyshkii', './content/katyshek1.jpg', '500', '5', 'black', '', ''),
 //            ('Fancy Ring', 'very good product', './content/ring.jpg', '100', '6', 'white', 'red', ''),
 //            ('Glorious Hat', 'There is a lot of text. Maybe.', './content/shapo4ka.png', '250', '7', 'white', '', ''),
 //            ('Sign', 'very good product', './content/sign.png', '2', '8', 'white', '', ''),
 //            ('Forgotten sock', 'very good product', './content/sock.png', '30', '9', 'white', 'black', 'red'),
 //            ('Mr. Spidy', 'good Mr.', './content/spider.jpg', '100', '10', 'black', '', '');")){
 //            echo "New record products created successfully" . "<br>";
 //        }
	// 	else{
	// 		echo "Error: " . $sql_t . "<br />" . mysqli_error($link);
	// 	}
	// }
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