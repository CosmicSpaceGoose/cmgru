<div id="captCont">
<div id="right"><input class="btns" onclick="snapshot();" type="button" value="Take Snapshot">
<input class="btns" onclick="discard();" type="button" value="Discard">
<input id="desktop" class="btns" type="file">
</div>
<form id="atata" onchange="draw_image(this)" action="">
	<input type="radio" name="imgs" value="0" checked="checked">None<br>
<?php
	if ( isset( $data ))
	{
		foreach ( $data as $value ) {
?>
	<input type="radio" name="imgs" value="<?php echo $value['imgId']; ?>"><?php echo $value['name']; ?><br>
<?php	}}	?>
</form>	<video id="stream" onclick="snapshot();" width="640" height="480" id="video" autoplay></video>
	<canvas id="myCanvas" width="640" height="480" onmousedown="detect(this)"></canvas>
<input id="save" type="button" onclick="save_on_server()" value="Save">
<form method="post" accept-charset="utf-8" name="form1">
	<input name="hidden_data" id='hidden_data' type="hidden">
</form>
</div>
<script src="/js/capture.js"></script>
</div>
