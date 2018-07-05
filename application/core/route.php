<?php

class Route {
	static function start() {
		$controllerName = 'Landing';
		$actionName = 'index';

		$pos = strpos($_SERVER['REQUEST_URI'], '?');
		error_log($_SERVER['REQUEST_URI']);
		if ($pos == true)
			$routes = explode('/', substr($_SERVER['REQUEST_URI'], 0, $pos));
		else
			$routes = explode('/', $_SERVER['REQUEST_URI']);
		if ( !empty($routes[1]) )
			$controllerName = $routes[1];
		if ( !empty($routes[2]) )
			$actionName = $routes[2];

		$modelName = 'Model_' . $controllerName;
		$controllerName = 'Controller_' . $controllerName;
		$actionName = 'action_' . $actionName;

		$modelFile = strtolower( $modelName ) . '.php';
		$modelPath = 'application/models/' . $modelFile;
		if ( file_exists( $modelPath ) )
			include $modelPath;

		$controllerFile = strtolower( $controllerName ) . '.php';
		$controllerPath = 'application/controllers/' . $controllerFile;
		if ( file_exists( $controllerPath ) )
			include $controllerPath;
		else
			Route::ErrorPage404();

		$controller = new $controllerName;
		$action = $actionName;

		if ( method_exists( $controller, $action ) )
			$controller->$action();
		else
			Route::ErrorPage404();
	}

	function ErrorPage404() {
		$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		header('HTTP/1.1 404 Not Found');
		header('Status: 404 Not Found');
		header('Location:'.$host.'landing/404');
	}
}

?>
