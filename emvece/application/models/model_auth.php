<?php
class Model_Auth extends Model {
	public function get_data( $str ) {
		include_once "application/php/mysql_cheak.php";
		if ( $str == 'login' ) {
			return ( $this->validate_login() );
		} else if ( $str == 'signup' ) {
			return ( $this->validate_signup() );
		} else if ( $str == 'verify' ) {
			return ( $this->validate_account() );
		}
		return ( null );
	}
	private function cook_str( $str ) {
		$rat = trim($str);
		$rat = stripslashes($rat);
		$rat = htmlspecialchars($rat);
		return ($rat);
	}
	private function validate_login() {
		$data = array();
		$request = db_query_select( "*", "`users`", "`email` = '".$_POST['email']."'" );
		if ( isset( $request[0] ))
		{
			if ($request[0]['password'] == hash('whirlpool', $_POST['email'].$_POST['password']))
				$_SESSION["loggued_on_user"] = $request[0]['username'];
			else
				$data['logErr'] = "incorect password";
		}
		else
			$data['logErr'] = "incorect e-mail";
		if ( !isset( $data['logErr'] ))
			return ( null );
		$data['frm'] = 'login';
		return ( $data );
	}
	private function validate_signup() {
		$data = array();
		$request = db_query_select( "*", "users", "username = '".$_POST['username']."'" );
		if ( empty( $this->cook_str( $_POST['username'] )))
			$data['nameErr'] = "Username reqired.";
		else if ( strlen( $this->cook_str( $_POST['username'] )) < 4)
			$data['nameErr'] = "Must be more then 4 symbols.";
		else if ( strlen( $this->cook_str( $_POST['username'] )) > 30)
			$data['nameErr'] = "Whoa, chose shortener username.";
		else if ( count( $request ) > 0)
			$data['nameErr'] = "Username already in use.";
		else
			$name = $this->cook_str( $_POST['username'] );
		$request = db_query_select( "*", "users", "email = '".$_POST['email']."'" );
		if ( empty( $_POST['email'] ))
			$data['mailErr'] = "E-mail reqired";
		else if (!filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ))
			$data['mailErr'] = "Invalid e-mail adress.";
		else if ( count( $request ) > 0)
			$data['mailErr'] = "E-mail already registered.";
		else
			$mail = $_POST['email'];
		if (empty( $_POST['password'] ))
			$data['psswdErr'] = "Password required.";
		else if ( strlen( $_POST['password'] ) < 6)
			$data['psswdErr'] = "Must be more then 6 symbols.";
		else if ( $_POST['password'] !== $_POST['sign_cnfrm'] )
			$data['psswdErr'] = "Passwords are not equal.";
		else
			$psswd = hash('whirlpool', $_POST['email'].$_POST['password']);
		if ( !isset( $data['nameErr'] ) && !isset( $data['psswdErr'] ) && !isset( $data['mailErr'] )) {
			db_query_insert( "`users`",
				array( "username", "password", "email" ),
				array( "username" => $name, "password" => $psswd, "email" => $mail ));
			$mail_subject = 'Validate email';
			$encoding = "utf-8";
			$link = "http://localhost:8102/auth/verify?mail=".$mail."&ps=".$psswd;
			$mail_message = "
			Please verify account by clicking on link below.
			If you recieve this message by mistake or think that it is suspussious,
			just ignore it.<br>
			<a href=\"".$link."\">Activation link</a>
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
			mail($mail, $mail_subject, $mail_message, $header);
			return ( null );
		}	
		$data['frm'] = 'signup';
		return ( $data );
	}
	private function validate_account() {
		$request = db_query_select( "*", "users", "email = '".$_GET['mail']."'" );
		if (count($request) > 0) {
			if ($request[0]['password'] == $_GET['ps']) {
				db_query_update(
					"`users`",
					array( "confirm" ),
					array( "confirm" => 1 ),
					"`email`='".$_GET['mail']."'"
				);
				return ( true );
			}
		}
		return ( false );
	}
}
?>