<?php

class Bootstrap {
    public static function start() {
        self::initAutoloader();
        
        $container = new Container();
        self::initServices($container);
        
        return $container;
    }

    private static function initAutoloader() {
        spl_autoload_register(function ($class) {
            $paths = [
                __DIR__ . '/../core/',
                __DIR__ . '/../controllers/',
                __DIR__ . '/../models/',
            ];

            foreach ($paths as $path) {
                $file = $path . $class . '.php';
                if (file_exists($file)) {
                    require $file;
                    return;
                }
            }
        });
    }

    private static function initServices($container) {
        $container->set('db', function() {
            $config = require __DIR__ . '/../../config.php';
            $dbConfig = $config['db'];
            
            $pdo = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['name']}", 
                $dbConfig['user'], 
                $dbConfig['pass']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        });

        $container->set('router', function() {
            return new Router();
        });
    }
}
