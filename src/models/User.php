<?php

/**
 * User Model - Reprezentē sistēmas lietotājus un nodrošina autentifikācijas loģiku.
 */
class User {
    /** @var int|null Lietotāja unikālais ID */
    public $id;
    /** @var string|null Lietotājvārds pieteikšanās procesam */
    public $username;
    /** @var string|null Lietotāja e-pasts */
    public $email;
    /** @var string|null Šifrētā lietotāja parole */
    public $password;

    /**
     * Konstruktors - inicializē lietotāja objekta datus.
     */
    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
    }

    /**
     * Atrod lietotāju datubāzē pēc lietotājvārda.
     * 
     * @param string $username Lietotājvārds meklēšanai
     * @return User|null Atgriež User objektu vai null, ja nav atrasts
     */
    public static function findByUsername($username) {
        $stmt = DB::run("SELECT * FROM users WHERE username = ?", [$username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    /**
     * Pārbauda, vai ievadītā parole atbilst datubāzē saglabātajam hešam.
     * 
     * @param string $password Lietotāja ievadītā parole (plain text)
     * @return bool True, ja parole ir pareiza
     */
    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }

    /**
     * Reģistrē jaunu lietotāju, droši nošifrējot paroli pirms saglabāšanas.
     * 
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public static function create($username, $email, $password) {
        // Izmantojam noklusējuma algoritmu drošai paroles hešēšanai
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        return DB::run("INSERT INTO users (username, email, password) VALUES (?, ?, ?)", [
            $username, $email, $hashedPassword
        ]);
    }
}
