<?php

/**
 * DB - Statiskā palīgklase datubāzes savienojuma pārvaldībai un vaicājumu izpildei.
 */
class DB {
    public static $pdo;

    /**
     * Izveido savienojumu ar datubāzi, izmantojot konfigurācijas failu.
     */
    public static function connect() {
        if (self::$pdo) return;
        
        $config = require __DIR__ . '/../config.php';
        $dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['name']};charset=utf8mb4";
        
        try {
            self::$pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Universāla metode SQL vaicājumu izpildei ar sagatavotajiem paziņojumiem (Prepared Statements).
     * Nodrošina aizsardzību pret SQL injekcijām.
     */
    public static function run($sql, $params = []) {
        self::connect();
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
