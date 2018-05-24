<?php

function auth($login, $passwd) {
	$tab = unserialize(file_get_contents("/Users/dlinkin/http/MyWebSite/d04/htdocs/private/passwd"));
	foreach ($tab as $val) {
		if ($val["login"] == $login) {
			if ($val["passwd"] == hash("whirlpool", $passwd))
				return (true);
			return (false);
		}
	}
	return (false);
}

?>