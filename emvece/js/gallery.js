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
	comrq.open( 'POST', '/application/php/mysql_get_data.php', true );
	comrq.setRequestHeader( "Content-Type", "application/json" );
	comrq.send( JSON.stringify( ["*", "comments", null ]));
	if (comrq.readyState === 4 && comrq.status === 200) {
		rat = JSON.parse( comrq.responseText );
	}
	return (rat);
}

