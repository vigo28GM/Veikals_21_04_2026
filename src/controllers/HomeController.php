<?php

/**
 * HomeController - Atbild par sākumlapas attēlošanu un kopējās statistikas apkopošanu.
 */
class HomeController {
    /** @var PDO $db Datubāzes savienojuma objekts */
    private $db;

    /**
     * Konstruktors - saņem DI konteineru un inicializē DB savienojumu.
     */
    public function __construct($container) {
        // Iegūstam DB savienojumu no Dependency Injection konteinera
        $this->db = $container->get('db');
    }

    /**
     * Palīgmetode skatu ielādei un datu padošanai (template rendering).
     * 
     * @param string $view Skata faila nosaukums
     * @param array $data Dati, kas tiks padoti skatam
     */
    private function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/home/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    /**
     * Sākumlapas galvenā darbība.
     * Apkopo datus par klientu skaitu, pasūtījumu skaitu un statusiem.
     */
    public function index() {
        // Iegūstam kopējo klientu un pasūtījumu skaitu
        $customerCount = $this->db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
        $orderCount = $this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        
        // Grupējam pasūtījumus pēc statusa, lai analizētu sadalījumu
        $statusStats = $this->db->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status")->fetchAll(PDO::FETCH_ASSOC);

        // Nododam apkopotos datus sākumlapas skatam
        $this->render('index', [
            'customerCount' => $customerCount,
            'orderCount' => $orderCount,
            'statusStats' => $statusStats
        ]);
    }
}
