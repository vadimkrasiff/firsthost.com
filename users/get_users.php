<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json, charset-UTF-8");

$link = new mysqli("localhost", "root", "", "data_base");
if ($link->connect_error){
    die("Error" . $link->connect_error);
}

$get_users = 'SELECT * FROM users';
$result = mysqli_query($link, $get_users); 

mysqli_close($link);

$users=[];

while ($row = mysqli_fetch_assoc($result)) {
    $users[]=$row;
}

 $users = json_encode($users,JSON_UNESCAPED_UNICODE );
 echo $users;
?>