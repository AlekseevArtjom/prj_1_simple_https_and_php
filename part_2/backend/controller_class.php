<?php

namespace part_2\backend; 


//проверяем защитную константу
if(!defined('GET_OFF')) {echo '404 NOT FOUND';exit;}

class Controller_p_2
{
	private $entered_user_id;
	
	
	public function __construct(){ $this->entered_user_id=null; }
	
	//проверка POST запроса на инъекции (выдаст ошибку если запрос пустой или одно из полей запроса пустое; заполненные поля почистит от инъекций)
	public function check_request($input)
	{
		if($input==NULL) {echo "ERROR Fill the form!";exit;}
						
		foreach($_POST as $key => $value) {
			if($value!=NULL) {
				if(is_int($value) || is_float($value)) 
						$input[$key]=$value;  
				else 	$input[$key]=htmlspecialchars($value);
			}
		}
		unset($value); unset($key);
		foreach($input as $current_key=>$current_value) {
			if($input[$current_key]==NULL) {echo "ERROR  / ".$current_key." / missed";exit;}
		}
		unset($current_value); unset($current_key);             
		return $input;	
	}
	
	
	//проверяет логин и пароль пользователя и если все правильно устанавливает куки
	public function authorize_user($input)
	{
		$model = new Model_p_2(); 
		$user_real_password_and_id = $model->get_real_password_and_id($input); 		

		if($user_real_password_and_id ==NULL) {echo 'ERROR Wrong login or password!';exit;}
		
		if(crypt($input['password'], SALT)!=$user_real_password_and_id['password']){
				if(isset($_SESSION['authorization_attempt'])) $_SESSION['authorization_attempt']++; 
				echo 'ERROR Wrong login or password!'.$_SESSION['authorization_attempt'];exit;
		}
		else{
		
			session_destroy();  
			setcookie('user_id', $user_real_password_and_id['id'], time()+2*3600, '/'); 
			$this->entered_user_id=$user_real_password_and_id['id'];
		}
	}
	
	
	//загружает данные пользователя, если выполнен вход на страницу; 
	//возвращает данные в виде ассоциативного массива или выводимой строки в зависимости от того какой сценарий вызвал функцию
	public function load_user_data($type_of_return)
	{    
		$id=null;
	      
		if(isset($_COOKIE['user_id']))
			$id=$_COOKIE['user_id']; 
		if($this->entered_user_id) $id=$this->entered_user_id;
		
		if($id){
			$model = new Model_p_2(); 					
			$user_data=$model->get_user_data($id); 	
		}
		else $user_data=NULL;
                            
		if($type_of_return=='ajax'){
			echo json_encode($user_data);  exit;
		}
		else 	if($type_of_return=='page') 
					return $user_data;
				else return NULL;
                         	
	}


	//выполняет выход из аккаунта пользователя
	public function logout_user()
	{	
		setcookie('user_id', '-1', time()-2*3600, '/');
		
		echo "OK";exit;
	}
}
?>