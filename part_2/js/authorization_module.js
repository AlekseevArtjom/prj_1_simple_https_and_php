(function(idAuthorizeFormBox, idMessage, idUserBox, idUserDataBox, pathToPHPScriptBoxId){
	
/*

idAuthorizeForm -- id формы ваторизации пользователя
idMessage -- id блока для вывода сообщения
idUserBox -- id  блока для отображения авторизованного пользователя с кнопкой Выход из профиля
idUserDataBox -- id блока для вывода данных пользователя
pathToPHPScriptBoxId -- id блока в котором записан адрес сценария на который отправляется форма

*/

var targetResponceMessageBox = document.querySelector("#" + idMessage);
var pathToScenarijPHP=document.querySelector("#"+pathToPHPScriptBoxId).innerText;
var userBox=document.querySelector("#" + idUserBox);
var userDataBox=document.querySelector("#" +idUserDataBox);
var authorizationForm = document.querySelector("#" + idAuthorizeFormBox + " form ");
var authorizationFormContainer = document.querySelector("#" + idAuthorizeFormBox);
var passwordField=document.querySelector("#" + idAuthorizeFormBox + " form "+ " input[name=password]");
var loginField=document.querySelector("#" + idAuthorizeFormBox + " form " + " input[name=login]");

//вешаем слушателя на кнопку формы
document.querySelector("#" + idAuthorizeFormBox + " form " + "input[type=submit]").onclick=function(e){ e.preventDefault(); authorize_user(); };


//выполняет ajax запрос для авторизации пользователя 
//(в случае ошибки выводит сообщение, в случае успеха выводит сообщение об успехе и загружает данные пользователя, скрывает форму авторизации)
function authorize_user()
{
	
	//проверка полей формы и отправка запроса в случае успеха
	if(loginField.value=='' || loginField.value==undefined){ 
		targetResponceMessageBox.getElementsByTagName('p')[0].setAttribute('style', 'color: red');
		displayMessageFunction('Введите логин!');
			return;
	}
	if(passwordField.value=='' || passwordField.value==undefined){
			targetResponceMessageBox.getElementsByTagName('p')[0].setAttribute('style', 'color: red');
			displayMessageFunction('Введите пароль!');
			return;
	}	
	//возвращает ответ от сервера (в случае провала авторизации null  или строку начинающуюся с ERROR, в случае успеха json строку)
	sendAjaxRequest(pathToScenarijPHP, authorizationForm, callbackSuccess, callbackFunctionError);  

	//обрабатывает ответ от сервера
	function callbackSuccess(dataReturned)
	{
		//console.log('result='+dataReturned);
				
		var result;
			
		if(dataReturned == undefined || dataReturned =="" || dataReturned.split(' ')[0] == "ERROR"){ 
			//в случае если произошла ошибка поиска данных пользователя или не прошла авторизация 
			targetResponceMessageBox.getElementsByTagName('p')[0].setAttribute('style', 'color: red');
			displayMessageFunction('В доступе отказано!');
		}
		else {//в случае успеха авторизации выводит на стнарцу данные пользователя (name, birth_date, user_img_url) и показывает кнопку Выход 
		
			targetResponceMessageBox.getElementsByTagName('p')[0].setAttribute('style', 'color: green');
			displayMessageFunction('Вход выполнен!');

			result=JSON.parse(dataReturned);
			let userDataHtml = "<p>Имя пользователя: " + result.name + "</p>" +
					 "<p>Дата рождения: "+result.birth_date+"</p>" +
					"<img id='user_img' src='"+result.user_img_url +"' />";
			userDataBox.innerHTML=userDataHtml;			
		
			authorizationFormContainer.setAttribute('style', 'display: none');  
			setTimeout(function(){userBox.setAttribute('style', 'display: block');}, 100);
		}
		
		
	}
	
	//в случае ошибки в ходе выполнения запроса (например ошибка сценария сервера)
	function callbackFunctionError(errMessage)
	{
		targetResponceMessageBox.getElementsByTagName('p')[0].setAttribute('style', 'color: red');
		displayMessageFunction('Ошибка запроса! Код: '+errMessage);	
	}

	
}

//отправляет ajax на сервер (подготавливает данные формы, в случае успеха вызывает функцию callbackSuccess, 
// в случае ошибки в ходе запроса вызывает функцию callbackFunctionError)
function sendAjaxRequest(path, formToSend, callbackSuccess, callbackFunctionError)
{		

		if(window.XMLHttpRequest){
			var xhr= new XMLHttpRequest();
		}
		else{
			//для браузеров IE 5, 6
			var xhr = new ActiveXObject('Microsoft.XMLHTTP');
		       }
		if(xhr==undefined){
			targetResponceMessageBox.getElementsByTagName('p')[0].setAttribute('style', 'color: red');
			displayMessageFunction('Запрос не выполнен!');
			return null;
		} 

		var dataToSend=packTheForm(formToSend);
		
		xhr.open("POST", path, true);
		xhr.send(dataToSend);
		
		//выполняется по завершении запроса
		xhr.onreadystatechange=function(){ 

			if(this.readyState == 4){
				if(this.status == 200){ 
					callbackSuccess(this.responseText);
				}
				else { 
					callbackFunctionError(this.status); 
				}

			}
			
		};
		
		xhr.onerror=function(){ callbackFunctionError(this.status); };
		
	
		//упаковывает данные формы для отправки по ajax
		function packTheForm(formToSend)
		{
			
			if(navigator.userAgent.indexOf("MSIE") != -1){
				var filledFields = [];
				for(let i=0; i< formToSend.elements.length; i++){
					let currentField= encodeURIComponent(formToSend.elements[i].name);
						if(currentField==undefined || currentField=='') continue;
			       		currentField += "=";
			       		currentField += encodeURIComponent(formToSend.elements[i].value);
			       		filledFields.push(currentField);
				}
				return filledFields.join("&");
			}
			else { return new FormData(formToSend); }
			}
		}
	
	
//выводит сообщение на страницу
function displayMessageFunction(message="")
{ 
	//console.log("request complete! state="+message);
	targetResponceMessageBox.getElementsByTagName('p')[0].innerHTML=message;
	targetResponceMessageBox.className="message_show"; 
		
	setTimeout(function(){targetResponceMessageBox.className="message_hide";},2000);		
	setTimeout(function(){targetResponceMessageBox.getElementsByTagName('p')[0].setAttribute("style", "color: grey");
						  targetResponceMessageBox.getElementsByTagName('p')[0].innerHTML='';},2010);	
}
	
	
	
}("autorization_form", "message", "user_box", "user_data", "ajax"));