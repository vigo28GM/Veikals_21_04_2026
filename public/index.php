<?php
require __DIR__ . '/../db/DB.php';
require __DIR__ . '/../src/controllers/CustomerController.php';
require __DIR__ . '/../src/models/Customer.php';
require __DIR__ . '/../src/models/Order.php';
require __DIR__ . '/../src/controllers/OrderController.php';

DB::connect();

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($requestUri) {
    case '/':
    case '/customers':
        CustomerController::index();
        break;
    case '/customers/create':
        CustomerController::create();
        break;
    case '/customers/store':
        CustomerController::store();
        break;
    case '/customers/edit':
        CustomerController::edit();
        break;
    case '/customers/update':
        CustomerController::update();
        break;
    case '/customers/delete':
        CustomerController::delete();
        break;
    case '/orders':
        OrderController::index();
        break;
    case '/orders/create':
        OrderController::create();
        break;
    case '/orders/store':
        OrderController::store();
        break;
    case '/orders/edit':
        OrderController::edit();
        break;
    case '/orders/update':
        OrderController::update();
        break;
    case '/orders/delete':
        OrderController::delete();
        break;
    default:
        http_response_code(404);
        echo "404 - Lappuse nav atrasta";
        break;
}
?>
