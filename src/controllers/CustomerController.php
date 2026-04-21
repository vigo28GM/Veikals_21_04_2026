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
        $customers = DB::run("SELECT * FROM customers")->fetchAll(PDO::FETCH_ASSOC);
        self::render('index', ['customers' => $customers]);
    }

    public static function create() {
        self::render('form');
    }

    public static function store() {
        DB::run("INSERT INTO customers (name, last_name, email, birthday, points) VALUES (?, ?, ?, ?, ?)", [
            $_POST['name'], $_POST['last_name'], $_POST['email'], $_POST['birthday'], $_POST['points']
        ]);
        header('Location: /customers');
    }

    public static function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) return header('Location: /customers');
        $customer = DB::run("SELECT * FROM customers WHERE customer_id = ?", [$id])->fetch(PDO::FETCH_ASSOC);
        self::render('form', ['customer' => $customer]);
    }

    public static function update() {
        DB::run("UPDATE customers SET name = ?, last_name = ?, email = ?, birthday = ?, points = ? WHERE customer_id = ?", [
            $_POST['name'], $_POST['last_name'], $_POST['email'], $_POST['birthday'], $_POST['points'], $_POST['customer_id']
        ]);
        header('Location: /customers');
    }

    public static function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            DB::run("DELETE FROM customers WHERE customer_id = ?", [$id]);
        }
        header('Location: /customers');
    }
}
?>
