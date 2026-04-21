<?php

class Customer {
    public static function all() {
        return DB::run("SELECT * FROM customers")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        return DB::run("SELECT * FROM customers WHERE customer_id = ?", [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        return DB::run("INSERT INTO customers (name, last_name, email, birthday, points) VALUES (?, ?, ?, ?, ?)", [
            $data['name'], $data['last_name'], $data['email'], $data['birthday'], $data['points']
        ]);
    }

    public static function update($id, $data) {
        return DB::run("UPDATE customers SET name = ?, last_name = ?, email = ?, birthday = ?, points = ? WHERE customer_id = ?", [
            $data['name'], $data['last_name'], $data['email'], $data['birthday'], $data['points'], $id
        ]);
    }

    public static function delete($id) {
        return DB::run("DELETE FROM customers WHERE customer_id = ?", [$id]);
    }

    public static function allWithOrders() {
        $customers = self::all();
        foreach ($customers as &$customer) {
            $customer['orders'] = Order::findByCustomer($customer['customer_id']);
        }
        return $customers;
    }
}
?>
