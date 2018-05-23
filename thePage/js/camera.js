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
		function(localMediaStream) {
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

    function init() {
        canvas = document.getElementById("myCanvas");
        ctx = canvas.getContext('2d');
    }

    function snapshot() {
		document.getElementById('myCanvas').style.display = "block";
		document.getElementById('save').style.display = "block";
		ctx.drawImage(video, 0,0, canvas.width, canvas.height);
		ctx.drawImage(img, 0,0, 226, 226);
    }
	
	function discard() {
		document.getElementById('myCanvas').style.display = "none";
		document.getElementById('save').style.display = "none";
	}
	
	function doge() {
		img.src = "../img/doge.png";
	}
	
	function uploadEx() {
		var dataURL = canvas.toDataURL("image/png");
		document.getElementById('hidden_data').value = dataURL;
		var fd = new FormData(document.forms["form1"]);

		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../php/save.php', true);

		xhr.upload.onprogress = function(e) {
			if (e.lengthComputable) {
				var percentComplete = (e.loaded / e.total) * 100;
				console.log(percentComplete + '% uploaded');
				alert('Succesfully uploaded');
			}
		};

		xhr.onload = function() {};
		xhr.send(fd);
	};
