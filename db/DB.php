<?php

class DB {
    public static $pdo;

    public static function connect() {
        $servername = "172.21.144.1";
        $username = "store_app";
        $password = "password";
        $dbname = "store_dev";

        try {
            self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
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
