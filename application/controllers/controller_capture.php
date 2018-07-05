<?php

class Controller_Capture extends Controller {
	function __construct() {
		$this->model = new Model_Capture();
		$this->view = new View();
	}

	function action_index() {
		if (isset( $_SESSION['loggued_on_user'] ) && $_SESSION['loggued_on_user'] !== "")
		{
			$data = $this->model->get_user( $_SESSION['loggued_on_user'] );
			if ( $data == true ) {
				$data = $this->model->get_data();
				$this->view->generate( 'view_capture.php', 'template.php', $data );
			} else {
				$this->view->generate( 'view_massage.php', 'template.php', 'Sorry, but you aren\'t verificate your email, please check mail box.' );
			}
		}
		else
			$this->view->generate( 'view_massage.php', 'template.php', 'Sorry, but you aren\'t authorized to use this page.' );
	}
}

?>