<?php

class Controller_Auth extends Controller {

	function __construct() {
		$this->model = new Model_Auth();
		$this->view = new View();
	}

	function action_index() {
		if ( isset( $_GET['frm'] ))
			$this->view->generate( 'view_auth.php', 'template.php', null );
		else
			header( "Location: /landing/404" );
	}

	function action_login() {
		if ( $_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'login' )
		{
			$data = $this->model->get_data( 'login' );
			if ( isset( $data ))
				$this->view->generate( 'view_auth.php', 'template.php', $data );
			else
				header( "Location: /landing" );
		} else {
			header( "Location: /auth?frm=login" );
		}
	}

	function action_signup() {
		if ( $_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'signup' )
		{
			$data = $this->model->get_data( 'signup' );
			if ( isset( $data ))
				$this->view->generate( 'view_auth.php', 'template.php', $data );
			else
				$this->view->generate( 'view_massage.php', 'template.php', 'Your acount was created. Please activate it by clickin on the link in mail, that we send into your e-mail.' );
		} else {
			header( "Location: /auth?frm=signup" );
		}
	}

	function action_logout() {
		$_SESSION["loggued_on_user"] = "";
		$_SESSION["uid"] = 0;
		header( "Location: /" );
	}

	function action_verify() {
		if ( $_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['mail'] ) && isset( $_GET['ps'] )) {
			$data = $this->model->get_data( 'verify' );
			if ( $data == true ) {
				$this->view->generate( 'view_massage.php', 'template.php', 'Your acount was succesfully activated. Now you can fully use all capabilities. Enjoy.' );
			} else {
				header( "Location: /landing/404" );
			}
		} else {
			header( "Location: /landing/404" );
		}
	}

	function action_reset() {
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit'] == 'reset' ) {
			$data = $this->model->get_data( 'reset_req' );
			if ( isset( $data )) {
				$this->view->generate( 'view_auth.php', 'template.php', $data );
			} else {
				$this->view->generate( 'view_massage.php', 'template.php', 'Your request was accepted and mail with instructions was sent into your mail box.' );
			}
		} else {
			header( "Location: /landing/404" );
		}
	}

	function action_vereset() {
		if ( $_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['mail'] ) && isset( $_GET['ps'] )) {
			$data = $this->model->get_data( 'reset' );
			if ( $data == true ) {
				$this->view->generate( 'view_massage.php', 'template.php', 'Your password was reset. Check your mail, we sent new password for you. Have a nice day.' );
			} else {
				header( "Location: /landing/404" );
			}
		} else {
			header( "Location: /landing/404" );
		}
	}
}

?>