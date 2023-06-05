<?php

namespace part_2\backend; 


//проверяем защитную константу
if(!defined('GET_OFF')) {echo '404 NOT FOUND';exit;}

//подключаем конфигурационный файл, модель, классы контроллера и модели
require_once(PATH_TO_CONFIG); 
require_once(PATH_TO_MODEL_CLASS); 
require_once(PATH_TO_CONTROLLER_CLASS); 
require_once(PATH_TO_VIEW_CLASS); 

//создаем объект контроллера
$controller = new Controller_p_2(); 

//вызываем функцию контроллера для загрузки данных пользователя
$user_data = $controller->load_user_data('page'); 
						
//создаем объект вида
$view_part2 = new View_p_2($user_data); 

//подключаем шаблон страницы
require_once(PATH_TO_PAGE_TEMPLATE);


?>