<?php

class User {
    public $id;
    public $username;
    public $email;
    private $password;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
    }

    public static function findByUsername($username) {
        $stmt = DB::run("SELECT * FROM users WHERE username = ?", [$username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ? new self($data) : null;
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }

    public static function create($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        DB::run("INSERT INTO users (username, email, password) VALUES (?, ?, ?)", [
            $username, $email, $hashedPassword
        ]);
    }
}
