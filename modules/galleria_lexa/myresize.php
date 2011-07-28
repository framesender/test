<?php

function MyResize($src_path, $dst_path, $max_size){
        
    $params = getimagesize($src_path);
    # в зависимости от типа оригинальной картинки
    # применяем соответствующую функцию для считывания
    # и создания изображения с которым будем работать
    switch ( $params[2] ) {
      case 1: $source = imagecreatefromgif($src_path); break;
      case 2: $source = imagecreatefromjpeg($src_path); break;
      case 3: $source = imagecreatefrompng($src_path); break;
    }
    
    
    # если ширина или высота оригинальной картинки
    # больше ограничения производим вычисления
    if ( $params[0]>$max_size || $params[1]>$max_size ) {
      # выбираем большее: ширины или высота
      # оригинальной картинки
      if ( $params[0]>$params[1] ) $size = $params[0]; # ширина
      else $size = $params[1]; # высота
      # используя нехитрую пропорцию вычислям
      # ширину и высоту уменьшенной картинки
      $resource_width = floor($params[0] * $max_size / $size);
      $resource_height = floor($params[1] * $max_size / $size);
       
        # создание «подкладки»
      $resource = imagecreatetruecolor($resource_width, $resource_height);
        # изменение размера и копирование полученного на «подкладку»
      imagecopyresampled($resource, $source, 0, 0, 0, 0,
      $resource_width, $resource_height, $params[0], $params[1]);
      }
        # если изменять размер не надо просто присваиваем переменной
        # $resource идентификатор оригинальной картинки
      else $resource = $source;
        #сохраняем      
      imageJpeg($resource, $dst_path);

}


?>