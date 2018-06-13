<?php

class Controller_Landing extends Controller {

	function action_index() {
		$this->view->generate('view_landing.php', 'template.php');
	}

	function action_404() {
		$this->view->generate('view_404.php', 'template.php');
	}
}

?>