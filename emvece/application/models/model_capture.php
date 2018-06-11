<?php
class Model_Capture extends Model {
	public function get_data() {
		require_once "application/php/mysql_cheak.php";
		$result = db_query_select("imgId, name", "images", NULL);
		return ( $result );
	}
	public function get_user( $username ) {
		require_once "application/php/mysql_cheak.php";
		$result = db_query_select("*", "users", "`username` = '".$username."' AND `confirm` = 1");
		if ( count( $result ) == 0)
			return ( false );
		return ( true );
	}
}
?>