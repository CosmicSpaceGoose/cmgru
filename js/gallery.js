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

function findPage(){
	var url = window.location.href;
	var rat;
	if ( url.indexOf( '?' ) == -1 )
		return ( 1 );
	var query = url.substring( url.indexOf( '?' ) + 1, url.length );
	var qarr = query.split( '&' );
	var i = 0;
	while ( qarr[i] != 'undefined' ) {
		if (qarr[i].substring( 0, qarr[i].indexOf( '=' )) == 'page' ) {
			rat = qarr[i].substring( qarr[i].indexOf( '=' ) + 1, qarr[i].length);
			if ( rat.length > 0 )
				return ( parseInt( rat ));
		}
		i++;
	}
	return ( 1 );
};
var page = findPage();

function jumpTo( event ) {
	var cmd = event.target.getAttribute('id');
	switch( cmd ) {
		case 'prev':
			if (page > 1) {
				page--;
				window.location.href = '/gallery?page=' + page;
			}
			break;
		case 'next':
			if ( page * 6 < arr.length ) {
				page++;
				window.location.href = '/gallery?page=' + page;
			}
			break;
		case 'jump':
			if (event.keyCode === 13) {
				var num = event.target.value;
				if ( Number.isInteger( parseFloat( num )) ) {
					page = parseInt( num );
					if ( page < 1 )
						page = 1;
					else if ( page > Math.floor( (arr.length - 1) / 6 ) + 1 )
						page = Math.floor( (arr.length - 1) / 6 ) + 1;
					window.location.href = '/gallery?page=' + page;
				}
			}
			break;
	}
}
document.getElementById('prev').addEventListener( 'click', jumpTo );
document.getElementById('jump').addEventListener( 'keydown', jumpTo );
document.getElementById('next').addEventListener( 'click', jumpTo );

var arr;
var xhrq = new XMLHttpRequest;
xhrq.onreadystatechange = function(){
	if (xhrq.readyState === 4 && xhrq.status === 200) {
		arr = JSON.parse( xhrq.responseText );
		arr.reverse();
		var comrq = new XMLHttpRequest;
		var comms;
		comrq.onreadystatechange = function() {
			if (comrq.readyState === 4 && comrq.status === 200) {
				comms = JSON.parse( comrq.responseText );
				var parent = document.getElementById( 'gallery' );
				var page_num = Math.floor( (arr.length - 1) / 6 ) + 1;
				if ( page_num < page )
					page = page_num;
				document.getElementById('jump').setAttribute('placeholder',
					page + '/' + page_num);
				var i = (page - 1) * 6;
				while ( arr[i] && i < page * 6 ) {
					var obj = document.createElement( 'div' );
					obj.classList.add( 'ultracontainer' );
					obj.setAttribute( 'id', i );

					var img = document.createElement( "img" );
					img.src = arr[i]['file_path'];
					obj.appendChild( img );

					var div = document.createElement( 'div' );
					var bold = document.createElement( 'b' );
					var ital = document.createElement( 'i' );
					text = document.createTextNode( arr[i]['username'] );
					ital.appendChild( text );
					bold.appendChild( ital );
					div.appendChild( bold );
					obj.appendChild( div );

					div = document.createElement( 'div' );
					text = document.createTextNode( arr[i]['date_create'] );
					div.appendChild( text );
					obj.appendChild( div );

					var cont = document.createElement( 'div' );
					cont.classList.add( 'container' );
					{
						div = document.createElement( 'div' );
						div.classList.add( 'like' );
						div.addEventListener( 'click', whoIsThere );
						text = document.createTextNode( '+' + arr[i]['likes']);
						div.appendChild( text );
						cont.appendChild( div );

						div = document.createElement( 'div' );
						div.classList.add( 'dislike' );
						div.addEventListener( 'click', whoIsThere );
						text = document.createTextNode( '-' + arr[i]['dislikes'] );
						div.appendChild( text );
						cont.appendChild( div );

						div = document.createElement( 'div' );
						div.classList.add( 'comment' );
						div.addEventListener( 'click', whoIsThere );
						text = document.createTextNode( String.fromCharCode( 0x270E ));
						div.appendChild( text );
						cont.appendChild( div );
					}
					obj.appendChild( cont );

					div = document.createElement( 'div' );
					div.classList.add( 'compost' );
					if ( comms != 'undefined') {
						comms.forEach(function( elem ){
							if ( elem['pictId'] == arr[i]['pictId']) {
								var com = document.createElement( 'div' );
								com.classList.add( 'compost_elem' );
								text = document.createTextNode( elem['username'] );
								var bold = document.createElement( 'b' );
								bold.appendChild( text );
								com.appendChild( bold )
								text = document.createTextNode( ' at '+elem['posted'] );
								com.appendChild( text );
								var ital = document.createElement( 'i' );
								text = document.createTextNode( ' -'+elem['comment'] );
								ital.appendChild( text );
								com.appendChild( ital );
								div.appendChild( com );
							}
						});
					}
					obj.appendChild(div);

					parent.appendChild( obj );
					i++;
				}
			}
		}
		comrq.open( 'POST', '/application/php/mysql_get_data.php', true );
		comrq.setRequestHeader( "Content-Type", "application/json" );
		comrq.send( JSON.stringify( ["*", "comments, users", "comments.uid = users.userId" ]));
	}
};
xhrq.open( 'POST', '/application/php/mysql_get_data.php', true );
xhrq.setRequestHeader( "Content-Type", "application/json" );
xhrq.send( JSON.stringify(["*", "pictures, users", "pictures.uid = users.userId"]) );

