<?php

class AuthMiddleware extends Middleware {
    public function handle($container) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
