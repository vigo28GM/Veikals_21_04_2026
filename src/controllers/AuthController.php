<?php

/**
 * AuthController - Atbild par lietotāju autentifikāciju: pieteikšanos, izrakstīšanos un reģistrāciju.
 */
class AuthController {
    /** @var PDO $db Datubāzes savienojuma objekts */
    private $db;

    /**
     * Konstruktors - saņem DI konteineru un inicializē DB savienojumu.
     */
    public function __construct($container) {
        $this->db = $container->get('db');
    }

    /**
     * Palīgmetode skatu (views) ielādei.
     * 
     * @param string $view Skata faila nosaukums
     * @param array $data Dati, kas tiks padoti skatam
     */
    private function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/auth/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    /**
     * Attēlo pieteikšanās formu.
     */
    public function showLogin() {
        // Ja lietotājs jau ir ielogojies, sūtām uz sākumlapu
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        $this->render('login');
    }

    /**
     * Apstrādā pieteikšanās mēģinājumu (POST pieprasījums).
     */
    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Meklējam lietotāju pēc vārda
        $user = User::findByUsername($username);

        // Pārbaudām lietotājvārdu un šifrēto paroli
        if ($user && $user->verifyPassword($password)) {
            // Saglabājam lietotāja datus sesijā
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            header('Location: /');
            exit;
        }

        // Ja pieteikšanās neizdevās, rādām kļūdu
        $this->render('login', ['error' => 'Nepareizs lietotājvārds vai parole']);
    }

    /**
     * Izbeidz lietotāja sesiju un novirza uz pieteikšanās lapu.
     */
    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }

    /**
     * Attēlo reģistrācijas formu.
     */
    public function showRegister() {
        $this->render('register');
    }

    /**
     * Apstrādā jauna lietotāja reģistrāciju (POST pieprasījums).
     */
    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Pārbaudām, vai visi lauki ir aizpildīti
        if ($username && $email && $password) {
            User::create($username, $email, $password);
            header('Location: /login');
            exit;
        }

        $this->render('register', ['error' => 'Lūdzu, aizpildiet visus laukus']);
    }
}
