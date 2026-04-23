<?php

/**
 * Router klase - Atbild par ienākošo URL pieprasījumu apstrādi un maršrutēšanu uz atbilstošo kontrolieri.
 */
class Router {
    /** @var array Saraksts ar visiem reģistrētajiem maršrutiem */
    private $routes = [];

    /** @var Container DI konteiners servisu padošanai kontrolieriem */
    private $container;

    /**
     * Konstruktors - saglabā konteineru, kas tiks izmantots kontrolieru inicializācijai.
     */
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * Reģistrē jaunu maršrutu sistēmā.
     * 
     * @param string $method HTTP metode (GET, POST, utt.)
     * @param string $uri URL ceļš
     * @param string $controller Kontroliera klases nosaukums
     * @param string $action Metodes nosaukums kontrolierī
     * @param Middleware|null $middleware Pēc izvēles piesaistītais filtrs
     */
    public function add($method, $uri, $controller, $action, $middleware = null) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    /**
     * Atrod atbilstošo maršrutu un izpilda piesaistīto darbību.
     * 
     * @param string $uri Pieprasītais URL
     * @param string $method Pieprasītā HTTP metode
     */
    public function dispatch($uri, $method) {
        foreach ($this->routes as $route) {
            // Pārbaudām, vai URL un HTTP metode sakrīt ar kādu no reģistrētajiem maršrutiem
            if ($route['uri'] === $uri && $route['method'] === $method) {
                
                // Ja maršrutam ir piesaistīts filtrs (Middleware), izpildām to vispirms
                if ($route['middleware']) {
                    $route['middleware']->handle();
                }

                $controllerName = $route['controller'];
                $methodName = $route['action'];

                // Pārbaudām, vai klase eksistē un izsaucam atbilstošo metodi
                if (class_exists($controllerName)) {
                    $controller = new $controllerName($this->container);
                    if (method_exists($controller, $methodName)) {
                        return $controller->$methodName();
                    }
                }
            }
        }

        // Ja neviens maršruts nesakrīt, rādām 404 kļūdu
        $this->abort(404);
    }

    /**
     * Pārtrauc izpildi un izvada kļūdas paziņojumu.
     */
    protected function abort($code = 404) {
        http_response_code($code);
        echo "Lapa netika atrasta.";
        die();
    }
}
