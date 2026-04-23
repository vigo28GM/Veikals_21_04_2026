<?php

/**
 * User Model - Atbild par autentifikācijas lietotāju datiem.
 */
class User {
    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
    }

    /**
     * Atrod lietotāju pēc vārda (izmantots Login procesā).
     */
    public static function findByUsername($username) {
        $stmt = DB::run("SELECT * FROM users WHERE username = ?", [$username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    /**
     * Pārbauda, vai ievadītā parole sakrīt ar datubāzē esošo šifrēto (hashed) paroli.
     */
    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }

    /**
     * Izveido jaunu lietotāju, droši nošifrējot paroli.
     */
    public static function create($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return DB::run("INSERT INTO users (username, email, password) VALUES (?, ?, ?)", [
            $username, $email, $hashedPassword
        ]);
    }
}
