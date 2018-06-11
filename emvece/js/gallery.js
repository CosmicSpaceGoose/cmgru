// ************************************************************************** //
//                                                                            //
//                                                        :::      ::::::::   //
//   gallery.js                                         :+:      :+:    :+:   //
//                                                    +:+ +:+         +:+     //
//   By: dlinkin <marvin@42.fr>                     +#+  +:+       +#+        //
//                                                +#+#+#+#+#+   +#+           //
//   Created: 2018/06/08 16:00:20 by dlinkin           #+#    #+#             //
//   Updated: 2018/06/08 16:00:21 by dlinkin          ###   ########.fr       //
//                                                                            //
// ************************************************************************** //

function getAllComments() {
	var comrq = new XMLHttpRequest;
	var rat;
	comrq.open( 'POST', '/application/php/mysql_get_data.php', false );
	comrq.setRequestHeader( "Content-Type", "application/json" );
	comrq.send( JSON.stringify( ["*", "comments", null ]));
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
			var img = document.createElement( "img" );
			img.src = elem['file_path'];
			obj.appendChild( img );
			var div = document.createElement( 'div' );
			text = document.createTextNode( elem['username'] );
			div.appendChild( text )
			obj.appendChild( div );
			div = document.createElement( 'div' );
			text = document.createTextNode( elem['date_create'] );
			div.appendChild( text )
			obj.appendChild( div );
			com.forEach( function( cmnt ) {
				if ( cmnt['pictId'] == elem['pictId'] ) {
					div = document.createElement( 'div' );
					text = document.createTextNode( cmnt['comment'] );
					div.appendChild( text );
					obj.appendChild( div );
					div = document.createElement( 'div' );
					text = document.createTextNode( cmnt['posted'] );
					div.appendChild( text );
					obj.appendChild( div );
					div = document.createElement( 'div' );
					text = document.createTextNode( cmnt['username'] );
					div.appendChild( text );
					obj.appendChild( div );
				}
			});
			parent.appendChild( obj );
		});
	}
};
xhrq.open( 'POST', '/application/php/mysql_get_data.php', true );
xhrq.setRequestHeader( "Content-Type", "application/json" );
xhrq.send( JSON.stringify( [ "*", "pictures", null ]));
