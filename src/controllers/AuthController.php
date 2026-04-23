<?php

class AuthController {
    private function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/auth/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    public function showLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        $this->render('login');
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findByUsername($username);

        if ($user && $user->verifyPassword($password)) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            header('Location: /');
            exit;
        }

        $this->render('login', ['error' => 'Nepareizs lietotājvārds vai parole']);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function showRegister() {
        $this->render('register');
    }

    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username && $email && $password) {
            User::create($username, $email, $password);
            header('Location: /login');
            exit;
        }

        $this->render('register', ['error' => 'Lūdzu, aizpildiet visus laukus']);
    }
}
