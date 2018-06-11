<?php

class Controller_Gallery extends Controller {
	function action_index() {
		$this->view->generate('view_gallery.php', 'template.php');
	}
}

?>