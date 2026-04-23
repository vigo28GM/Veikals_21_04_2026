<?php

class Router {
    private $routes = [];
    private $container;

    public function __construct($container = null) {
        $this->container = $container;
    }

    public function add($uri, $controller, $method, $middleware = []) {
        $this->routes[$uri] = [
            'controller' => $controller,
            'method' => $method,
            'middleware' => $middleware
        ];
    }

    public function dispatch($uri) {
        if (array_key_exists($uri, $this->routes)) {
            $route = $this->routes[$uri];
            
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
                    $controller->$methodName();
                } else {
                    $this->abort(404, "Metode $methodName netika atrasta kontrolierī $controllerName.");
                }
            } else {
                $this->abort(404, "Kontrolieris $controllerName netika atrasts.");
            }
        } else {
            $this->abort(404);
        }
    }

    private function abort($code = 404, $message = "Lappuse nav atrasta") {
        http_response_code($code);
        echo "$code - $message";
        exit;
    }
}
