<?php

class Customer {
    public $customer_id;
    public $name;
    public $last_name;
    public $email;
    public $birthday;
    public $points;
    public $orders = [];

    public static function all() {
        return DB::run("SELECT * FROM customers")->fetchAll(PDO::FETCH_CLASS, 'Customer');
    }

    public static function find($id) {
        $stmt = DB::run("SELECT * FROM customers WHERE customer_id = ?", [$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Customer');
        return $stmt->fetch();
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
        // Pārbaudām, vai klientam ir pasūtījumi
        $orderCount = DB::run("SELECT COUNT(*) FROM orders WHERE customer_id = ?", [$id])->fetchColumn();
        
        if ($orderCount > 0) {
            // Ja ir pasūtījumi, dzēst neļaujam
            return false;
        }
        
        // Ja pasūtījumu nav, dzēšam klientu
        return DB::run("DELETE FROM customers WHERE customer_id = ?", [$id]);
    }

    public static function allWithOrders() {
        $customers = self::all();
        foreach ($customers as $customer) {
            $customer->orders = Order::findByCustomer($customer->customer_id);
        }
        return $customers;
    }
}
?>
