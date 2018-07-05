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
var uploadImg = new Image();
var num = 0;
var x = 0;
var y = 0;
document.getElementById('desktop')
	.addEventListener('change', upload_from_desktop, false);

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
		video = document.querySelector( 'video' );
			video.srcObject = localMediaStream;
			webcamStream = localMediaStream;
		},
		function( err ) {
			video = false;
			console.log( "The following error occured: " + err );
		});
} else {
			video = false;
			console.log( "getUserMedia not supported" );
}

var topCanvas, topCtx, downCanvas, downCtx;
topCanvas = document.getElementById( "topCanva" );
downCanvas = document.getElementById( "downCanva" );
topCtx = topCanvas.getContext('2d');
downCtx = downCanvas.getContext('2d');
var xhrq = new XMLHttpRequest;
var arr;
xhrq.onreadystatechange = function(){
	if ( xhrq.readyState === 4 && xhrq.status === 200 ) {
		arr = JSON.parse( xhrq.responseText );
	}
};
xhrq.open( 'POST', '/application/php/mysql_get_data.php', true );
xhrq.setRequestHeader( "Content-Type", "application/json" );
xhrq.send( JSON.stringify( [ "file_path", "images", null ]));

function discard() {
	if ( !uploadImg.src )
		downCtx.clearRect( 0,0, downCanvas.width, downCanvas.height );
	document.getElementById( 'save' ).style.display = "none";
}

function draw_image( rads ) {
	for ( var i = rads.length - 1; i >= 0; i-- ) {
		if ( rads[i].checked )
			num = i;
	}
	document.getElementById( 'save' ).style.display = "none";
	topCtx.clearRect( 0,0, topCanvas.width, topCanvas.height );
	if (num - 1 in arr) {
		img.src = arr[num - 1]['file_path'];
		img.onload = function() {
			topCtx.drawImage( img, 0,0, 226, 100 );
		}
	} else {
		img.removeAttribute( "src" );
	}
}

function snapshot() {
	if ( num > -1 ) {
		document.getElementById( 'save' ).style.display = "block";
		if ( !uploadImg.src )
			downCtx.drawImage( video, 0,0, downCanvas.width, downCanvas.height );
		else
			downCtx.drawImage( uploadImg, 0,0, downCanvas.width, downCanvas.height );
	}
}

function save_on_server() {
	document.getElementById( 'hidden_top' ).value = topCanvas.toDataURL( "image/png" );
	document.getElementById( 'hidden_down' ).value = downCanvas.toDataURL( "image/png" );
	var fd = new FormData( document.forms["form1"] );
	var xhr = new XMLHttpRequest();
	xhr.open( 'POST', '/application/php/save.php', true );
	xhr.send( fd );
	xhr.onreadystatechange = function(){
		if ( xhr.readyState === 4 && xhr.status == 200 ) {
			var elem =  JSON.parse( xhr.responseText );

			var thumb = document.getElementById( 'thumb' );
			var obj = document.createElement( 'div' );
			obj.classList.add( 'preview' );

			div = document.createElement( 'div' );
			div.classList.add( 'eraser' );
			text = document.createTextNode( 'delete' );
			div.appendChild( text );
			obj.appendChild( div );

			var img = document.createElement( "img" );
			img.src = elem['file_path'];
			obj.appendChild( img );

			div = document.createElement( 'div' );
			text = document.createTextNode( elem['date_create'] );
			div.appendChild( text );
			obj.appendChild( div );
			obj.addEventListener('click', deleteImg, false);
			thumb.insertBefore(obj, thumb.firstChild);
		}
	};
	schnelleReporter( 'Photo succesfully upload!', null );
	discard();
};

function upload_from_desktop( event ) {
	var file = event.target.files[0];
	if ( file ) {
		var reader = new FileReader();
		reader.onload = ( function( theFile ) {
			var dataURL = reader.result;
			var substr = dataURL.substring(5, dataURL.indexOf('/'));
			console.log(substr);
			if (substr != "image")
				return;
			uploadImg.src = dataURL;
			uploadImg.onload = function() {
				downCtx.drawImage( uploadImg, 0,0, downCanvas.width, downCanvas.height );
			}
		});
		reader.readAsDataURL( file );
	} else {
		uploadImg.removeAttribute( "src" );
		discard();
	}
}

function detect( elem ) {
	x = event.clientX - 110;
	y = event.clientY - 20;
	x += (elem.width / 2);
	do {
		if ( !isNaN( elem.offsetLeft ))
			x -= elem.offsetLeft;
		if ( !isNaN( elem.offsetTop ))
			y -= elem.offsetTop;
	} while ( elem = elem.offsetParent );
	topCtx.clearRect( 0,0, topCanvas.width, topCanvas.height );
	document.getElementById( 'save' ).style.display = "none";
	topCtx.drawImage( img, x,y, 226, 100 );
}

var thumbs = new XMLHttpRequest;
var pctrs;
thumbs.onreadystatechange = function(){
	if ( thumbs.readyState === 4 && thumbs.status === 200 ) {
		pctrs = JSON.parse( thumbs.responseText );
		pctrs.forEach( function( elem ){
			var thumb = document.getElementById('thumb');
			var obj = document.createElement( 'div' );
			obj.classList.add( 'preview' );

			div = document.createElement( 'div' );
			div.classList.add( 'eraser' );
			text = document.createTextNode( 'delete' );
			div.appendChild( text );
			obj.appendChild( div );

			var img = document.createElement( "img" );
			img.src = elem['file_path'];
			obj.appendChild( img );

			div = document.createElement( 'div' );
			text = document.createTextNode( elem['date_create'] );
			div.appendChild( text );
			obj.appendChild( div );
			obj.addEventListener('click', deleteImg, false);
			thumb.insertBefore(obj, thumb.firstChild);
		});
	}
};
thumbs.open( 'POST', '/application/php/get_user_pictures.php', true );
thumbs.setRequestHeader( "Content-Type", "application/json" );
thumbs.send();

function deleteImg() {
	if (confirm('You realy want delete this picture (for ever)?') == true) {
		for ( var node of this.childNodes.values() ) {
			if ( node.tagName == 'IMG' ) {
				var delreq = new XMLHttpRequest;
				delreq.open( 'POST', '/application/php/rem_img_from_db.php', true );
				delreq.setRequestHeader( "Content-Type", "application/json" );
				delreq.send( JSON.stringify( node.src ));
			}
		}
		this.remove();
	}
}
