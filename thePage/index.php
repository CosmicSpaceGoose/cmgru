<?php
include "elements/header.php";
if (isset($_GET['page']))
	include "content/".$_GET['page'].".php";
else
	include "content/landing.php";
include "elements/footer.php";
?>