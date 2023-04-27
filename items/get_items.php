<?php

$link = new mysqli("localhost", "root", "", "data_base");
if ($link->connect_error){
    die("Error" . $link->connect_error);
}

$get_items = 'SELECT * FROM items';
$result = mysqli_query($link, $get_items); 

mysqli_close($link);

$items=[];

while ($row = mysqli_fetch_assoc($result)) {
    $items[]=$row;
}

 $items = json_encode($users,JSON_UNESCAPED_UNICODE );
 echo $items;
?>