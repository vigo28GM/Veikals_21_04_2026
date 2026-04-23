<?php

class Bootstrap {
    public static function init() {
        // Ieslēdzam sesijas, lai tās būtu pieejamas visā aplikācijā
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Reģistrējam autoloaderi, lai nebūtu manuāli jāizmanto 'require' katrai klasei
        self::registerAutoloader();

        // Izveidojam DI konteineru un reģistrējam tajā pamatpakalpojumus
        $container = new Container();
        self::initServices($container);

        return $container;
    }

    private static function registerAutoloader() {
        spl_autoload_register(function ($class) {
            // Norādām mapes, kurās meklēt klases
            $dirs = [
                __DIR__ . '/../controllers/',
                __DIR__ . '/../models/',
                __DIR__ . '/../core/',
                __DIR__ . '/../../db/'
            ];

            foreach ($dirs as $dir) {
                $file = $dir . $class . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }

    private static function initServices($container) {
        // Konfigurējam PDO savienojumu un saglabājam to kā servisu 'db'
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

        // Reģistrējam Router servisu
        $container->set('router', function($c) {
            return new Router($c);
        });
    }
}
