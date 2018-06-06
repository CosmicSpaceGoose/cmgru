<?php

class View
{
	public $templateView = 'view_landing.php';
	
	function generate($contentView, $templateView, $data = null)
	{
		if ( is_array( $data ) ) {
			extract( $data );
		}
		include 'application/views/'.$templateView;
	}
}

?>