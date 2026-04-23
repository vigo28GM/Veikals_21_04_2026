<?php

/**
 * DB klase - Statiskā palīgklase datubāzes savienojuma pārvaldībai.
 * Izmanto PDO (PHP Data Objects), lai nodrošinātu drošu piekļuvi datiem.
 */
class DB {
    /** @var PDO $pdo Statiskais mainīgais, kas glabā aktīvo DB savienojumu */
    public static $pdo;

    /**
     * Izveido savienojumu ar datubāzi, ja tas vēl nav izdarīts.
     * Konfigurācija tiek ņemta no config.php faila.
     */
    public static function connect() {
        // Ja savienojums jau eksistē, neko nedarām
        if (self::$pdo) return;
        
        // Ielādējam DB iestatījumus
        $config = require __DIR__ . '/../config.php';
        $dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['name']};charset=utf8mb4";
        
        try {
            // Inicializējam PDO ar drošiem noklusējuma iestatījumiem
            self::$pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            // Ja neizdodas pieslēgties, pārtraucam darbību un izvadam kļūdu
            die("DB Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Universāla metode SQL vaicājumu izpildei.
     * 
     * @param string $sql SQL vaicājums ar vietturiem (?)
     * @param array $params Parametri, kas tiks droši piesaistīti vaicājumam
     * @return PDOStatement Atgriež izpildīta vaicājuma rezultāta objektu
     */
    public static function run($sql, $params = []) {
        self::connect();
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
