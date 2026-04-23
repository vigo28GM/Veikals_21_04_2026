<?php

/**
 * COMMENT MODEL
 * Pārvalda pasūtījumu komentārus (1:N relācija).
 */
class Comment {
    
    // --- Īpašības ---
    public $id;
    public $order_id;
    public $comment_text;
    public $created_at;

    // --- Konstruktors ---
    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->order_id = $data['order_id'] ?? null;
        $this->comment_text = $data['comment_text'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    // --- Datu piekļuves metodes ---
    /**
     * Iegūst visus komentārus konkrētam pasūtījumam, sakārtotus pēc laika.
     */
    public static function findByOrder($orderId) {
        $stmt = DB::run("SELECT * FROM order_comments WHERE order_id = ? ORDER BY created_at DESC", [$orderId]);
        $comments = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new self($row);
        }
        return $comments;
    }

    /**
     * Pievieno jaunu komentāru datubāzē.
     */
    public static function create($orderId, $text) {
        DB::run("INSERT INTO order_comments (order_id, comment_text) VALUES (?, ?)", [$orderId, $text]);
    }
}
