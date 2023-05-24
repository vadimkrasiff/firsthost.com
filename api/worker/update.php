<?php

// HTTP-заголовки
$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом Product
include_once "../config/database.php";
include_once "../objects/worker.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$product = new Worker($db);

// получаем id товара для редактирования
$data = json_decode(file_get_contents("php://input"));

// установим id свойства товара для редактирования
$worker->id = $data->id;

// установим значения свойств товара
$worker->fio = $data->fio;
$product->num_phone = $data->num_phone;

// обновление товара
if ($product->update()) {
    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array('response' => 1, "message" => "Работник был обновлён"), JSON_UNESCAPED_UNICODE);
}
// если не удается обновить товар, сообщим пользователю
else {

    // сообщение пользователю
    echo json_encode(array('response' => 0, "message" => "Невозможно обновить данные работника"), JSON_UNESCAPED_UNICODE);
}