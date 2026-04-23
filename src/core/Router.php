<?php

class Router {
    private $routes = [];
    private $container;

    public function __construct($container) {
        // Saglabājam konteineru, lai vēlāk to padotu kontrolieriem
        $this->container = $container;
    }

    // Reģistrē jaunu maršrutu, piesaistot to konkrētai HTTP metodei (GET/POST)
    public function add($method, $uri, $controller, $action, $middleware = null) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public function dispatch($uri, $method) {
        foreach ($this->routes as $route) {
            // Pārbaudām, vai URL un HTTP metode sakrīt ar reģistrēto maršrutu
            if ($route['uri'] === $uri && $route['method'] === $method) {
                
                // Ja maršrutam ir piesaistīts Middleware (filtrs), izpildām to vispirms
                if ($route['middleware']) {
                    $route['middleware']->handle();
                }

                $controllerName = $route['controller'];
                $methodName = $route['action'];

                if (class_exists($controllerName)) {
                    // Izveidojam kontroliera objektu un injicējam tam DI konteineru
                    $controller = new $controllerName($this->container);
                    if (method_exists($controller, $methodName)) {
                        return $controller->$methodName();
                    }
                }
            }
        }

        $this->abort(404);
    }

    protected function abort($code = 404) {
        http_response_code($code);
        echo "Lapa netika atrasta.";
        die();
    }
}
