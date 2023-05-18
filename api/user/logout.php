<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');

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
        echo json_encode(array("response" => 1), JSON_UNESCAPED_UNICODE);
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        setcookie("rol", "", time() - 3600*24*30*12, "/");
    }
    // если не удается создать товар, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("response" => 0,"message" => "Some error"), JSON_UNESCAPED_UNICODE);
    };
} else {
    http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("response" => 0,"message" => "Some error"), JSON_UNESCAPED_UNICODE);
}

