<?php

class OrderController {
    private $db;

    public function __construct($container) {
        $this->db = $container->get('db');
    }

    private function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/orders/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    public function index() {
        $status = $_GET['status'] ?? null;
        $orders = Order::all($status);
        $this->render('index', ['orders' => $orders, 'currentStatus' => $status]);
    }

    public function create() {
        $customers = Customer::all();
        $this->render('form', ['customers' => $customers]);
    }

    public function store() {
        Order::create($_POST);
        header('Location: /orders');
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) return header('Location: /orders');
        $order = Order::find($id);
        $customers = Customer::all();
        $this->render('form', ['order' => $order, 'customers' => $customers]);
    }

    public function update() {
        Order::update($_POST['order_id'], $_POST);
        header('Location: /orders');
    }

    public function delete() {
        $id = $_POST['id'] ?? null;
        if ($id) Order::delete($id);
        header('Location: /orders');
    }
}
