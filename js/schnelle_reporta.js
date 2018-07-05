// ************************************************************************** //
//                                                                            //
//                                                        :::      ::::::::   //
//   schnelle_reporta.js                                :+:      :+:    :+:   //
//                                                    +:+ +:+         +:+     //
//   By: dlinkin <marvin@42.fr>                     +#+  +:+       +#+        //
//                                                +#+#+#+#+#+   +#+           //
//   Created: 2018/06/06 16:58:39 by dlinkin           #+#    #+#             //
//   Updated: 2018/06/06 16:58:40 by dlinkin          ###   ########.fr       //
//                                                                            //
// ************************************************************************** //

function schnelleReporter( string, location ) {
	var obj = document.getElementsByClassName( 'schnelleReporta' );
	if ( obj.length == 0 ) {
		savan = document.createElement( 'div' );
		savan.classList.add( 'savan' );
		obj = document.createElement( 'div' );
		obj.classList.add( 'schnelleReporta' );
		var text = document.createTextNode( string );
		obj.appendChild( text );
		var btn = document.createElement( 'button' );
		btn.appendChild( document.createTextNode( 'Omg, okaj' ) );
		btn.classList.add( 'btns' );
		btn.onclick = function() {
			document.body.removeChild( savan );
			if ( location !== null )
				window.location.href = location;
		};
		obj.appendChild( btn );
		savan.appendChild( obj );
		document.body.appendChild( savan );
	}
}

