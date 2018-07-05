<?php

class Model_Account extends Model {

	public function get_data( $user ) {
		$request = db_query_select('*', 'users', '`username` = \''.$user.'\'');
		return ($request[0]);
	}

	public function update() {
		if ( $_POST['submit'] == 'mail' )
			return ($this->update_mail());
		else if ( $_POST['submit'] == 'name' )
			return ($this->update_name());
		else if ( $_POST['submit'] == 'pass' )
			return ($this->update_pass());
	}

	private function update_mail() {
		$data = array();
		$mail = $this->cook_str( $_POST['email'] );
		if (!filter_var( $mail, FILTER_VALIDATE_EMAIL ))
			$data['mailErr'] = "Invalid e-mail adress.";
		else
		{
			$request = db_query_select( "*", "users", "email = '".$mail."'" );
			if ( empty( $mail ))
				$data['mailErr'] = "E-mail reqired";
			else if ( count( $request ) > 0)
				$data['mailErr'] = "E-mail already registered.";
		}
		if ( isset( $data['mailErr'] ))
		{
			if ( isset($_POST['notify']) )
				$data['reply'] = 1;
			return ( $data );
		}
		db_query_update(
				"`users`",
				array( "email" ),
				array( "email" => $mail ),
				"`username`='".$_SESSION['loggued_on_user']."'"
		);
		return ( null );
	}

	private function update_name() {
		$data = array();
		$name = $this->cook_str( $_POST['username'] );
		$request = db_query_select( "*", "users", "username = '".$name."'" );
		if ( empty( $name ))
			$data['nameErr'] = "Username reqired.";
		else if ( strlen( $name ) < 4)
			$data['nameErr'] = "Must be more then 4 symbols.";
		else if ( strlen( $name ) > 30)
			$data['nameErr'] = "Whoa, chose shortener username.";
		else if ( count( $request ) > 0)
			$data['nameErr'] = "Username already in use.";
		if ( isset( $data['nameErr'] ))
		{
			if ( isset($_POST['notify']) )
				$data['reply'] = 1;
			return ( $data );
		}
		db_query_update(
				"`users`",
				array( "username" ),
				array( "username" => $name ),
				"`username`='".$_SESSION['loggued_on_user']."'"
		);
		$_SESSION['loggued_on_user'] = $name;
		return ( null );
	}

	private function update_pass() {
		$data = array();
		$request = db_query_select( "*", "users", "username = '".$_SESSION['loggued_on_user']."'" );
		if ( empty( $_POST['oldpass'] ))
			$data['psswdErr'] = "Old password required.";
		if ( empty( $_POST['newpass'] ))
			$data['psswdErr'] = "New password required.";
		if ( empty( $_POST['conpass'] ))
			$data['psswdErr'] = "Confirm password required.";
		if ( hash( 'whirlpool', $_POST['oldpass'] ) != $request[0]['password'] )
			$data['psswdErr'] = "Incorect password";
		if ( strlen( $_POST['newpass'] ) < 6)
			$data['psswdErr'] = "Must be more then 6 symbols.";
		if ( $_POST['newpass'] == $_POST['oldpass'] )
			$data['psswdErr'] = "Old and new passwords equal.";
		if ( $_POST['newpass'] != $_POST['conpass'] )
			$data['psswdErr'] = "Passwords are not equal.";
		if ( isset( $data['psswdErr'] ))
		{
			if ( isset($_POST['notify']) )
				$data['reply'] = 1;
			return ( $data );
		}
		db_query_update(
				"`users`",
				array( "password" ),
				array( "password" => hash('whirlpool', $_POST['newpass'] )),
				"`username`='".$_SESSION['loggued_on_user']."'"
		);
		return ( null );
	}

	private function cook_str( $str ) {
		$rat = trim($str);
		$rat = stripslashes($rat);
		$rat = htmlspecialchars($rat, ENT_QUOTES, "UTF-8");
		return ($rat);
	}

	public function resent_mail() {
		$request = db_query_select( "*", "users", "username = '".$_SESSION['loggued_on_user']."'" )[0];
		$link = "http://".$_SERVER["HTTP_HOST"]."/auth/verify?mail=".$request['email']."&ps=".$request['password'];
		$mail_subject = "Validate account";
		$mail_message = "
		Please verify account by clicking on link below.
		If you recieve this message by mistake or think that it is suspussious,
		just ignore it.<br>
		<a href=\"".$link."\">Activation link</a>
		";
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
		mail($request['email'], $mail_subject, $mail_message, $header);
	}
}

?>