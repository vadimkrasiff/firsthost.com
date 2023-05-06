<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once "../config/database.php";

// создание объекта товара
include_once "../objects/user.php";
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$link=mysqli_connect("localhost", "root", "", "data_base");

// получаем отправленные данные
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты
if (
    !empty($data->fio) &&
    !empty($data->num_phone)
    && !empty($data->login)
    && !empty($data->password)
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

    $query = mysqli_query($link, "SELECT `id` FROM `users` WHERE `login` ='".mysqli_real_escape_string($link, $data->login)."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    if(count($err) == 0)
    { // устанавливаем значения свойств товара
    $user->fio = $data->fio;
    $user->num_phone = $data->num_phone;
    $user->login = $data->login;
    $user->password =  md5(md5(trim($data->password)));


    // создание товара
    if ($user->register()) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Пользователь создан."), JSON_UNESCAPED_UNICODE);
    }
    // если не удается создать товар, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно создать пользователя."), JSON_UNESCAPED_UNICODE);
    }}
    else {
        http_response_code(400);
        echo json_encode(array("message"=> $err), JSON_UNESCAPED_UNICODE);}
}
// сообщим пользователю что данные неполные
else {
    // установим код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно создать пользователя. Данные неполные."), JSON_UNESCAPED_UNICODE);
}