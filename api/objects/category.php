<?php

class Category {
    private $conn;
    private $table_name = "categories";
    public $id;
    public $name;
    public $description;
    public $created;
    public $modified;



    public function __construct($db) {
        $this->conn = $db;
    }

function get_categories() {
    $query = "SELECT id, name FROM ". $this->table_name . "";
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
}

}