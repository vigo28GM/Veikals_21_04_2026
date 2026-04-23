<?php

/**
 * Customer Model - Reprezentē klientu tabulu un tās saistības.
 */
class Customer {
    public $id;
    public $name;
    public $last_name;
    public $email;
    public $birthday;
    public $points;
    
    // Šeit glabāsim klienta pasūtījumus (hierarhiskajam skatam)
    public $orders = [];

    public function __construct($data = []) {
        $this->id = $data['id'] ?? $data['customer_id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->birthday = $data['birthday'] ?? null;
        $this->points = $data['points'] ?? 0;
    }

    /**
     * Atgriež visus klientus kā Customer objektu masīvu.
     */
    public static function all() {
        $stmt = DB::run("SELECT * FROM customers");
        $customers = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $customers[] = new self($row);
        }
        return $customers;
    }

    /**
     * Iegūst klientus kopā ar visiem to pasūtījumiem (hierarhiskā struktūra).
     */
    public static function allWithOrders() {
        $customers = self::all();
        foreach ($customers as $customer) {
            $customer->orders = Order::findByCustomer($customer->id);
        }
        return $customers;
    }

    public static function find($id) {
        $stmt = DB::run("SELECT * FROM customers WHERE id = ?", [$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    /**
     * Pārbauda, vai klientam ir piesaistīti pasūtījumi (izmantots pirms dzēšanas).
     */
    public static function hasOrders($id) {
        $stmt = DB::run("SELECT COUNT(*) FROM orders WHERE customer_id = ?", [$id]);
        return $stmt->fetchColumn() > 0;
    }

    public static function create($data) {
        return DB::run("INSERT INTO customers (name, last_name, email, birthday, points) VALUES (?, ?, ?, ?, ?)", [
            $data['name'], $data['last_name'], $data['email'], $data['birthday'], $data['points']
        ]);
    }

    public static function update($id, $data) {
        return DB::run("UPDATE customers SET name = ?, last_name = ?, email = ?, birthday = ?, points = ? WHERE id = ?", [
            $data['name'], $data['last_name'], $data['email'], $data['birthday'], $data['points'], $id
        ]);
    }

    public static function delete($id) {
        return DB::run("DELETE FROM customers WHERE id = ?", [$id]);
    }
}
