<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
header("Content-Type: application/json; charset=utf-8");

// подключение базы данных и файл, содержащий объекты
include_once "../config/database.php";
include_once "../objects/category.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$item = new Category($db);

// чтение товаров будет здесь
$stmt = $item->get_categories();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив товаров
    $categories_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $product_item = array(
            "id" => $id,
            "name" => $name,
        );
        array_push($categories_arr, $product_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode(array("response" => 1, 'items' => $categories_arr ), JSON_UNESCAPED_UNICODE);
}

// "товары не найдены" будет здесь
else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array("message" => "Категории не найдены."), JSON_UNESCAPED_UNICODE);
}
