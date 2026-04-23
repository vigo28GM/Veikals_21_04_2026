<?php
require __DIR__ . '/../src/core/Bootstrap.php';

$container = Bootstrap::start();

require __DIR__ . '/../db/DB.php';
DB::$pdo = $container->get('db');

$router = $container->get('router');

// Autentifikācija
$router->add('GET', '/login', 'AuthController', 'showLogin');
$router->add('POST', '/login', 'AuthController', 'login');
$router->add('GET', '/register', 'AuthController', 'showRegister');
$router->add('POST', '/register', 'AuthController', 'register');
$router->add('GET', '/logout', 'AuthController', 'logout');

// Aizsargātie maršruti
$auth = ['AuthMiddleware'];

$router->add('GET', '/', 'HomeController', 'index', $auth);

$router->add('GET', '/customers', 'CustomerController', 'index', $auth);
$router->add('GET', '/customers/create', 'CustomerController', 'create', $auth);
$router->add('POST', '/customers/store', 'CustomerController', 'store', $auth);
$router->add('GET', '/customers/edit', 'CustomerController', 'edit', $auth);
$router->add('POST', '/customers/update', 'CustomerController', 'update', $auth);
$router->add('POST', '/customers/delete', 'CustomerController', 'delete', $auth);

$router->add('GET', '/orders', 'OrderController', 'index', $auth);
$router->add('GET', '/orders/show', 'OrderController', 'show', $auth);
$router->add('POST', '/orders/comment', 'OrderController', 'addComment', $auth);
$router->add('GET', '/orders/create', 'OrderController', 'create', $auth);
$router->add('POST', '/orders/store', 'OrderController', 'store', $auth);
$router->add('GET', '/orders/edit', 'OrderController', 'edit', $auth);
$router->add('POST', '/orders/update', 'OrderController', 'update', $auth);
$router->add('POST', '/orders/delete', 'OrderController', 'delete', $auth);

// Apstrādājam pieprasījumu
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];
$router->dispatch($requestUri, $requestMethod);
