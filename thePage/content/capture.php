<?php
	if ($_SESSION["loggued_on_user"] == true
	&& $_SESSION["loggued_on_user"] !== "") {	?>
<p><button class="btns" onclick="snapshot();">Take Snapshot</button></p>
<p><button class="btns" onclick="discard();">Discard</button></p>
<p><div><select id="atata" onchange="draw_image()">
	<option value="0">None</option>
<?php
	include_once "php/mysql_cheak.php";
	$arr = db_query_select("id, name", "images", NULL);
	if (isset($arr))
	{
		foreach ($arr as $value) {
?>
	<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
<?php	}}	?>
</select></div></p>
<div>
	<video id="stream" onclick="snapshot(this);" width=400 height=300 id="video" autoplay></video>
	<canvas id="myCanvas" width="400" height="300"></canvas>
</div>

<input id="save" type="button" onclick="upload()" value="Upload">
<form method="post" accept-charset="utf-8" name="form1">
	<input name="hidden_data" id='hidden_data' type="hidden">
</form>
<script src="js/camera.js"></script>
<?php
} else { ?>
<script type="text/javascript">
	schnelleReporter( "Sorry, but You aren't authorized to use this page", 'index.php' );
</script>
<?php	}	?>