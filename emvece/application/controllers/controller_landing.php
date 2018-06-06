<?php

class Controller_Landing extends Controller {
	function action_index() {
		$this->view->generate('view_landing.php', 'template.php');
	}
}

?>