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

    public static function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) return header('Location: /orders');
        $order = DB::run("SELECT * FROM orders WHERE order_id = ?", [$id])->fetch(PDO::FETCH_ASSOC);
        $customers = DB::run("SELECT customer_id, name, last_name FROM customers")->fetchAll(PDO::FETCH_ASSOC);
        self::render('form', ['order' => $order, 'customers' => $customers]);
    }

    public static function update() {
        DB::run("UPDATE orders SET date = ?, status = ?, comments = ?, arrived_at = ?, customer_id = ? WHERE order_id = ?", [
            $_POST['date'], $_POST['status'], $_POST['comments'], $_POST['arrived_at'] ?: null, $_POST['customer_id'], $_POST['order_id']
        ]);
        header('Location: /orders');
    }

    public static function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            DB::run("DELETE FROM orders WHERE order_id = ?", [$id]);
        }
        header('Location: /orders');
    }
}
?>
