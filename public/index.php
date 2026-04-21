<?php
require __DIR__ . '/../src/controllers/OrderController.php';
require __DIR__ . '/../db/DB.php';
require __DIR__ . '/../src/controllers/CustomerController.php';

DB::connect();

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($requestUri) {
    case '/orders':
        OrderController::index();
        break;
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
    default:
        http_response_code(404);
        echo "404 - Lappuse nav atrasta";
        break;
}
?>
