<?php

function mail_sender( $mail_to, $psswd ) {
	$mail_subject = 'Validate email';
	$encoding = "utf-8";
	error_log($mail_to);
	error_log($psswd);
	$mail_message = "
	Please verify account by clicking on link below.
	If you recieve this message by mistake or think that it is suspussious,
	just ignore it.
	<a href=\"localhost:8102/auth/verify?mail=".$mail_to."&ps=".$psswd"\">Activation link</a>
	";
	$subject_preferences = array(
		"input-charset" => $encoding,
		"output-charset" => $encoding,
		"line-length" => 76,
		"line-break-chars" => "\r\n"
	);
	$header = "Content-type: text/html; charset=".$encoding." \r\n";
	$header .= "From: dlinkin@student.unit.ua \r\n";
	$header .= "MIME-Version: 1.0 \r\n";
	$header .= "Content-Transfer-Encoding: 8bit \r\n";
	$header .= "Date: ".date("r (T)")." \r\n";
	$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

	mail($mail_to, $mail_subject, $mail_message, $header);
}

?>