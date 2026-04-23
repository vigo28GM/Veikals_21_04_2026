<?php

/**
 * Bootstrap klase - Atbild par sistēmas inicializāciju un pamatpakalpojumu reģistrāciju.
 */
class Bootstrap {
    /**
     * Inicializē aplikāciju: sāk sesiju, reģistrē autoloaderi un sagatavo DI konteineru.
     * 
     * @return Container Atgriež sagatavotu servisu konteineru
     */
    public static function init() {
        // Ieslēdzam sesijas, lai tās būtu pieejamas visā aplikācijā (lietotāju datiem)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Reģistrējam autoloaderi, lai klases tiktu ielādētas automātiski pēc pieprasījuma
        self::registerAutoloader();

        // Izveidojam Dependency Injection konteineru
        $container = new Container();
        
        // Reģistrējam pamatpakalpojumus (DB, Router u.c.)
        self::initServices($container);

        return $container;
    }

    /**
     * Reģistrē PHP autoloaderi, kas meklē klases norādītajās mapēs.
     */
    private static function registerAutoloader() {
        spl_autoload_register(function ($class) {
            // Saraksts ar mapēm, kurās tiek glabāti klašu faili
            $dirs = [
                __DIR__ . '/../controllers/',
                __DIR__ . '/../models/',
                __DIR__ . '/../core/',
                __DIR__ . '/../../db/'
            ];

            // Pārbaudām katru mapi, līdz atrodam atbilstošo failu
            foreach ($dirs as $dir) {
                $file = $dir . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }

    /**
     * Reģistrē aplikācijas pamatpakalpojumus DI konteinerā.
     * 
     * @param Container $container
     */
    private static function initServices($container) {
        // Konfigurējam PDO datubāzes savienojumu kā servisu 'db'
        $container->set('db', function() {
            $config = require __DIR__ . '/../../config.php';
            $pdo = new PDO(
                "mysql:host={$config['db']['host']};dbname={$config['db']['name']}",
                $config['db']['user'],
                $config['db']['pass']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        });

        // Reģistrējam Router servisu, padodot tam pašu konteineru
        $container->set('router', function($c) {
            return new Router($c);
        });
    }
}
