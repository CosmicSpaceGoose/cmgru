<?php
include "elements/header.php";
if (isset($_GET['page'])) {
	if (file_exists("content/".$_GET['page'].".php"))
		include "content/".$_GET['page'].".php";
	else
		include "content/error.php"; //	or what??
}
else
	include "content/landing.php";
include "elements/footer.php";
?>