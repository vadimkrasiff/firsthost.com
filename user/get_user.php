<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json, charset-UTF-8");

$link = new mysqli("localhost", "root", "", "data_base");
if ($link->connect_error){
    die("Error" . $link->connect_error);
}

$id = htmlentities($_GET["id"]);

$get_users = 'SELECT * FROM users WHERE id=' . $id;
$result = mysqli_query($link, $get_users); 

mysqli_close($link);

$user  = mysqli_fetch_assoc($result);

 $user = json_encode($user,JSON_UNESCAPED_UNICODE );
 echo $user;
?>