<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение к базе данных будет здесь
include_once "../config/database.php";
include_once "../objects/worker.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$worker = new Worker($db);
 
// запрашиваем товары
$stmt = $worker->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив товаров
    $workers_arr = array();
    

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $workers_item = array(
            "id" => $id,
            "login" => $login,
            "rol" => $rol,
            "fio" => $fio,
            "num_phone" => $num_phone,
            "pharmacy_id" => $pharmacy_id,
            "address" => "г. " . $city . ", ул. " . $street . ", " .$num_house
        );
        array_push($workers_arr, $workers_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode(array('response' => 1,'items' => $workers_arr), JSON_UNESCAPED_UNICODE);
}

else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array('response' => 0, "message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}