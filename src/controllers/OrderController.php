<?php

/**
 * ORDER CONTROLLER
 * Atbild par pasūtījumu dzīves ciklu, statusiem un komentāriem.
 */
class OrderController {
    
    // --- Īpašības un Konstruktors ---
    private $db;

    public function __construct($container) {
        $this->db = $container->get('db');
    }

    // --- Palīgmetodes ---
    private function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/orders/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    // --- Lasīšanas operācijas (Read) ---
    public function index() {
        $status = $_GET['status'] ?? null;
        $orders = Order::all($status);
        $this->render('index', ['orders' => $orders, 'currentStatus' => $status]);
    }

    /**
     * Detalizēts skats, kas apvieno pasūtījumu ar tā komentāriem.
     */
    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) return header('Location: /orders');
        
        $order = Order::find($id);
        $comments = Comment::findByOrder($id);
        
        $this->render('show', ['order' => $order, 'comments' => $comments]);
    }

    // --- Izveides un Komentēšanas operācijas ---
    public function create() {
        $customers = Customer::all();
        $this->render('form', ['customers' => $customers]);
    }

    public function store() {
        Order::create($_POST);
        header('Location: /orders');
    }

    public function addComment() {
        $orderId = $_POST['order_id'] ?? null;
        $text = $_POST['comment_text'] ?? '';
        
        if ($orderId && $text) {
            Comment::create($orderId, $text);
        }
        
        header("Location: /orders/show?id=$orderId");
    }

    // --- Atjaunināšanas operācijas ---
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

    // --- Dzēšanas operācijas ---
    public function delete() {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if ($id) Order::delete($id);
        header('Location: /orders');
    }
}
