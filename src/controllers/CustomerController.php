<?php

class CustomerController {
    private static function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/customers/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    public static function index() {
        $withOrders = ($_GET['with-orders'] ?? '') === 'full';
        
        if ($withOrders) {
            $customers = Customer::allWithOrders();
            self::render('hierarchical', ['customers' => $customers]);
        } else {
            $customers = Customer::all();
            self::render('index', ['customers' => $customers]);
        }
    }

    public static function create() {
        self::render('form');
    }

    public static function store() {
        Customer::create($_POST);
        header('Location: /customers');
    }

    public static function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) return header('Location: /customers');
        $customer = Customer::find($id);
        self::render('form', ['customer' => $customer]);
    }

    public static function update() {
        Customer::update($_POST['customer_id'], $_POST);
        header('Location: /customers');
    }

    public static function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $success = Customer::delete($id);
            if (!$success) {
                return header('Location: /customers?error=has_orders');
            }
        }
        header('Location: /customers');
    }
}
?>
