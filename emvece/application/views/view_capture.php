<?php
	if ($_SESSION["loggued_on_user"] == true
	&& $_SESSION["loggued_on_user"] !== "") {	?>
<p><button class="btns" onclick="snapshot();">Take Snapshot</button></p>
<p><button class="btns" onclick="discard();">Discard</button></p>
<form id="atata" onchange="draw_image(this)" action="">
	<input type="radio" name="imgs" value="0">None<br>
<?php
	include_once "application/php/mysql_cheak.php";
	$arr = db_query_select("imgId, name", "images", NULL);
	if (isset($arr))
	{
		foreach ($arr as $value) {
?>
	<input type="radio" name="imgs" value="<?php echo $value['imgId']; ?>"><?php echo $value['name']; ?><br>
<?php	}}	?>
</form>	<video id="stream" onclick="snapshot();" width="640" height="480" id="video" autoplay></video>
	<canvas id="myCanvas" width="640" height="480"></canvas>
</div>
<input id="save" type="button" onclick="upload()" value="Upload">
<form method="post" accept-charset="utf-8" name="form1">
	<input name="hidden_data" id='hidden_data' type="hidden">
</form>
<script src="js/capture.js"></script>
<?php
} else { ?>
<script type="text/javascript">
	schnelleReporter( "Sorry, but You aren't authorized to use this page", 'index.php' );
</script>
<?php	}	?>