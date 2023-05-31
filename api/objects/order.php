<?php

class Order {
    private $conn;
    private $table_name = "orders";
    public $id;
    public $worker_id;
    public $item_id;
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
    $query = "SELECT o.id as order_id, s.item_id, i.name, i.cost, s.count , s.sum FROM `orders` o
    JOIN worker w on o.worker_id = w.id
    join sub_order s on s.order_id = o.id
    join pharmacy p  on p.id = w.pharmacy_id
    join items i on s.item_id = i.id  ";
    $stmt = $this->conn->prepare($query);


    // выполняем запрос
    $stmt->execute();
    return $stmt;
}

function create_order() {
    $query = "INSERT INTO
    " . $this->table_name . "
SET
    worker_id=?;
    ";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1, $this->worker_id);

    // выполняем запрос
    $stmt->execute();
    $res = $stmt;
    $stmt->closeCursor();
    return $res; 
}

function create_sub_order() {
    $query = "INSERT INTO sub_order
SET
item_id=:item_id, order_id=:order_id, count=:count, sum=:sum, pharmacy_id=:pharmacy_id;";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":item_id", $this->item_id);
    $stmt->bindParam(":order_id", $this->id);
    $stmt->bindParam(":count", $this->count);
    $stmt->bindParam(":sum", $this->sub_sum);
    $stmt->bindParam(":pharmacy_id", $this->pharmacy_id);

    // выполняем запрос
    $stmt->execute();
    
    return $stmt;


}

}