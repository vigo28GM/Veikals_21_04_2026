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

    public static function create() {
        $customers = DB::run("SELECT customer_id, name, last_name FROM customers")->fetchAll(PDO::FETCH_ASSOC);
        self::render('form', ['customers' => $customers]);
    }

    public static function store() {
        DB::run("INSERT INTO orders (date, status, comments, arrived_at, customer_id) VALUES (?, ?, ?, ?, ?)", [
            $_POST['date'], $_POST['status'], $_POST['comments'], $_POST['arrived_at'] ?: null, $_POST['customer_id']
        ]);
        header('Location: /orders');
    }
}
?>
