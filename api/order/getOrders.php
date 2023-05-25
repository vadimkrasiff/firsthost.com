<?php

// необходимые HTTP-заголовки
// if (in_array('HTTP_ORIGIN', $_SERVER)){
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    
    if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
    {  
        header("Access-Control-Allow-Origin: $http_origin");
    }
// } else
//     header("Access-Control-Allow-Origin: *")
header("Content-Type: application/json; charset=UTF-8");

// подключение к базе данных будет здесь
include_once "../config/database.php";
include_once "../objects/order.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$order = new Order($db);
 
// запрашиваем товары
$stmt = $order->get_orders();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив товаров
    $orders_arr = array();
    

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $orders_item = array(
            "id" => $id,
            "sum" => $sum,
            "date_create" => $date_create,
            "worker_id" => $worker_id,
            "fio" => $fio,
            "address" => "г. " . $city . ", ул. " . $street . ", " .$num_house
        );
        array_push($orders_arr, $orders_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode(array('response' => 1,'items' => $orders_arr), JSON_UNESCAPED_UNICODE);
}

else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array('response' => 0, "message" => "Заказы не найдены."), JSON_UNESCAPED_UNICODE);
}