<?php

// HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключим файл для соединения с базой и объектом Product
include_once "../config/database.php";
include_once "../objects/item.php";

// получаем соединение с БД
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$item = new Item($db);

// получаем id товара
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)) {
// установим id товара для удаления
$item->id = $data->id;

// удаление товара
if ($item->delete()) {
    // код ответа - 200 ok
    http_response_code(200);

    // сообщение пользователю
    echo json_encode(array('response' => 1, "message" => "Товар был удалён"), JSON_UNESCAPED_UNICODE);
}
// если не удается удалить товар
else {

    // сообщим об этом пользователю
    echo json_encode(array('response' => 0,"message" => "Не удалось удалить пользователя"));
}}
else {

    // сообщим об этом пользователю
    echo json_encode(array('response' => 0,"message" => "Не был выбран товар"));
}