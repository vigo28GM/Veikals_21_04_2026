<?php
require __DIR__ . '/../src/core/Bootstrap.php';

$container = Bootstrap::start();

require __DIR__ . '/../db/DB.php';
DB::$pdo = $container->get('db');

$router = $container->get('router');

// Atvērtie maršruti (bez autentifikācijas)
$router->add('/login', 'AuthController', 'showLogin');
$router->add('/login', 'AuthController', 'login'); // POST būtu labāk atsevišķi, bet šis Router atbalsta abus vienā URI
$router->add('/register', 'AuthController', 'showRegister');
$router->add('/register', 'AuthController', 'register');
$router->add('/logout', 'AuthController', 'logout');

// Aizsargātie maršruti (nepieciešams AuthMiddleware)
$auth = ['AuthMiddleware'];

$router->add('/', 'HomeController', 'index', $auth);

$router->add('/customers', 'CustomerController', 'index', $auth);
$router->add('/customers/create', 'CustomerController', 'create', $auth);
$router->add('/customers/store', 'CustomerController', 'store', $auth);
$router->add('/customers/edit', 'CustomerController', 'edit', $auth);
$router->add('/customers/update', 'CustomerController', 'update', $auth);
$router->add('/customers/delete', 'CustomerController', 'delete', $auth);

$router->add('/orders', 'OrderController', 'index', $auth);
$router->add('/orders/create', 'OrderController', 'create', $auth);
$router->add('/orders/store', 'OrderController', 'store', $auth);
$router->add('/orders/edit', 'OrderController', 'edit', $auth);
$router->add('/orders/update', 'OrderController', 'update', $auth);
$router->add('/orders/delete', 'OrderController', 'delete', $auth);

// Apstrādājam pieprasījumu
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($requestUri);
