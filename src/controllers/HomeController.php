<?php

/**
 * HomeController - Atbild par sākumlapas attēlošanu un statistikas apkopošanu.
 */
class HomeController {
    private $db;

    public function __construct($container) {
        // Iegūstam DB savienojumu no DI konteinera
        $this->db = $container->get('db');
    }

    /**
     * Palīgmetode skatu ielādei un datu padošanai (template rendering).
     */
    private function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/home/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    /**
     * Sākumlapas darbība - apkopo statistiku no vairākām tabulām.
     */
    public function index() {
        // Iegūstam statistikas datus izmantojot injicēto PDO
        $customerCount = $this->db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
        $orderCount = $this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        
        // Grupējam pasūtījumus pēc statusa, lai parādītu sadalījumu
        $statusStats = $this->db->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status")->fetchAll(PDO::FETCH_ASSOC);

        $this->render('index', [
            'customerCount' => $customerCount,
            'orderCount' => $orderCount,
            'statusStats' => $statusStats
        ]);
    }
}
