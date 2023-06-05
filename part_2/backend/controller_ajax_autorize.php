<?php
namespace part_2\backend; 


//проверяем защитную константу
if(!defined('GET_OFF')) {echo 'ERROR 404 NOT FOUND';exit;}
  
//создаем сессию, записываем в нее номер попытки авторизации, если сессия уже существует, проверяем не превышено ли число попыток
//подобную защиту можно обойти, если в браузере в разделе Application удалить PHPSESSID, но лучше ничего не придумал
session_start();
if(!isset($_SESSION['authorization_attempt']))
			$_SESSION['authorization_attempt']=1;
else 		if($_SESSION['authorization_attempt']>ALLOWED_AUTH_ATTEMPT) { echo 'ERROR Account blocked!';exit; }

//проверяем POST параметры из формы на заполнение и на инъекции   	
$input = $controller->check_request($input); 	
					
//вызываем функцию контроллера для авторизации пользователя 
$controller->authorize_user($input);
							
//вызываем функцию контроллера для загрузки данных пользователя
$controller->load_user_data('ajax');


?>