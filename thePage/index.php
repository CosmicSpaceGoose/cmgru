<?php
include $_SERVER['DOCUMENT_ROOT']."elements/header.php";
if (isset($_GET['page'])) {
	if (file_exists($_SERVER['DOCUMENT_ROOT']."content/".$_GET['page'].".php"))
		include $_SERVER['DOCUMENT_ROOT']."content/".$_GET['page'].".php";
	else
		include $_SERVER['DOCUMENT_ROOT']."content/error.php"; //	or what??
}
else
	include $_SERVER['DOCUMENT_ROOT']."content/landing.php";
include $_SERVER['DOCUMENT_ROOT']."elements/footer.php";
?>