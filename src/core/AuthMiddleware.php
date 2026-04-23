<?php

class AuthMiddleware extends Middleware {
    public function handle($container) {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
