<?php
require __DIR__ . '/../src/core/Bootstrap.php';

$container = Bootstrap::start();

// Pagaidām saglabājam DB klases savienojumu, lai nesalauztu esošos kontrolierus
require __DIR__ . '/../db/DB.php';
DB::$pdo = $container->get('db');

$router = $container->get('router');

// Definējam maršrutus
$router->add('/', 'HomeController', 'index');

$router->add('/customers', 'CustomerController', 'index');
$router->add('/customers/create', 'CustomerController', 'create');
$router->add('/customers/store', 'CustomerController', 'store');
$router->add('/customers/edit', 'CustomerController', 'edit');
$router->add('/customers/update', 'CustomerController', 'update');
$router->add('/customers/delete', 'CustomerController', 'delete');

$router->add('/orders', 'OrderController', 'index');
$router->add('/orders/create', 'OrderController', 'create');
$router->add('/orders/store', 'OrderController', 'store');
$router->add('/orders/edit', 'OrderController', 'edit');
$router->add('/orders/update', 'OrderController', 'update');
$router->add('/orders/delete', 'OrderController', 'delete');

// Apstrādājam pieprasījumu
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($requestUri);
