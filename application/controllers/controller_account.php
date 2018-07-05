<?php

class Controller_Account extends Controller {
	function __construct() {
		$this->model = new Model_Account();
		$this->view = new View();
	}

	function action_index() {
		if ( isset( $_SESSION['loggued_on_user'] ) && $_SESSION['loggued_on_user'] != "" ) {
			$data = $this->model->get_data( $_SESSION['loggued_on_user'] );
			$this->view->generate( 'view_account.php', 'template.php', $data );
		} else {
			header( "Location: /landing/404" );
		}
	}

	function action_update() {
		if ( $_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if ( $_POST['submit'] == 'mail' || $_POST['submit'] == 'name' || $_POST['submit'] == 'pass' ) {
				$data = $this->model->update();
			} else if ( $_POST['submit'] == 'resent' ) {
				$this->model->resent_mail();
				header( "Location: /landing" );
				exit();
			} else {
				header( "Location: /landing/404" );
				exit();
			}
			if ( isset( $data ) && is_array( $data ))
				$this->view->generate( 'view_account.php', 'template.php', $data );
			else
				header( "Location: /account" );
		} else {
			header( "Location: /landing/404" );
		}
	}
}

?>