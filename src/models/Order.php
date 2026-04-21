<?php

class Order {
    public static function all() {
        return DB::run("
            SELECT orders.*, customers.name, customers.last_name 
            FROM orders 
            JOIN customers ON orders.customer_id = customers.customer_id
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        return DB::run("SELECT * FROM orders WHERE order_id = ?", [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByCustomer($customerId) {
        return DB::run("SELECT * FROM orders WHERE customer_id = ?", [$customerId])->fetchAll(PDO::FETCH_ASSOC);
    }

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
?>
