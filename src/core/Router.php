<?php

class Router {
    private $routes = [];
    private $container;

    public function __construct($container = null) {
        $this->container = $container;
    }

    public function add($method, $uri, $controller, $methodName, $middleware = []) {
        $this->routes[] = [
            'http_method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'method' => $methodName,
            'middleware' => $middleware
        ];
    }

    public function dispatch($uri, $httpMethod) {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['http_method'] === $httpMethod) {
                
                // Izpildām Middleware
                foreach ($route['middleware'] as $middlewareClass) {
                    if (class_exists($middlewareClass)) {
                        $middleware = new $middlewareClass();
                        $middleware->handle($this->container);
                    }
                }

                $controllerName = $route['controller'];
                $methodName = $route['method'];

                if (class_exists($controllerName)) {
                    $controller = new $controllerName($this->container);
                    if (method_exists($controller, $methodName)) {
                        return $controller->$methodName();
                    }
                }

            }
        }

        $this->abort(404);
    }

    private function abort($code = 404, $message = "Lappuse nav atrasta") {
        http_response_code($code);
        echo "$code - $message";
        exit;
    }
}
