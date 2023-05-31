<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта товара
include_once "../objects/order.php";
$database = new Database();
$db = $database->getConnection();
$order = new Order($db);

// получаем отправленные данные
$post = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты
if (
    !empty($post->worker_id) &&
    !empty($post->data)
) {
    // устанавливаем значения свойств товара
    $order->worker_id = $post->worker_id;

    
    // создание товара
    $order->create_order();

    $link = mysqli_connect("localhost", "worker", "ewfL[o7Zad.kgS]2", "data_base");
    $get_item = mysqli_query($link, "SELECT id FROM `orders` ORDER by id DESC LIMIT 1;");
    if ($row1 = mysqli_fetch_assoc($get_item)) {
        $order->id = $row1['id']; 
    }
        foreach ($post->data as $data) {
            $order->item_id = $data->item_id;
            $order->count = $data->count;
            $order->sub_sum = $data->sum;
            $order->pharmacy_id = $data->pharmacy_id;

            $order->create_sub_order();
            
        }

        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователюы
        echo json_encode(array('response'=>1,"message" => "Заказ был создан."), JSON_UNESCAPED_UNICODE);
    }
// сообщим пользователю что данные неполные
else {
    // сообщим пользователю
    echo json_encode(array('response'=>0,"message" => "Не полные данные."), JSON_UNESCAPED_UNICODE);
}