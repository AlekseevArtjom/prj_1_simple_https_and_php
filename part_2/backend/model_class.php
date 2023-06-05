<?php

namespace part_2\backend; 


use \PDO;

//проверяем защитную константу
if(!defined('GET_OFF')) {echo '404 NOT FOUND';exit;}


class Model_p_2
{

protected $connection_PDO; 
	
	public function __construct($host=HOST, $user=USER, $password=PASSWORD, $database=DB)
	{ 
		try{
		$this->$connection_PDO= new PDO('mysql:host='.$host.'; dbname='.$database.'; charset=utf8', $user, $password);
	       }catch(PDOException $e) {echo "Error connection!";exit;}
	}


	//выполняет запрос к БД для функций ajax
	protected function do_query_for_ajax($query_string=NULL, $coding='utf8', $query_params=[])
	{

		if($this->$connection_PDO==NULL) {echo "ERROR Connection not set!";exit;}  
		else $this->$connection_PDO ->exec('SET NAMES '.$coding); 					


		if($query_string!=='' && $query_string!==NULL){	
			$current_query=$this->$connection_PDO ->prepare($query_string); 
		
			if(empty($query_params)) $result=$current_query ->execute();
			else 		             $result=$current_query ->execute($query_params);
		
			if($result==false){ 
				echo "ERROR Database operation fail!";exit;
			}
			else $result=$current_query ->fetchAll();

			if(!empty($result)){
				return $result;
			}	
			else return  NULL;
		} 
		else return NULL;	
	}


	//получает из базы данных зашифрованный пароль пользователя и его id и возвращает их в виде одномерного ассоциативного массива
	public function get_real_password_and_id($login)
	{	
		$query_string = "SELECT password, id FROM registered_users WHERE login=:p_login"; 
		$real_password_and_id = $this->do_query_for_ajax($query_string, 'utf8', ['p_login'=>$login['login']]);
	
		$result=[]; 
		$result['id']=$real_password_and_id[0]['id'];
		$result['password']=$real_password_and_id[0]['password'];
		
		if(!empty($result)) return $result;
		else return NULL;
	}
	
	//получает из базы данных сведения о пользователе и возвращает их в виде одномерного ассоциативного массива
	public function get_user_data($id)
	{ 
		$query_string = "SELECT name, birth_date, user_img_url FROM registered_users WHERE id=:p_id"; 
		$user_data_extracted=$this->do_query_for_ajax($query_string, 'utf8', ['p_id'=>$id]);
		
		foreach($user_data_extracted[0] as $key=>$value) $user_data[$key]=$value;
		unset($key); unset($value);
		
		if($user_data!=null) 
				return $user_data;
		else 	return null;
	}

}
?>