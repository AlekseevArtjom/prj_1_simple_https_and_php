<?php

namespace part_2\backend; 


//проверяем защитную константу
if(!defined('GET_OFF')) {echo '404 NOT FOUND';exit;}


class View_p_2
{
	private $user_data; // должны быть в виде ассоциативного массива
	
	public function __construct($user_data=NULL)
	{
		if(is_null($user_data) || $user_data=='') 
				$this->user_data=NULL;  
		else 	$this->user_data=$user_data;
	}
	
	//метод класса для отрисовки формы авторизации
	public function create_authorization_box() 
	{ 	
		if(!is_null($this->user_data)) $show_authorize_form='none'; else  $show_authorize_form='block';
	
		printf(
			'<div id="autorization_form" class="block_class" style="display: %s">
				<h3>Авторизация пользователя</h3>
				<form> 
				<ul>
					<li><input type="text" placeholder="Введите логин" name="login" />
					</li>
					<li><input type="password" placeholder="Введите пароль" name="password" />
						</br><label>Показать пароль<input type="checkbox" id="passwordControl" /></label>
					</li>
					<li><input type="submit"  value="Вход" /></li>
				<input type="text" style="display: none" name="asck_for_action" value="authorize"/>
				</ul>
				</form>
			</div>',
		$show_authorize_form
		);
	}

	//метод класса для отрисовки блока, для данных пользователя
	public function create_user_data_box()
	{   
		if(!is_null($this->user_data)) $show_user_box="block"; else $show_user_box="none";

		printf('<div style="display:'.$show_user_box.'" id="user_box"><h3>Профиль пользователя</h3>');
		
		printf('<div id="user_data" class="block_class">');
			if(!is_null($this->user_data)){
				printf('<p><strong>Имя пользователя:</strong> %s</p>',$this->user_data['name']);
				printf('<p><strong>Дата рождения:</strong> %s</p>', $this->user_data['birth_date']);
				printf('<img id="user_img" src="'.$this->user_data['user_img_url'].'" />');
			}
		printf('</div>');
		
		printf('<form id="logOutForm"><input type="submit" value="Выход" name="logout" />
		             <input type="text" style="display: none" name="asck_for_action" value="log_out"/></form>');
		printf('</div>');
	}
	
	//метод класса для отрисовки сообщения, выводимого на странице
	public function create_message_box(string $message='')
	{ 
		printf('<div id="message" class="message_hide">
					<h2>Внимание!</h2>  
					<p>%s</p>
	            </div>',$message);
	}

	
}
?>