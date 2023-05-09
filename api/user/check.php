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




if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
    $user->id = $_COOKIE["id"];

    $user->check();

    if (($user->hash !== $_COOKIE['hash']) or ($user->id !== $_COOKIE['id'])
        or (($user->ip !== $_SERVER['REMOTE_ADDR'])  and ($user->ip !== "0"))
    ) {
        setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/", null, null, true); // httponly !!!
        http_response_code(503);
        echo json_encode(array("message" => "Вы не вошли в систему."), JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(201);
        echo json_encode(array("message" => "Вы вошли в систему."), JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Вы не вошли в систему."), JSON_UNESCAPED_UNICODE);
}
