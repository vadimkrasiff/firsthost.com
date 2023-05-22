<?php

class Item {
    private $conn;
    private $table_name = "items";

    public $id;
    public $name;
    public $cost;
    public $description;
    public $category_id;
    public $image;
    public $created;
    public $modified;
    public $query_updata;
    public $count;
    public $category_name;
    public $city;
    public $street;
    public $num_house;
    public $manufacturer;


    public function __construct($db) {
        $this->conn = $db;
    }

    // метод для получения товаров
function get_items()
{
    // выбираем все записи
    $query = "SELECT
        p.category_id, c.name as category_name, p.id, p.name, p.description, p.cost, p.manufacturer, p.created, p.image
    FROM
        " . $this->table_name . " p
        LEFT JOIN
            categories c
                ON p.category_id = c.id
    ORDER BY
    p.id";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
}

function getItem()
{
    // выбираем все записи
    $query = "SELECT
    p.category_id, c.name as category_name, p.id, p.name, p.cost, p.created, p.image, p.manufacturer
FROM
    " . $this->table_name . " p
    LEFT JOIN
        categories c
            ON p.category_id = c.id
    WHERE p.id=? 
ORDER BY
p.id LIMIT 1;";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    // выполняем запрос
    $stmt->execute();
    return $stmt;
}

function getProduct()
{
    // запрос для чтения одной записи (товара)
    $query = "SELECT s.id, i.name, i.description, i.cost, s.count, i.image, i.category_id, i.manufacturer, c.name as category_name, p.city,p.street, p.num_house
                FROM storage s 
                JOIN items i ON s.item_id = i.id 
                JOIN pharmacy p ON s.pharmacy_id = p.id 
                JOIN categories c ON i.category_id = c.id 
                WHERE i.id= ? ORDER BY s.id ;";
            
    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // привязываем id товара, который будет получен
    $stmt->bindParam(1, $this->id);

    // выполняем запрос
    $stmt->execute();

    // получаем извлеченную строку
    return $stmt;
}

function create()
{
    // запрос для вставки (создания) записей
    $query = "INSERT INTO
            " . $this->table_name . "
        SET
            name=:name, cost=:cost, description=:description, category_id=:category_id, created=:created, manufacturer=:manufacturer";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->cost = htmlspecialchars(strip_tags($this->cost));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->created = htmlspecialchars(strip_tags($this->created));
    $this->manufacturer = htmlspecialchars(strip_tags($this->manufacturer));
    

    // привязка значений
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":cost", $this->cost);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":created", $this->created);
    $stmt->bindParam(":manufacturer", $this->manufacturer);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

function update()
{
    // запрос для обновления записи (товара)
    $query = "UPDATE
            " . $this->table_name . "
        SET
            name = :name,
            cost = :cost,
            description = :description,
            category_id = :category_id,
            manufacturer = :manufacturer
            
        WHERE
            id = :id";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->cost = htmlspecialchars(strip_tags($this->cost));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->manufacturer = htmlspecialchars(strip_tags($this->manufacturer));
    $this->id = htmlspecialchars(strip_tags($this->id));
    

    // привязываем значения
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":cost", $this->cost);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":manufacturer", $this->manufacturer);
    $stmt->bindParam(":id", $this->id);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

function delete()
{
    // запрос для удаления записи (товара)
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->id = htmlspecialchars(strip_tags($this->id));

    // привязываем id записи для удаления
    $stmt->bindParam(1, $this->id);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

}
