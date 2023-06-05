<?php
//проверяем защитную константу
if(!defined('GET_OFF')) {echo '404 NOT FOUND';exit;}

//константы для работы сайта
define('ALLOWED_AUTH_ATTEMPT', 3);
define('SALT', '4fY$vv');

//константы для установки соединения с базой данных
define('USER', 'root');         //заменить на имя вашего пользователя в вашей БД, после импорта test_db на ваш сервер
define('PASSWORD', 'usbw');		//заменить на пароль вашего пользователя в вашей БД, после импорта test_db на ваш сервер
define('DB', 'test_db');
define('HOST','localhost');




?>