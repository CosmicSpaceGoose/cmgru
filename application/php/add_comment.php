<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "application/php/mysql_cheak.php";
$data = file_get_contents("php://input");
$data = json_decode($data);
db_query_insert(
	'`comments`',
	array( 'pictId', 'uid', 'comment' ),
	array( 'pictId' => $data[0],
		'uid' => $_SESSION['uid'],
		'comment' => $data[1])
);
$rat = db_query_select('comments.posted, comments.comment, comments.pictId, users.username', 'comments, users', 'comments.uid = users.userId');
$arr = end($rat);
foreach ($arr as $key => $value) {
	error_log($key . ":" . $value);
}
$mail_to = db_get_mail_by_comment(end($rat)['pictId']);
if ( isset( $mail_to )) {
	$mail_subject = "New Comment";
	$mail_message = "You have a new comment from ".$_SESSION['loggued_on_user'].":\r\n-".$data[1];
			$encoding = "utf-8";
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
echo json_encode(end($rat));
?>