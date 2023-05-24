<?php

// необходимые HTTP-заголовки
$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header('Access-Control-Allow-Credentials: true');


// подключение файла для соединения с базой и файл с объектом
include_once "../config/database.php";
include_once "../objects/storage.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$storage = new Storage($db);

// установим свойство ID записи для чтения
if(isset($_COOKIE["id"])) {

$storage->worker_id = $_COOKIE["id"];

// получим детали товара
$stmt = $storage->getProducts();
$num = $stmt->rowCount();

if ($num > 0) {

    $products_arr = array();



    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
       

        $product_storage = array(
            "id" => $id,
            "name" => $name,
            "cost" => $cost,
            "count" => $count,
            "pharmacy_id" => $pharmacy_id,
            "category_name" => $category_name,
            "manufacturer" => $manufacturer,
            "address" => "г. " . $city . ", ул. " . $street . ", " .$num_house
        );
        array_push($products_arr, $product_storage);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode(array("response" => 1, 'items' => $products_arr ), JSON_UNESCAPED_UNICODE);
} else {
    // сообщим пользователю, что такой товар не существует
    echo json_encode(array("response" => 0,"message" => "Продукт не существует"), JSON_UNESCAPED_UNICODE);
}} else {
    echo json_encode(array("response" => 0,"message" => "Не указан номер продукт"), JSON_UNESCAPED_UNICODE);
}