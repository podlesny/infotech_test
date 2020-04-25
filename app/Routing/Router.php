<?php

class Router{

	protected $routes;

	public function __construct($routes){
		$this->routes = $routes;
	}

	public function dispatch(){
		$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
			foreach($this->routes as $route){
				$r->addRoute(...$route);
			}
		});
		
		$httpMethod = $_SERVER['REQUEST_METHOD'];
		$uri = $_SERVER['REQUEST_URI'];
		
		if (false !== $pos = strpos($uri, '?')) {
			$uri = substr($uri, 0, $pos);
		}
		$uri = rawurldecode($uri);
		
		$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
		switch ($routeInfo[0]) {
			case FastRoute\Dispatcher::NOT_FOUND:{
				echo json_encode(['status' => 'error', 'error_code' => 404, 'error_message' => 'Not Found']);
			}
			break;
			case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:{
				echo json_encode(['status' => 'error', 'error_code' => 405, 'error_message' => 'Method Not Allowed']);
			}
			break;
			case FastRoute\Dispatcher::FOUND:{
				$handler = $routeInfo[1];
				$params = array_merge($routeInfo[2], $_GET);
				$handler($params);
			}
			break;
		}
	}

}