function whoIsThere( event ) {
	var who = new XMLHttpRequest;
	who.open( 'POST', '/application/php/who.php', true );
	who.setRequestHeader( "Content-Type", "application/json" );
	who.send();
	who.onreadystatechange = function(){
		if ( who.readyState === 4 && who.status === 200 ) {
			if ( who.responseText == 1)
			{
				var cmd = event.target.getAttribute('class');
				switch( cmd ) {
					case 'like':
						increaseLD(event.target.parentNode.parentNode
					.getAttribute( 'id' ), event.target, 'likes', '+');
						break;
					case 'dislike':
						increaseLD(event.target.parentNode.parentNode
					.getAttribute( 'id' ), event.target, 'dislikes', '-');
						break;
					case 'comment':
						addComment( event.target.parentNode.parentNode
					.getAttribute( 'id' ));
						break;
				}
			}
		}
	}
}

function addComment( id ) {
	var pictId = arr[id]['pictId'];
	var request = new XMLHttpRequest;
	var rat;
	var comText = prompt('What would You like to type under this picture? (less then 100 symbols)', '').trim();
	if ( comText && comText != '') {
		request.open( 'POST', '/application/php/add_comment.php', true );
		request.setRequestHeader( "Content-Type", "application/json" );
		request.send( JSON.stringify( [ pictId, comText ]));
		request.onreadystatechange = function(){
			if (request.readyState === 4 && request.status === 200) {
				rat = JSON.parse( request.responseText );
				var com = document.createElement( 'div' );
				com.classList.add( 'compost_elem' );
				var text = document.createTextNode( rat['username'] );
				var bold = document.createElement( 'b' );
				bold.appendChild( text );
				com.appendChild( bold )
				text = document.createTextNode( ' at ' + rat['posted'] );
				com.appendChild( text );
				var ital = document.createElement( 'i' );
				text = document.createTextNode( ' -'+rat['comment'] );
				ital.appendChild( text );
				com.appendChild( ital );
				document.getElementById( id ).getElementsByClassName( 'compost' )[0]
					.appendChild( com );
			}
		}
	}
}

function increaseLD( id, obj, field, sign ) {
	var pictId = arr[id]['pictId'];
	var num = parseInt(arr[id][field]) + 1;
	obj.innerHTML = sign + num;
	var request = new XMLHttpRequest;
	request.open( 'POST', '/application/php/update_with_json.php', true );
	request.setRequestHeader( "Content-Type", "application/json" );
	request.send( JSON.stringify( [ field, "`pictures`",
		'`pictId` = \'' + pictId + '\'' ]));
	request.onreadystatechange = function(){
		if ( request.readyState === 4 && request.status === 200 ) {
			obj.innerHTML = sign + request.responseText;
		}
	}
}

