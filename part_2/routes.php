<?php
//проверяем защитную константу
if(!defined('GET_OFF')) {echo '404 NOT FOUND';exit;}

//маршруты для вида
define('PATH_TO_VIEW_CLASS', $_SERVER['DOCUMENT_ROOT'].'backend/view_class.php');
define('PATH_TO_PAGE_TEMPLATE', $_SERVER['DOCUMENT_ROOT'].'backend/page_template.html');
define('PATH_TO_JS_LOADER', '/js/loader.js');
define('PATH_TO_STYLE_P_2', '/styles/style_p_2.css');

//маршруты для контроллера
define('PATH_TO_CONTROLLER_CLASS', $_SERVER['DOCUMENT_ROOT'].'backend/controller_class.php');  
define('PATH_TO_CONTROLLER_PAGE', $_SERVER['DOCUMENT_ROOT'].'backend/controller_page.php');
define('PATH_TO_CONTROLLER_AJAX', '/backend/controller_front_ajax.php');				
define('PATH_TO_CONTROLLER_AUTHORIZE', $_SERVER['DOCUMENT_ROOT'].'backend/controller_ajax_autorize.php');  
define('PATH_TO_CONTROLLER_LOG_OUT', $_SERVER['DOCUMENT_ROOT'].'backend/controller_ajax_log_out.php');

//маршруты для модели
define('PATH_TO_CONFIG', $_SERVER['DOCUMENT_ROOT'].'backend/config.php');
define('PATH_TO_MODEL_CLASS', $_SERVER['DOCUMENT_ROOT'].'backend/model_class.php'); 


?>