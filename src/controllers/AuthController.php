<?php

/**
 * AuthController - Atbild par lietotāju autentifikāciju: login, logout un reģistrāciju.
 */
class AuthController {
    private $db;

    public function __construct($container) {
        $this->db = $container->get('db');
    }

    private function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/auth/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    public function showLogin() {
        // Ja lietotājs jau ir ielogojies, sūtām uz sākumlapu
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        $this->render('login');
    }

    /**
     * Apstrādā pieteikšanās mēģinājumu.
     */
    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findByUsername($username);

        // Pārbaudām lietotājvārdu un šifrēto paroli
        if ($user && $user->verifyPassword($password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            header('Location: /');
            exit;
        }

        $this->render('login', ['error' => 'Nepareizs lietotājvārds vai parole']);
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function showRegister() {
        $this->render('register');
    }

    /**
     * Izveido jaunu lietotāju datubāzē.
     */
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
