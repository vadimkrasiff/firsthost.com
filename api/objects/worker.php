<?php

class Worker
{
    // подключение к базе данных и таблице "products"
    private $conn;
    private $table_name = "worker";

    // свойства объекта
    public $id;
    public $fio;
    public $num_phone;
    public $login;
    public $password;
    public $hash;
    public $ip;
    public $image;
    public $rol;
    public $city;
    public $street;
    public $num_house;
    public $pharmacy_id;


    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

// метод для получения товаров
function read()
{
    // выбираем все записи
    $query = "SELECT w.*, p.city, p.street, p.num_house FROM " . $this->table_name ." w join pharmacy p on w.pharmacy_id=p.id ";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
}

// метод для создания товаров
function register()
{
    // запрос для вставки (создания) записей
    $query = "INSERT INTO
            " . $this->table_name . "
        SET
            fio=:fio, num_phone=:num_phone, login=:login, password=:password, pharmacy_id=:pharmacy_id";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->fio = htmlspecialchars(strip_tags($this->fio));
    $this->num_phone = htmlspecialchars(strip_tags($this->num_phone));
    $this->login = htmlspecialchars(strip_tags($this->login));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $stmt->bindParam(":pharmacy_id", $this->pharmacy_id);

    // привязка значений
    $stmt->bindParam(":fio", $this->fio);
    $stmt->bindParam(":num_phone", $this->num_phone);
    $stmt->bindParam(":login", $this->login);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":pharmacy_id", $this->pharmacy_id);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

function login() {

    $query = "UPDATE worker SET user_hash=:user_hash, ip=INET_ATON(:ip) WHERE id=:id";

    $stmt = $this->conn->prepare($query);
    // очистка
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->hash = htmlspecialchars(strip_tags($this->hash));
    $this->ip = htmlspecialchars(strip_tags($this->ip));

    // привязка значений
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":user_hash", $this->hash);
    $stmt->bindParam(":ip", $this->ip);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}

function logout() {
    $query = "UPDATE worker SET user_hash='', ip=0 WHERE id=:id";

    $stmt = $this->conn->prepare($query);
    // очистка
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(":id", $this->id);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}

function check() {

    $query = "SELECT w.*, INET_NTOA(w.ip) AS ip, p.city, p.street, p.num_house FROM `worker` w join
    pharmacy p on w.pharmacy_id=p.id
    WHERE w.id=:id limit 1";

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(":id", $this->id);

    $stmt->execute();

    // получаем извлеченную строку
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->login = $row['login'];
    $this->ip = $row["ip"];
    $this->hash = $row["user_hash"];
    $this->rol = $row["rol"];
    $this->city = $row["city"];
    $this->street = $row["street"];
    $this->num_house = $row["num_house"];
}

function checkAdmin() {

    $query = "SELECT rol FROM worker WHERE id =:id LIMIT 1";

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(":id", $this->id);

    $stmt->execute();

    // получаем извлеченную строку
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->rol = $row["rol"];
}


// метод для получения конкретного товара по ID
function readOne()
{
    // запрос для чтения одной записи (товара)
    $query = "SELECT * FROM " . $this->table_name . " WHERE  id = ? LIMIT 0,1";
            
    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // привязываем id товара, который будет получен
    $stmt->bindParam(1, $this->id);

    // выполняем запрос
    $stmt->execute();

    // получаем извлеченную строку
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // установим значения свойств объекта
    $this->fio = $row["fio"];
    $this->num_phone = $row["num_phone"];
}

// метод для обновления товара
function update()
{
    // запрос для обновления записи (товара)
    $query = "UPDATE
            " . $this->table_name . "
        SET
            fio = :fio,
            num_phone = :num_phone,
        WHERE
            id = :id";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->fio = htmlspecialchars(strip_tags($this->fio));
    $this->num_phone = htmlspecialchars(strip_tags($this->num_phone));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // привязываем значения
    $stmt->bindParam(":fio", $this->fio);
    $stmt->bindParam(":num_phone", $this->num_phone);
    $stmt->bindParam(":id", $this->id);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

// метод для удаления товара
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

