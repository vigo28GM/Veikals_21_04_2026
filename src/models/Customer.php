<?php

/**
 * Customer Model - Reprezentē klientu datu struktūru un nodrošina darbības ar customers tabulu.
 */
class Customer {
    /** @var int|null Klienta unikālais ID */
    public $customer_id;
    /** @var string|null Klienta vārds */
    public $name;
    /** @var string|null Klienta uzvārds */
    public $last_name;
    /** @var string|null E-pasta adrese */
    public $email;
    /** @var string|null Dzimšanas datums (YYYY-MM-DD) */
    public $birthday;
    /** @var int Uzkrātie lojalitātes punkti */
    public $points;
    
    /** @var array Glabā piesaistītos pasūtījumus (hierarhiskajam skatam) */
    public $orders = [];

    /**
     * Konstruktors - inicializē objekta īpašības no masīva datiem.
     */
    public function __construct($data = []) {
        $this->customer_id = $data['customer_id'] ?? $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->birthday = $data['birthday'] ?? null;
        $this->points = $data['points'] ?? 0;
    }

    /**
     * Atgriež visus klientus kā Customer objektu sarakstu.
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
     * Iegūst klientus kopā ar visiem to pasūtījumiem.
     * Izmantots hierarhiskā skata attēlošanai.
     */
    public static function allWithOrders() {
        $customers = self::all();
        foreach ($customers as $customer) {
            $customer->orders = Order::findByCustomer($customer->customer_id);
        }
        return $customers;
    }

    /**
     * Atrod konkrētu klientu pēc tā ID.
     */
    public static function find($id) {
        $stmt = DB::run("SELECT * FROM customers WHERE customer_id = ?", [$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    /**
     * Pārbauda, vai klientam ir piesaistīti pasūtījumi.
     * Drošības pārbaude pirms klienta dzēšanas.
     */
    public static function hasOrders($id) {
        $stmt = DB::run("SELECT COUNT(*) FROM orders WHERE customer_id = ?", [$id]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Saglabā jaunu klientu datubāzē.
     */
    public static function create($data) {
        return DB::run("INSERT INTO customers (name, last_name, email, birthday, points) VALUES (?, ?, ?, ?, ?)", [
            $data['name'], $data['last_name'], $data['email'], $data['birthday'], $data['points']
        ]);
    }

    /**
     * Atjaunina esoša klienta datus.
     */
    public static function update($id, $data) {
        return DB::run("UPDATE customers SET name = ?, last_name = ?, email = ?, birthday = ?, points = ? WHERE customer_id = ?", [
            $data['name'], $data['last_name'], $data['email'], $data['birthday'], $data['points'], $id
        ]);
    }

    /**
     * Izdzēš klientu no datubāzes pēc ID.
     */
    public static function delete($id) {
        return DB::run("DELETE FROM customers WHERE customer_id = ?", [$id]);
    }
}
