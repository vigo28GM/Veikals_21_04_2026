<?php

/**
 * FRONT CONTROLLER - Vienīgais aplikācijas ieejas punkts.
 * Šis fails saņem visus pieprasījumus, sagatavo vidi un nodod darbu maršrutētājam.
 */

require_once __DIR__ . '/../src/core/Bootstrap.php';

// Inicializējam sistēmu (autoloader, DI konteiners, sesijas)
$container = Bootstrap::init();

// Iegūstam maršrutētāja instanci no DI konteinera
$router = $container->get('router');

// Definējam autentifikācijas middleware - tas kalpos kā "sargs" aizsargātajiem maršrutiem
$auth = new AuthMiddleware();

// MARŠRUTU DEFINĪCIJAS
// Katrs maršruts sastāv no: HTTP metodes, URL, Kontroliera, Metodes un (neobligāti) Middleware
$router->add('GET', '/', 'HomeController', 'index');

// Autentifikācija
$router->add('GET', '/login', 'AuthController', 'showLogin');
$router->add('POST', '/login', 'AuthController', 'login');
$router->add('GET', '/register', 'AuthController', 'showRegister');
$router->add('POST', '/register', 'AuthController', 'register');
$router->add('POST', '/logout', 'AuthController', 'logout');

// Klienti (Visi maršruti aizsargāti ar $auth)
$router->add('GET', '/customers', 'CustomerController', 'index', $auth);
$router->add('GET', '/customers/create', 'CustomerController', 'create', $auth);
$router->add('POST', '/customers/store', 'CustomerController', 'store', $auth);
$router->add('GET', '/customers/edit', 'CustomerController', 'edit', $auth);
$router->add('POST', '/customers/update', 'CustomerController', 'update', $auth);
$router->add('POST', '/customers/delete', 'CustomerController', 'delete', $auth);

// Pasūtījumi (Visi maršruti aizsargāti ar $auth)
$router->add('GET', '/orders', 'OrderController', 'index', $auth);
$router->add('GET', '/orders/show', 'OrderController', 'show', $auth);
$router->add('POST', '/orders/comment', 'OrderController', 'addComment', $auth);
$router->add('GET', '/orders/create', 'OrderController', 'create', $auth);
$router->add('POST', '/orders/store', 'OrderController', 'store', $auth);
$router->add('GET', '/orders/edit', 'OrderController', 'edit', $auth);
$router->add('POST', '/orders/update', 'OrderController', 'update', $auth);
$router->add('POST', '/orders/delete', 'OrderController', 'delete', $auth);

// PALAIŠANA
// Dispatch metode atrod atbilstošo kontrolieri un izsauc to
$router->dispatch(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 
    $_SERVER['REQUEST_METHOD']
);
