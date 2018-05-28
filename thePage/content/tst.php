<?php

if (file_exists("php/mysql_cheak.php")) {
	include "php/mysql_cheak.php";

	$arr = db_query_select("*", "`users`", "`username` = \"".$uname."\"");
	echo mysqli_num_rows($arr);
}
else
{
	echo "file not exist??\n";
}
?>
