<?php
class LOG 
{
    private $errors;
    
    function __construct() 
    {
        $this->errors = array(
        100 => 'Файл-конфиг не обнаружен!',
        110 => 'Проверте файл-конфиг - поле dbtype (тип драйвера) неверное!',
        120 => 'Проверте файл-конфиг - поле dbname (имя базы даных) неверное или отсутствует!',
        130 => 'Проверте файл-конфиг - поле dbhost (хост) неверное или отсутствует!',
        140 => 'Проверте файл-конфиг - поле dbuser (имя пользователя) неверное или отсутствует!',
        400 => 'Драйвер базы даных отсутствует!',
        200 => 'Не возможно подключится к БД!',
        300 => 'Не возможно выбрать БД!',
        777 => 'Неверная команда !!!'
        );
    }

    public function save_log ($er)
    {
        if(!is_int($er)) $er = 777;
        if(!array_key_exists($er,$this->errors)) $er = 777;
        
        //dirname( __FILE__ )."/../cl_log.php"
        $size = @filesize(dirname( __FILE__ ).'/../log/log.txt');
        $size = round(($size/1024/1024),2);
        
        if ($size > 10) delete(dirname( __FILE__ ).'/../log/log.txt');
                        
        $file = @fopen(dirname( __FILE__ ).'/../log/log.txt','a+');
        fwrite($file,date('d-m-y H:m:s').' '.$this->errors[(int)$er]."\r\n"); 
        
        fclose($file);
        exit;   
    }
} 

?>