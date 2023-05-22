<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта товара
include_once "../objects/item.php";
$database = new Database();
$db = $database->getConnection();
$item = new Item($db);

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты
if (
    !empty($data->name) &&
    !empty($data->cost) &&
    !empty($data->description) &&
    !empty($data->category_id) &&
    !empty($data->manufacturer)
) {
    // устанавливаем значения свойств товара
    $item->name = $data->name;
    $item->cost = $data->cost;
    $item->description = $data->description;
    $item->category_id = $data->category_id;
    $item->manufacturer = $data->manufacturer;
    
    $item->created = date("Y-m-d H:i:s");

    

    // создание товара
    if ($item->create()) {
        $item_id = null;
        $pharmacy_id = null;
        $link = mysqli_connect("localhost", "root", "", "data_base");
        $get_item = mysqli_query($link, "(SELECT `id` FROM items ORDER BY 1 DESC LIMIT 1 )
        UNION
        (SELECT id FROM pharmacy ORDER BY 1 DESC LIMIT 1)");
        if ($row = mysqli_fetch_assoc($get_item)) {
            $item_id = $row['id']; 
        }
        if ($row = mysqli_fetch_assoc($get_item)) {
            $pharmacy_id = $row['id']; 
        }
        for($id=1; $id<=$pharmacy_id; $id++){
            $create_item =  mysqli_query($link, 'INSERT INTO `storage` (`id`, `item_id`, `pharmacy_id`, `count`) VALUES (NULL, '.$item_id.', '.$id.', 100)');
        };
        

        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователюы
        echo json_encode(array('response'=>1,"message" => "Товар был создан."), JSON_UNESCAPED_UNICODE);
    }
    // если не удается создать товар, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array('response'=>0,"message" => "Невозможно создать товар."), JSON_UNESCAPED_UNICODE);
    }
}
// сообщим пользователю что данные неполные
else {
    // сообщим пользователю
    echo json_encode(array('response'=>0,"message" => "Не полные данные."), JSON_UNESCAPED_UNICODE);
}