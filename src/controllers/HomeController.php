<?php

class HomeController {
    private $db;

    public function __construct($container) {
        $this->db = $container->get('db');
    }

    private function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/home/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    public function index() {
        // Iegūstam statistikas datus izmantojot injicēto PDO
        $customerCount = $this->db->query("SELECT COUNT(*) FROM customers")->fetchColumn();
        $orderCount = $this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        
        $statusStats = $this->db->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status")->fetchAll(PDO::FETCH_ASSOC);

        $this->render('index', [
            'customerCount' => $customerCount,
            'orderCount' => $orderCount,
            'statusStats' => $statusStats
        ]);
    }
}
