<?php
$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "https://apteka-omega.vercel.app" || $http_origin == "http://localhost:3000" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
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
    




    copy($file['tmp_name'], $_SERVER['DOCUMENT_ROOT']. '/image/items/' . $name);
	// move_uploaded_file($file['tmp_name'], 'http://localhost/image/items/' );
  return  "http://localhost/image/items/" . $name;
  }


  // Проверяем, был ли отправлен файл
if (isset($_FILES['photo'])) {
  $file = $_FILES['photo'];

  // Проверяем наличие ошибок при загрузке файла
  if ($file['error'] === UPLOAD_ERR_OK) {
      // Получаем информацию о файле
      $fileName = $file['name'];
      $fileTmpPath = $file['tmp_name'];
      $fileSize = $file['size'];
      $fileType = $file['type'];

      // Разрешенные расширения файлов
      $allowedExtensions = array('jpg', 'jpeg', 'png', 'bmp');
      $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

      $getMime = explode('.', $fileName );
      // нас интересует последний элемент массива - расширение
      $mime = strtolower(end($getMime));
      date_default_timezone_set('UTC');
    $date = new DateTimeImmutable();
      // формируем уникальное имя картинки: дата
        $name ='IMG' . $date->format('Y-m-d_H-i-s_A') . "." . $mime;

      // Проверяем расширение файла
      if (in_array($fileExtension, $allowedExtensions)) {
          // Определение пути для сохранения файла на сервере
          $uploadDirectory = './../../image/items/' . $name;

          // Обрезка изображения (пример: уменьшение размера до 500x500 пикселей)
          $desiredWidth = 500;
          $desiredHeight = 500;

          // Получение нового изображения с заданными размерами
          $image = imagecreatefromstring(file_get_contents($fileTmpPath));
          $resizedImage = imagescale($image, $desiredWidth, $desiredHeight);

          // Сохранение обрезанного изображения на сервере
          if (imagejpeg($resizedImage, $uploadDirectory)) {
              // Изображение успешно сохранено
              imagedestroy($image);
              imagedestroy($resizedImage);

              $response = array(
                  'response' => 1,
                  "photo" => $name,
                  'message' => 'Изображение успешно загружено и обрезано.'
              );
              echo json_encode($response, JSON_UNESCAPED_UNICODE);
          } else {
              // Произошла ошибка при сохранении изображения
              $response = array(
                  'response' => 0,
                  'message' => 'Ошибка при сохранении изображения.'
              );
              echo json_encode($response, JSON_UNESCAPED_UNICODE);
          }
      } else {
          // Недопустимое расширение файла
          $response = array(
              'response' => 0,
              'message' => 'Недопустимое расширение файла. Поддерживаемые форматы: jpg, jpeg, png, bmp.'
          );
          echo json_encode($response, JSON_UNESCAPED_UNICODE);
      }
  } else {
      // Произошла ошибка при загрузке файла
      $response = array(
          'response' => 0,
          'message' => 'Ошибка при загрузке файла: ' . $file['error']
      );
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
  }
} else {
  // Файл не был отправлен
  $response = array(
      'response' => 0,
      'message' => 'Файл не был отправлен.'
  );
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

