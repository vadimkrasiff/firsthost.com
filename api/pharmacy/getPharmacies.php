<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
header("Content-Type: application/json; charset=utf-8");

// подключение базы данных и файл, содержащий объекты
include_once "../config/database.php";
include_once "../objects/pharmacy.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$item = new pharmacy($db);

// чтение товаров будет здесь
$stmt = $item->get_pharmacies();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив товаров
    $pharmacies_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $product_item = array(
            "id" => $id,
            "address" => "г. " . $city . ", ул. " . $street . ", " .$num_house

        );
        array_push($pharmacies_arr, $product_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode(array("response" => 1, 'items' => $pharmacies_arr ), JSON_UNESCAPED_UNICODE);
}

// "товары не найдены" будет здесь
else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array("message" => "Аптеки не найдены."), JSON_UNESCAPED_UNICODE);
}
