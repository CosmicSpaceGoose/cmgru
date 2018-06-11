<?php

if ( isset( $_GET ) && isset( $_GET['status'] )) {
	if ( $_GET['status'] == 'reject' ) { ?>
<script>
	schnelleReporter("Sorry, but you aren't authorized to use this page.", "/");
</script>
<?php	} else if ( $_GET['status'] == 'mail' ) { ?>
<script>
	schnelleReporter("Sorry, but you aren't verificate your email, please check mail box.", "/");
</script>
<?php	}} else {	?>
<p><button class="btns" onclick="snapshot();">Take Snapshot</button></p>
<p><button class="btns" onclick="discard();">Discard</button></p>
<form id="atata" onchange="draw_image(this)" action="">
	<input type="radio" name="imgs" value="0">None<br>
<?php
	if ( isset( $data ))
	{
		foreach ( $data as $value ) {
?>
	<input type="radio" name="imgs" value="<?php echo $value['imgId']; ?>"><?php echo $value['name']; ?><br>
<?php	}}	?>
</form>	<video id="stream" onclick="snapshot();" width="640" height="480" id="video" autoplay></video>
	<canvas id="myCanvas" width="640" height="480" onmousedown="detect(this)"></canvas>
</div>
<input id="save" type="button" onclick="upload()" value="Upload">
<form method="post" accept-charset="utf-8" name="form1">
	<input name="hidden_data" id='hidden_data' type="hidden">
</form>
<script src="/js/capture.js"></script>
<?php	}	?>
