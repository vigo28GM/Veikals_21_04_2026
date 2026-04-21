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
        $orders = Order::all();
        self::render('index', ['orders' => $orders]);
    }

    public static function create() {
        $customers = Customer::all();
        self::render('form', ['customers' => $customers]);
    }

    public static function store() {
        Order::create($_POST);
        header('Location: /orders');
    }

    public static function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) return header('Location: /orders');
        $order = Order::find($id);
        $customers = Customer::all();
        self::render('form', ['order' => $order, 'customers' => $customers]);
    }

    public static function update() {
        Order::update($_POST['order_id'], $_POST);
        header('Location: /orders');
    }

    public static function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) Order::delete($id);
        header('Location: /orders');
    }
}
?>
