<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}

// header("Access-Control-Allow-Origin:  https://apteka-omega.vercel.app");
// header("Access-Control-Allow-Origin:  http://localhost:3000,");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers:  Access-Control-Allow-Headers, X-Requested-With");
header('Access-Control-Allow-Credentials: true');

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта товара
include_once "../objects/worker.php";
$database = new Database();
$db = $database->getConnection();
$worker = new Worker($db);

$post = json_decode(file_get_contents("php://input"));


if ($post->id and $post->hash) {
    $worker->id = $post->id;

    $worker->check();

    if (($worker->hash !== $post->hash) or ($worker->id !== $post->id)
        or (($worker->ip !== $_SERVER['REMOTE_ADDR'])  and ($worker->ip !== "0"))
    ) {
        setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/"); // httponly !!!
        http_response_code(503);
        echo json_encode(array('response' => 0 ,"message" => "Not logged in1"), JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(201);
        echo json_encode(array( 'response' => 1, 'data' => array('id'=> $worker->id, 'login'=> $worker->login, 'rol'=> $worker->rol, "address" => "г. " . $worker->city . ", ул. " . $worker->street . ", " .$worker->num_house)), JSON_UNESCAPED_UNICODE);
    }
} else {
    // http_response_code(503);
    echo json_encode(array('response' => 0 ,"message" => "Not logged in2 " ), JSON_UNESCAPED_UNICODE);
}
