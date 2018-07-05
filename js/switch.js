// ************************************************************************** //
//                                                                            //
//                                                        :::      ::::::::   //
//   switch.js                                          :+:      :+:    :+:   //
//                                                    +:+ +:+         +:+     //
//   By: dlinkin <marvin@42.fr>                     +#+  +:+       +#+        //
//                                                +#+#+#+#+#+   +#+           //
//   Created: 2018/06/14 13:12:48 by dlinkin           #+#    #+#             //
//   Updated: 2018/06/14 13:12:49 by dlinkin          ###   ########.fr       //
//                                                                            //
// ************************************************************************** //

function switchNotify( obj ) {
	var chck;
	if ( obj.hasAttribute( 'checked' ) == true ) {
		obj.removeAttribute( 'checked' );
		chck = 0;
	} else {
		obj.setAttributeNode( document.createAttribute( 'checked' ));
		chck = 1;
	}
	var xhrq = new XMLHttpRequest;
	xhrq.open( 'POST', '/application/php/change_state.php', true );
	xhrq.send( chck );
}
