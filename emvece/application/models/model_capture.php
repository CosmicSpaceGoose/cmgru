<?php

class Model_Capture extends Model {
	public function get_data() {
		$result = db_query_select("imgId, name", "images", NULL);
		return ( $result );
	}
	public function get_user( $username ) {
		$result = db_query_select("*", "users", "`username` = '".$username."' AND `confirm` = 1");
		if ( count( $result ) == 0)
			return ( false );
		return ( true );
	}
}

?>