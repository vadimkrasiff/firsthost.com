<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";

// создание объекта товара
include_once "../objects/user.php";
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$user->id = $_COOKIE["id"];

if($user->id != ''){
    if ($user->logout()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Вы вышли."), JSON_UNESCAPED_UNICODE);
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true);
    }
    // если не удается создать товар, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно выйти."), JSON_UNESCAPED_UNICODE);
    };
} else {
    http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Вход не совершен."), JSON_UNESCAPED_UNICODE);
}

