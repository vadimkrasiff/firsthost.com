<?php

class Order {
    private $conn;
    private $table_name = "orders";
    public $id;
    public $worker_id;
    public $pharmacy_id;
    public $order_sum;
    public $date_create;
    public $count;
    public $sub_sum;






    public function __construct($db) {
        $this->conn = $db;
    }

    function get_orders() {
        $query = "SELECT o.*, w.fio, p.city, p.street, p.num_house FROM `orders` o
        JOIN worker w on o.worker_id = w.id
        join pharmacy p on p.id = w.pharmacy_id;";
        $stmt = $this->conn->prepare($query);
    
        // выполняем запрос
        $stmt->execute();
        return $stmt;
    }

function get_order() {
    $query = "SELECT o.*, w.fio, s.item_id, i.name, s.count FROM `orders` o
        JOIN worker w on o.worker_id = w.id
        join sub_order s on s.order_id = o.id
        join pharmacy p  on p.id = w.pharmacy_id
        join items i on s.item_id = i.id  where o.id = ?";
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
}

}