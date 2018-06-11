<?php

class Controller_Capture extends Controller {
	function __construct() {
		$this->model = new Model_Capture();
		$this->view = new View();
	}
	function action_index() {
		$this->view->generate( 'view_capture.php', 'template.php' );
	}
	function action_cap() {
		if (isset( $_SESSION['loggued_on_user'] )	&& $_SESSION['loggued_on_user'] !== "")
		{
			$data = $this->model->get_user( $_SESSION['loggued_on_user'] );
			if ( $data == true ) {
				$data = $this->model->get_data();
				$this->view->generate( 'view_capture.php', 'template.php', $data );
			} else {
				header("Location: /capture?status=mail");
			}
		}
		else
			header("Location: /capture?status=reject");
	}
}

?>