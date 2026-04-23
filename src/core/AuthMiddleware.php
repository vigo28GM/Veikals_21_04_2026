<?php

/**
 * AuthMiddleware - Pārbauda, vai lietotājs ir autorizēts piekļuvei aizsargātām lapām.
 */
class AuthMiddleware extends Middleware {
    /**
     * Galvenā funkcija, kas pārbauda sesijas statusu.
     * Ja lietotājs nav ielogojies (trūkst user_id sesijā), viņš tiek 
     * pārvirzīts uz login lapu un tālāka koda izpilde tiek pārtraukta.
     */
    public function handle() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
