<div id="gallery">
	
</div>
<script type="text/javascript">
var xhrq = new XMLHttpRequest;
var arr;
xhrq.onreadystatechange = function(){
	if (xhrq.readyState === 4 && xhrq.status === 200) {
		arr = JSON.parse( xhrq.responseText );
		var parent = document.getElementById( 'gallery' );
		arr.forEach( function( elem ) {
			var obj = document.createElement( 'div' );
			obj.classList.add = 'container';
			var text = document.createTextNode(elem['id']);
			obj.appendChild( text );
			img = document.createElement( "img" );
			img.src = elem['file_path'];
			obj.appendChild( img );
			text = document.createTextNode(elem['username']);
			obj.appendChild( text );
			text = document.createTextNode(elem['comments']);
			obj.appendChild( text );
			parent.appendChild( obj );
		});
	}
};
xhrq.open( 'POST', 'php/mysql_get_data.php', true );
xhrq.setRequestHeader( "Content-Type", "application/json" );
xhrq.send( JSON.stringify( ["*", "pictures"] ) );
</script>