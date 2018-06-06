// ************************************************************************** //
//                                                                            //
//                                                        :::      ::::::::   //
//   capture.js                                         :+:      :+:    :+:   //
//                                                    +:+ +:+         +:+     //
//   By: dlinkin <marvin@42.fr>                     +#+  +:+       +#+        //
//                                                +#+#+#+#+#+   +#+           //
//   Created: 2018/06/06 17:35:25 by dlinkin           #+#    #+#             //
//   Updated: 2018/06/06 17:35:27 by dlinkin          ###   ########.fr       //
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
			video: {
					width: { min: 640 },
					height: { min: 480 }
				}
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

function discard() {
	ctx.clearRect(0,0, canvas.width, canvas.height);
	document.getElementById('save').style.display = "none";
}

function draw_image( rads ) {
	var num;
	for (var i = rads.length - 1; i >= 0; i--) {
		if (rads[i].checked)
			num = i;
	}
	console.log(num);
	// document.getElementById('save').style.display = "none";
	// if (parseInt(num) - 1 in arr)
	// {
	// 	ctx.clearRect(0,0, canvas.width, canvas.height);
	// 	img.src = arr[parseInt(num) - 1]['file_path'];
	// 	console.log(img);
	// 	ctx.drawImage(img, 0,0, 226, 226);
	// }
	// else
	// {
	// 	ctx.clearRect(0,0, canvas.width, canvas.height);
	// 	img.removeAttribute("src");
	// }
}

function snapshot() {
	if ( document.getElementById('atata').value > 0 ) {
		document.getElementById('save').style.display = "block";
		ctx.drawImage(video, 0,0, canvas.width, canvas.height);
		ctx.drawImage(img, 0,0, 226, 226);
	}
}

function upload() {
	var dataURL = canvas.toDataURL("image/png");
	document.getElementById('hidden_data').value = dataURL;
	var fd = new FormData(document.forms["form1"]);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'php/save.php', true);
	xhr.send(fd);
	schnelleReporter( 'Photo succesfully upload!', null );
	canvas.style.display = "none";
	document.getElementById('save').style.display = "none";
};

