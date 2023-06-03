<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
header("Content-Type: application/json; charset=utf-8");

include_once "../config/database.php";
include_once "../objects/item.php";

$database = new Database();
$db = $database->getConnection();


$item = new Item($db);
 

$stmt = $item->get_items();
$num = $stmt->rowCount();

if ($num > 0) {

    $products_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description"=>$description,
            "cost" => $cost,
            "category_id" => $category_id,
            "category_name" => $category_name,
            "image" => $image,
            "manufacturer"=> $manufacturer
        );
        array_push($products_arr, $product_item);
    }
    
    http_response_code(200);
    
    echo json_encode(array("response" => 1, 'items' => $products_arr ), JSON_UNESCAPED_UNICODE);
}

else {
    http_response_code(404);

    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
