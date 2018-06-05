// ************************************************************************** //
//                                                                            //
//                                                        :::      ::::::::   //
//   camera.js                                          :+:      :+:    :+:   //
//                                                    +:+ +:+         +:+     //
//   By: dlinkin <marvin@42.fr>                     +#+  +:+       +#+        //
//                                                +#+#+#+#+#+   +#+           //
//   Created: 2018/05/24 15:32:12 by dlinkin           #+#    #+#             //
//   Updated: 2018/05/24 15:32:19 by dlinkin          ###   ########.fr       //
//                                                                            //
// ************************************************************************** //

navigator.getUserMedia = ( navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia);
var video;
var webcamStream;
var img = new Image();

if (navigator.getUserMedia) {
	navigator.getUserMedia (
		{
			audio: false,
			video: true
				/*{
					width: { min: 1280 },
					height: { min: 720 }
				}*/
		},
		function ( localMediaStream ) {
			video = document.querySelector('video');
				video.srcObject = localMediaStream;
				webcamStream = localMediaStream;
			},
			function(err) {
				console.log("The following error occured: " + err);
			});
		} else {
			console.log("getUserMedia not supported");
	}

var canvas, ctx;
canvas = document.getElementById("myCanvas");
ctx = canvas.getContext('2d');
var xhrq = new XMLHttpRequest;
var arr;
xhrq.onreadystatechange = function(){
	if (xhrq.readyState === 4 && xhrq.status === 200) {
		arr = JSON.parse(xhrq.responseText);
	}
};
xhrq.open('POST', 'php/mysql_get_data.php', true);
xhrq.setRequestHeader( "Content-Type", "application/json" );
xhrq.send(JSON.stringify(["file_path", "images", null]));

function snapshot() {
	if ( document.getElementById('atata').value > 0 ) {
		document.getElementById('myCanvas').style.display = "block";
		document.getElementById('save').style.display = "block";
		ctx.drawImage(video, 0,0, canvas.width, canvas.height);
		ctx.drawImage(img, 0,0, 226, 226);
	}
}

function discard() {
	canvas.style.display = "none";
	document.getElementById('save').style.display = "none";
}

function draw_image() {
	var num = document.getElementById('atata').value;
	if (arr[parseInt(num) - 1] !== 'undefined')
		img.src = arr[parseInt(num) - 1]['file_path'];
	else
		delete img.src;
}

function upload() {
	var dataURL = canvas.toDataURL("image/png");
	document.getElementById('hidden_data').value = dataURL;
	var fd = new FormData(document.forms["form1"]);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'php/save.php', true);

	// xhr.upload.onprogress = function(e) {
	// 	if (e.lengthComputable) {
	// 		var percentComplete = (e.loaded / e.total) * 100;
	// 		console.log(percentComplete + '% uploaded');
	// 		alert('Succesfully uploaded');
	// 	}
	// };

	// xhr.onload = function() {};
	xhr.send(fd);
	schnelleReporter( 'Photo succesfully upload!', 'index.php?page=capture' );
};
