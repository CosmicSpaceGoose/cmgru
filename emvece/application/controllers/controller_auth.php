<?php

class Controller_Auth extends Controller {
	function __construct() {
		$this->model = new Model_Auth();
		$this->view = new View();
	}
	function action_index() {
		$this->view->generate('view_auth.php', 'template.php', null);
	}
	function action_login() {
		if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'login')
		{
			$data = $this->model->get_data('login');
			if ( isset( $data ))
				$this->view->generate('view_auth.php', 'template.php', $data);
			else
				header("Location: /Landing");
		} else {
			header("Location: /auth?frm=login");
		}
	}
	function action_signup() {
		if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'signup')
		{
			$data = $this->model->get_data('signup');
			if ( isset( $data ))
				$this->view->generate('view_auth.php', 'template.php', $data);
			else
				header("Location: /auth?status=success");
		} else {
			header("Location: /auth?frm=signup");
		}
	}
	function action_logout() {
		$_SESSION["loggued_on_user"] = "";
		header("Location: /");
	}
	function action_verify() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['mail']) && isset($_GET['ps'])) {
			$data = $this->model->get_data('verify');
			if ( $data == true ) {
				header("Location: /auth?status=active");
			} else {
				header("Location: /landing/404");
			}
		} else {
			header("Location: /landing/404");
		}
	}
}

?>