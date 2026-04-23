<?php

class AuthMiddleware extends Middleware {
    /**
     * Galvenā funkcija, kas pārbauda piekļuves tiesības.
     * Ja lietotājs nav ielogojies, viņš tiek pārvirzīts uz login lapu
     * un tālākā koda izpilde tiek pārtraukta.
     */
    public function handle() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
