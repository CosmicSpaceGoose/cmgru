<?php

class Model_Gallery extends Model {
	public function get_data() {
		$result = db_query_select("*", "pictures", NULL);
		return ( $result );
	}
}

?>
