<?php

class Controller_Capture extends Controller {
	function __construct() {
		$this->model = new Model_Capture();
		$this->view = new View();
	}
	function action_index() {
		$data = $this->model->get_data();
		$this->view->generate('view_capture.php', 'template.php', $data);
	}
}

?>