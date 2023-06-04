<?php

// необходимые HTTP-заголовки
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
include_once "../objects/worker.php";
$database = new Database();
$db = $database->getConnection();
$worker = new Worker($db);
$link=mysqli_connect("localhost", "worker", "ewfL[o7Zad.kgS]2", "data_base");

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты
if (
    !empty($data->fio) &&
    !empty($data->num_phone)
    && !empty($data->login)
    && !empty($data->password)
    && !empty($data->pharmacy_id)
) {

    $err = [];

    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$data->login))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($data->login) < 3 or strlen($data->login) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    $query = mysqli_query($link, "SELECT `id` FROM `worker` WHERE `login` ='".mysqli_real_escape_string($link, $data->login)."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Работник с таким логином уже существует в базе данных";
    }

    if(count($err) == 0)
    { // устанавливаем значения свойств товара
    $worker->fio = $data->fio;
    $worker->num_phone = $data->num_phone;
    $worker->login = $data->login;
    $worker->pharmacy_id = $data->pharmacy_id;
    $worker->password =  md5(md5(trim($data->password)));


    // создание товара
    if ($worker->register()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array('response'=> 1,"message" => "Работник создан."), JSON_UNESCAPED_UNICODE);
    }
    // если не удается создать товар, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array('response'=> 0,"message" => "Невозможно создать работника."), JSON_UNESCAPED_UNICODE);
    }}
    else {
        http_response_code(400);
        echo json_encode(array('response'=> 0,"message"=> $err), JSON_UNESCAPED_UNICODE);}
}
// сообщим пользователю что данные неполные
else {
    echo json_encode(array('response'=> 0,"message" => "Невозможно создать работника. Данные неполные."), JSON_UNESCAPED_UNICODE);
}