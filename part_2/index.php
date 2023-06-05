<?php
//задаем защитную константу
define('GET_OFF', 5);

//подключаем маршруты
require_once($_SERVER['DOCUMENT_ROOT'].'/routes.php');

//подключаем контроллер страницы сайта
require_once(PATH_TO_CONTROLLER_PAGE);



?>