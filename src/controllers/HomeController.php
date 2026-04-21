<?php

class HomeController {
    private static function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/home/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    public static function index() {
        // Iegūstam statistikas datus
        $customerCount = DB::run("SELECT COUNT(*) FROM customers")->fetchColumn();
        $orderCount = DB::run("SELECT COUNT(*) FROM orders")->fetchColumn();
        
        // Papildus: statusu sadalījums
        $statusStats = DB::run("SELECT status, COUNT(*) as count FROM orders GROUP BY status")->fetchAll(PDO::FETCH_ASSOC);

        self::render('index', [
            'customerCount' => $customerCount,
            'orderCount' => $orderCount,
            'statusStats' => $statusStats
        ]);
    }
}
