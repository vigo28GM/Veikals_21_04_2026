<?php

class Comment {
    public $id;
    public $order_id;
    public $comment_text;
    public $created_at;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->order_id = $data['order_id'] ?? null;
        $this->comment_text = $data['comment_text'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    public static function findByOrder($orderId) {
        $stmt = DB::run("SELECT * FROM order_comments WHERE order_id = ? ORDER BY created_at DESC", [$orderId]);
        $comments = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new self($row);
        }
        return $comments;
    }

    public static function create($orderId, $text) {
        DB::run("INSERT INTO order_comments (order_id, comment_text) VALUES (?, ?)", [$orderId, $text]);
    }
}
