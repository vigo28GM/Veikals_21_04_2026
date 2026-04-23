<?php
// Autoloader core klasēm un kontrolieriem
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../src/core/',
        __DIR__ . '/../src/controllers/',
        __DIR__ . '/../src/models/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

require __DIR__ . '/../db/DB.php';
DB::connect();

$router = new Router();

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
