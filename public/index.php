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

/**
 * MARŠRUTU KONFIGURĀCIJA
 * Šeit visi aplikācijas maršruti ir sagrupēti pēc to funkcionalitātes.
 */

// --- Publiskie maršruti ---
$router->add('GET', '/', 'HomeController', 'index');

// --- Autentifikācijas bloks ---
// Apstrādā lietotāju reģistrāciju, pieslēgšanos un izrakstīšanos.
$router->add('GET',  '/login',    'AuthController', 'showLogin');
$router->add('POST', '/login',    'AuthController', 'login');
$router->add('GET',  '/register', 'AuthController', 'showRegister');
$router->add('POST', '/register', 'AuthController', 'register');
$router->add('POST', '/logout',   'AuthController', 'logout');

// --- Klientu pārvaldības bloks (CRUD) ---
// Visi maršruti ir aizsargāti ar $auth middleware.
// Ļauj skatīt, pievienot, labot un dzēst klientus.
$router->add('GET',  '/customers',        'CustomerController', 'index',  $auth);
$router->add('GET',  '/customers/create', 'CustomerController', 'create', $auth);
$router->add('POST', '/customers/store',  'CustomerController', 'store',  $auth);
$router->add('GET',  '/customers/edit',   'CustomerController', 'edit',   $auth);
$router->add('POST', '/customers/update', 'CustomerController', 'update', $auth);
$router->add('GET',  '/customers/delete', 'CustomerController', 'delete', $auth);

// --- Pasūtījumu pārvaldības bloks (CRUD + Komentāri) ---
// Visi maršruti ir aizsargāti ar $auth middleware.
// Nodrošina pasūtījumu dzīves ciklu un detalizētu skatu ar komentāriem.
$router->add('GET',  '/orders',        'OrderController', 'index',      $auth);
$router->add('GET',  '/orders/show',   'OrderController', 'show',       $auth);
$router->add('POST', '/orders/comment','OrderController', 'addComment', $auth);
$router->add('GET',  '/orders/create', 'OrderController', 'create',     $auth);
$router->add('POST', '/orders/store',  'OrderController', 'store',      $auth);
$router->add('GET',  '/orders/edit',   'OrderController', 'edit',       $auth);
$router->add('POST', '/orders/update', 'OrderController', 'update',     $auth);
$router->add('POST', '/orders/delete', 'OrderController', 'delete', $auth);

/**
 * PIEPRASĪJUMA APSTRĀDE
 * parse_url atdala ceļu no GET parametriem (piem. ?id=1).
 */
$router->dispatch(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 
    $_SERVER['REQUEST_METHOD']
);
