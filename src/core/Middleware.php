<?php

/**
 * Middleware - Abstrakta bāzes klase visiem sistēmas filtriem.
 */
abstract class Middleware {
    /**
     * Metode, kas jāimplementē katram konkrētajam middleware (piem. AuthMiddleware).
     */
    abstract public function handle();
}
