<?php

class Model_Auth extends Model {

	public function get_data( $str ) {
		if ( $str == 'login' ) {
			return ( $this->validate_login() );
		} else if ( $str == 'signup' ) {
			return ( $this->validate_signup() );
		} else if ( $str == 'verify' ) {
			return ( $this->validate_account() );
		} else if ( $str == 'reset_req' ) {
			return ( $this->reset_req() );
		} else if ( $str == 'reset' ) {
			return ( $this->reset() );
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
		$cook = $this->cook_str( $_POST['email'] );
		$request = db_query_select( "*", "`users`", "`email` = '".$cook."'" );
		if ( isset( $request[0] ))
		{
			if ($request[0]['password'] == hash('whirlpool', $cook.$_POST['password']))
				$_SESSION["loggued_on_user"] = $request[0]['username'];
			else
				$data['logErr'] = "Incorect password";
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
		$cook = $this->cook_str( $_POST['username'] );
		$request = db_query_select( "*", "users", "username = '".$cook."'" );
		if ( empty( $cook ))
			$data['nameErr'] = "Username reqired.";
		else if ( strlen( $cook ) < 4)
			$data['nameErr'] = "Must be more then 4 symbols.";
		else if ( strlen( $cook ) > 30)
			$data['nameErr'] = "Whoa, chose shortener username.";
		else if ( count( $request ) > 0)
			$data['nameErr'] = "Username already in use.";
		else
			$name = $cook;
		$cook = $this->cook_str( $_POST['email'] );
		$request = db_query_select( "*", "users", "email = '".$cook."'" );
		if ( empty( $cook ))
			$data['mailErr'] = "E-mail reqired";
		else if (!filter_var( $cook, FILTER_VALIDATE_EMAIL ))
			$data['mailErr'] = "Invalid e-mail adress.";
		else if ( count( $request ) > 0)
			$data['mailErr'] = "E-mail already registered.";
		else
			$mail = $cook;
		if (empty( $_POST['password'] ))
			$data['psswdErr'] = "Password required.";
		else if ( strlen( $_POST['password'] ) < 6)
			$data['psswdErr'] = "Must be more then 6 symbols.";
		else if ( $_POST['password'] !== $_POST['sign_cnfrm'] )
			$data['psswdErr'] = "Passwords are not equal.";
		else
			$psswd = hash('whirlpool', $mail.$_POST['password']);
		if ( !isset( $data['nameErr'] ) && !isset( $data['psswdErr'] ) && !isset( $data['mailErr'] )) {
			db_query_insert( "`users`",
				array( "username", "password", "email" ),
				array( "username" => $name, "password" => $psswd, "email" => $mail ));
			$link = "http://localhost:8102/auth/verify?mail=".$mail."&ps=".$psswd;
			$message = "
			Please verify account by clicking on link below.
			If you recieve this message by mistake or think that it is suspussious,
			just ignore it.<br>
			<a href=\"".$link."\">Activation link</a>
			";
			$this->mail_sender( $mail, 'Validate account', $message );
			return ( null );
		}	
		$data['frm'] = 'signup';
		return ( $data );
	}

	private function validate_account() {
		$request = db_query_select( "*", "users", "email = '".$_GET['mail']."'" );
		if ( count( $request ) > 0 ) {
			if ( $request[0]['password'] == $_GET['ps']) {
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

	private function reset_req() {
		$data = array();
		$mail = $this->cook_str( $_POST['email'] );
		$request = db_query_select( "*", "`users`", "`email` = '".$mail."'" );
		if ( isset( $request[0] )) {
			$link = "http://localhost:8102/auth/vereset?mail=".$mail."&ps=".hash('whirlpool', $request[0]['userId'].$request[0]['password'] );
			$message = "
			Clicking on the link below you will reset your password.
			If you recieve this message by mistake or changed your mind,
			just ignore it.<br>
			<a href=\"".$link."\">Reset link</a>
			";
			$this->mail_sender( $mail, 'Reset password request', $message );
			return ( null );
		}
		$data['mailErr'] = "No such e-mail adress.";
		$data['frm'] = 'reset';
		return ( $data );
	}

	private function reset() {
		$request = db_query_select( "*", "users", "email = '".$_GET['mail']."'" );
		if ( count( $request ) > 0 ) {
			if ( hash( 'whirlpool', $request[0]['userId'].$request[0]['password'] == $_GET['ps'] ) ) {
				$new = urlencode(base64_encode(random_bytes( 16 )));
				$message = "
				Your new password:<br>".$new;
				$this->mail_sender( $_GET['mail'], 'New Pass', $message );
				db_query_update(
					"`users`",
					array( "password" ),
					array( "password" => hash( 'whirlpool', $_GET['mail'].$new )),
					"`email`='".$_GET['mail']."'"
				);
				return ( true );
			}
		}
		return ( false );
	}

	private function mail_sender( $mail_to, $mail_subject, $mail_message ) {
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
}
?>