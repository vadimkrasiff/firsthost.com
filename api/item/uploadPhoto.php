<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data");
header("Access-Control-Allow-Methods: POST");
function can_upload($file){
	// если имя пустое, значит файл не выбран
    if($file['name'] == '')
		return 'Вы не выбрали файл.';
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0)
		return 'Файл слишком большой.';
	
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types))
		return 'Недопустимый тип файла.';
	
	return true;
  }
  
  function make_upload($file){
    date_default_timezone_set('UTC');
    $date = new DateTimeImmutable();

    $getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// формируем уникальное имя картинки: дата
    $name ='IMG' . $date->format('Y-m-d_H-i-s_A') . "." . $mime;


    copy($file['tmp_name'], $_SERVER['DOCUMENT_ROOT']. '/image/items/' . $name);
	// move_uploaded_file($file['tmp_name'], 'http://localhost/image/items/' );
  return  "http://localhost/image/items/" . $name;
  }


  if(isset($_FILES['photo'])) {
    // проверяем, можно ли загружать изображение
    $check = can_upload($_FILES['photo']);

    if($check === true){
      // загружаем изображение на сервер
      $im = imagecreatefrompng($_FILES['photo']['tmp_name']);
      $image = imagecrop($im,['x' => 0, 'y' => 0, 'width' => 400, 'height' => 400] );
      $result = make_upload($_FILES['photo']);
      http_response_code(201);
      echo json_encode(array("response" => $result), JSON_UNESCAPED_UNICODE);
    }
    else{
        http_response_code(400);
      // выводим сообщение об ошибке
      echo json_encode(array("message" => $check), JSON_UNESCAPED_UNICODE);
    }
  } else{
    http_response_code(400);
  // выводим сообщение об ошибке
  echo json_encode(array("message" => $_FILES), JSON_UNESCAPED_UNICODE);
}
