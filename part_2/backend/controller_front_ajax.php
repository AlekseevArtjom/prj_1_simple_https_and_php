<?php

namespace part_2\backend; 


//задаем защитную константу
define('GET_OFF', 8); 

//подключаем маршруты
require_once($_SERVER['DOCUMENT_ROOT'].'/routes.php');

//подключаем конфигурационный файл, модель и класс контроллера
require_once(PATH_TO_CONFIG); 
require_once(PATH_TO_MODEL_CLASS); 
require_once(PATH_TO_CONTROLLER_CLASS);

//создаем шаблонный массив для входящих POST параметров
foreach($_POST as $key => $value) $input[$key] = NULL; 
	
//создаем объект контроллера
$controller = new Controller_p_2(); 

//проверяем POST параметры из формы на заполнение и на инъекции   	
$input = $controller->check_request($input); 	

//выбирает поле input в котором записано действие которое надо выполнить	
$controller_action=$input['asck_for_action'];

//подключает нужный файл сценария контроллера
	switch($controller_action)
	{
	case "authorize": require_once(PATH_TO_CONTROLLER_AUTHORIZE);  break;
	case "log_out": require_once(PATH_TO_CONTROLLER_LOG_OUT);  break;
	
	default: echo "ERROR Can not do this!";exit;break;
	}





?>