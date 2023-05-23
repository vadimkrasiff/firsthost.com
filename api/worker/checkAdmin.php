<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта товара
include_once "../objects/user.php";
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if (isset($_COOKIE['id'])) {
    if (isset($_COOKIE['rol']) && $_COOKIE['rol'] == 'admin' ) {
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Доступ разрешен."), JSON_UNESCAPED_UNICODE);
} else {
        http_response_code(503);
        echo json_encode(array("message" => "У Вас нет прав."), JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Вы не вошли в систему."), JSON_UNESCAPED_UNICODE);
}
