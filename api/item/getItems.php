<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
header("Content-Type: application/json; charset=utf-8");

// подключение базы данных и файл, содержащий объекты
include_once "../config/database.php";
include_once "../objects/item.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$item = new Item($db);
 
// чтение товаров будет здесь
$stmt = $item->get_items();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив товаров
    $products_arr = array();
    // $products_arr["response"] =1;
    // $products_arr["items"] = array();
   

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description"=>$description,
            "cost" => $cost,
            "category_id" => $category_id,
            "category_name" => $category_name,
            "image" => $image,
            "manufacturer"=> $manufacturer
        );
        array_push($products_arr, $product_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode(array("response" => 1, 'items' => $products_arr ), JSON_UNESCAPED_UNICODE);
}

// "товары не найдены" будет здесь
else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
