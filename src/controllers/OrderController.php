<?php

class OrderController {
    private static function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/orders/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    public static function index() {
        $orders = DB::run("
            SELECT orders.*, customers.name, customers.last_name 
            FROM orders 
            JOIN customers ON orders.customer_id = customers.customer_id
        ")->fetchAll(PDO::FETCH_ASSOC);
        self::render('index', ['orders' => $orders]);
    }
}
?>
