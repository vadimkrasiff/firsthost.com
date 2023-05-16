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


    public function __construct($db) {
        $this->conn = $db;
    }

    // метод для получения товаров
function get_items()
{
    // выбираем все записи
    $query = "SELECT
        c.name as category_name, p.id, p.name, p.description, p.cost, p.category_id, p.created
    FROM
        " . $this->table_name . " p
        LEFT JOIN
            categories c
                ON p.category_id = c.id
    ORDER BY
        p.created DESC";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
}

function create()
{
    // запрос для вставки (создания) записей
    $query = "INSERT INTO
            " . $this->table_name . "
        SET
            name=:name, price=:price, description=:description, category_id=:category_id, created=:created";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->cost = htmlspecialchars(strip_tags($this->cost));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->created = htmlspecialchars(strip_tags($this->created));
    

    // привязка значений
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->cost);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":created", $this->created);

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
            price = :price,
            description = :description,
            category_id = :category_id,
            image=:image
        WHERE
            id = :id";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->cost = htmlspecialchars(strip_tags($this->cost));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->image = htmlspecialchars(strip_tags($this->image));
    $this->id = htmlspecialchars(strip_tags($this->id));
    

    // привязываем значения
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->cost);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":image", $this->image);
    $stmt->bindParam(":id", $this->id);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

}
