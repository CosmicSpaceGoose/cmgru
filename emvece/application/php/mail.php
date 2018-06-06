<?php
$mail_to = 'dim13@i.ua';
$mail_subject = 'Validate email';
$encoding = "utf-8";
$mail_message = 'TEST';

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

if (mail($mail_to, $mail_subject, $mail_message, $header) == false)
	echo "something went wrong";
else
	echo "mail are sent";
?>