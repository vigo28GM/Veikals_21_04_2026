<?php

/**
 * ORDER MODEL
 * Reprezentē pasūtījumu tabulu un nodrošina datu piekļuves loģiku.
 */
class Order {
    
    // --- Īpašības (Properties) ---
    public $order_id;
    public $date;
    public $status;
    public $comments;
    public $arrived_at;
    public $customer_id;
    
    // Dati no JOIN vaicājumiem
    public $name;
    public $last_name;

    // --- Lasīšanas metodes (Read) ---
    /**
     * Iegūst visus pasūtījumus ar piesaistītajiem klientu vārdiem.
     */
    public static function all($status = null) {
        $sql = "
            SELECT orders.*, customers.name, customers.last_name 
            FROM orders 
            JOIN customers ON orders.customer_id = customers.id
        ";
        $params = [];

        if ($status) {
            $sql .= " WHERE orders.status = ?";
            $params[] = $status;
        }

        return DB::run($sql, $params)->fetchAll(PDO::FETCH_CLASS, 'Order');
    }

    public static function find($id) {
        $stmt = DB::run("SELECT * FROM orders WHERE order_id = ?", [$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Order');
        return $stmt->fetch();
    }

    public static function findByCustomer($customerId) {
        return DB::run("SELECT * FROM orders WHERE customer_id = ?", [$customerId])->fetchAll(PDO::FETCH_CLASS, 'Order');
    }

    // --- Rakstīšanas metodes (Write) ---
    public static function create($data) {
        return DB::run("INSERT INTO orders (date, status, comments, arrived_at, customer_id) VALUES (?, ?, ?, ?, ?)", [
            $data['date'], $data['status'], $data['comments'], $data['arrived_at'] ?: null, $data['customer_id']
        ]);
    }

    public static function update($id, $data) {
        return DB::run("UPDATE orders SET date = ?, status = ?, comments = ?, arrived_at = ?, customer_id = ? WHERE order_id = ?", [
            $data['date'], $data['status'], $data['comments'], $data['arrived_at'] ?: null, $data['customer_id'], $id
        ]);
    }

    public static function delete($id) {
        return DB::run("DELETE FROM orders WHERE order_id = ?", [$id]);
    }
}
