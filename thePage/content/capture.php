<p><button onclick="snapshot();">Take Snapshot</button></p>
<p><button onclick="discard();">Discard</button></p>
<p><div><select id="atata" onchange="draw_image()">
	<option value="0">None</option>
	<option value="1">Doge</option>
	<option value="2">Trololo</option>
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