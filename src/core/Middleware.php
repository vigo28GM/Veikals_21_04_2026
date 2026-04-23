<?php

/**
 * Middleware - Abstrakta bāzes klase visiem sistēmas pieprasījumu filtriem.
 * Nodrošina vienotu struktūru starpprogrammatūras komponentēm.
 */
abstract class Middleware {
    /**
     * Metode, kas jāimplementē katram konkrētajam middleware.
     * Šeit tiek definēta pārbaudes loģika (piemēram, autorizācija).
     */
    abstract public function handle();
}
