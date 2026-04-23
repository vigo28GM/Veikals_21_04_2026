<?php

/**
 * CUSTOMER CONTROLLER
 * Pārvalda visu klientu loģiku un datu plūsmu uz skatiem.
 */
class CustomerController {
    
    // --- Īpašības un Konstruktors ---
    private $db;

    public function __construct($container) {
        $this->db = $container->get('db');
    }

    // --- Palīgmetodes ---
    /**
     * Centralizēta skatu ielādes metode.
     */
    private function render($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../views/customers/$view.php";
        $content = ob_get_clean();
        require __DIR__ . "/../views/layout.php";
    }

    // --- Lasīšanas operācijas (Read) ---
    /**
     * Galvenais saraksts ar atbalstu hierarhiskajam skatam.
     */
    public function index() {
        $withOrders = ($_GET['with-orders'] ?? '') === 'full';
        
        if ($withOrders) {
            $customers = Customer::allWithOrders();
            $this->render('hierarchical', ['customers' => $customers]);
        } else {
            $customers = Customer::all();
            $this->render('index', ['customers' => $customers]);
        }
    }

    // --- Izveides operācijas (Create) ---
    public function create() {
        $this->render('form');
    }

    public function store() {
        Customer::create($_POST);
        header('Location: /customers');
    }

    // --- Atjaunināšanas operācijas (Update) ---
    public function edit() {
        $id = $_GET['id'] ?? null;
        $customer = Customer::find($id);
        $this->render('form', ['customer' => $customer]);
    }

    public function update() {
        $id = $_POST['id'] ?? null;
        Customer::update($id, $_POST);
        header('Location: /customers');
    }

    // --- Dzēšanas operācijas (Delete) ---
    /**
     * Dzēšana ar validāciju, lai saglabātu datu integritāti.
     */
    public function delete() {
        $id = $_POST['id'] ?? null;
        if (Customer::hasOrders($id)) {
            $customers = Customer::all();
            $this->render('index', [
                'customers' => $customers,
                'error' => "Klientu nevar dzēst, jo viņam ir piesaistīti pasūtījumi!"
            ]);
            return;
        }
        Customer::delete($id);
        header('Location: /customers');
    }
}
