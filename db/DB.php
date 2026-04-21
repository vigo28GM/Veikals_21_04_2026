<?php

class DB {
    public static $pdo;

    public static function connect() {
        $config = require __DIR__ . '/../config.php';
        $db = $config['db'];

        try {
            self::$pdo = new PDO("mysql:host={$db['host']};dbname={$db['name']}", $db['user'], $db['pass']);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function query($sqlQuery) {
        return self::$pdo->query($sqlQuery);
    }

    public static function run($sql, $args = []) {
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}
?>
