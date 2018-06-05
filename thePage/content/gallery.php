<div id="gallery">
</div>
<script type="text/javascript">

function getAllComments() {
	var comrq = new XMLHttpRequest;
	var rat;
	comrq.open( 'POST', 'php/mysql_get_data.php', false );
	comrq.setRequestHeader( "Content-Type", "application/json" );
	comrq.send( JSON.stringify( ["*", "comments", null] ) );
	if (comrq.readyState === 4 && comrq.status === 200) {
		rat = JSON.parse( comrq.responseText );
	}
	return (rat);
}

var xhrq = new XMLHttpRequest;
xhrq.onreadystatechange = function(){
	if (xhrq.readyState === 4 && xhrq.status === 200) {
		var arr = JSON.parse( xhrq.responseText );
		var com = getAllComments();
		var parent = document.getElementById( 'gallery' );
		arr.forEach( function( elem ) {
			var obj = document.createElement( 'div' );
			obj.classList.add( 'container' );
			var text = document.createTextNode( elem['pictId'] );
			obj.appendChild( text );
			img = document.createElement( "img" );
			img.src = elem['file_path'];
			obj.appendChild( img );
			text = document.createTextNode( elem['username']+"\n" );
			obj.appendChild( text );
			com.forEach( function( cmnt ) {
				if ( cmnt['pictId'] == elem['pictId'] ) {
					text = document.createTextNode( cmnt['comment']+"\n" );
					obj.appendChild( text );
					text = document.createTextNode( cmnt['posted']+"\n" );
					obj.appendChild( text );
					text = document.createTextNode( cmnt['username']+"\n" );
					obj.appendChild( text );
				}
			});
			parent.appendChild( obj );
		});
	}
};
xhrq.open( 'POST', 'php/mysql_get_data.php', true );
xhrq.setRequestHeader( "Content-Type", "application/json" );
xhrq.send( JSON.stringify( ["*", "pictures", null] ) );
</script>
