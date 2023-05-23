<?php

class Storage {
    private $conn;
    private $table_name = "storage";
    public $id;
    public $street;
    public $city;
    public $num_house;
    public $worker_id;




    public function __construct($db) {
        $this->conn = $db;
    }

    function getProducts()
    {
        // запрос для чтения одной записи (товара)
        $query = "SELECT i.id, i.name, i.cost, s.count, s.pharmacy_id, i.manufacturer, c.name as category_name, p.city,p.street, p.num_house
        FROM storage s 
        JOIN items i ON s.item_id = i.id 
        JOIN pharmacy p ON s.pharmacy_id = p.id 
        JOIN categories c ON i.category_id = c.id
        JOIN worker w ON w.pharmacy_id = p.id  
        WHERE w.id= ? ORDER BY i.id ;";
                
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
    
        // привязываем id товара, который будет получен
        $stmt->bindParam(1, $this->worker_id);
    
        // выполняем запрос
        $stmt->execute();
    
        // получаем извлеченную строку
        return $stmt;
    }



}