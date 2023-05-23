<?php

class Pharmacy {
    private $conn;
    private $table_name = "pharmacy";
    public $id;
    public $street;
    public $city;
    public $num_house;



    public function __construct($db) {
        $this->conn = $db;
    }

function get_pharmacies() {
    $query = "SELECT * FROM ". $this->table_name . "";
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
}

}