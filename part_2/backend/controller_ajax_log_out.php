<?php
namespace part_2\backend; 


//проверяем защитную константу
if(!defined('GET_OFF')) {echo 'ERROR 404 NOT FOUND';exit;}

//вызываем функцию контроллера для выхода с сайта 
$controller->logout_user();

?>