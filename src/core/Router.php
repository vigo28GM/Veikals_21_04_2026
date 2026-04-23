<?php

class Router {
    private $routes = [];

    public function add($uri, $controller, $method) {
        $this->routes[$uri] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function dispatch($uri) {
        if (array_key_exists($uri, $this->routes)) {
            $controllerName = $this->routes[$uri]['controller'];
            $methodName = $this->routes[$uri]['method'];

            if (class_exists($controllerName)) {
                $controller = new $controllerName();
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
