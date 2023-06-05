(function(idAuthorizeFormBox, idLogOutForm, idMessage, idUserBox, idUserDataBox, pathToPHPScriptBoxId){
	
/*
idAuthorizeForm -- id формы ваторизации пользователя
idLogOutForm-- id формы выхода пользователя
idMessage -- id блока для вывода сообщения
idUserBox -- id  блока для отображения авторизованного пользователя с кнопкой Выход из профиля
idUserDataBox -- id блока для вывода данных пользователя
pathToPHPScriptBoxId -- id блока в котором записан адрес сценария на который отправляется форма
*/

var logOutForm =  document.querySelector("#" +  idLogOutForm);  
var targetResponceMessageBox = document.querySelector("#" + idMessage);
var pathToScenarijPHP=document.querySelector("#"+pathToPHPScriptBoxId).innerText;
var userBox=document.querySelector("#" + idUserBox);
var userDataBox=document.querySelector("#" +idUserDataBox);
var authorizationFormBox = document.querySelector("#" + idAuthorizeFormBox);
var passwordField=document.querySelector("#" + idAuthorizeFormBox + " form "+ " input[name=password]");
var loginField=document.querySelector("#" + idAuthorizeFormBox + " form " + " input[name=login]");
var passwordField=document.querySelector("#" + idAuthorizeFormBox + " form "+ " input[name=password]");
var loginField=document.querySelector("#" + idAuthorizeFormBox + " form " + " input[name=login]");

//вешаем слушателя на кнопку формы
document.querySelector("#" +  idLogOutForm  + " input[type=submit]").onclick=function(e){ e.preventDefault(); log_out(); };


//выполняет ajax запрос для выхода из аккаунта 
//(в случае успеха удаляет данные пользователя со страницы и выводит форму авторизации)
function log_out()
{
	//возвращает ответ от сервера (в случае провала действия null  или строку начинающуюся с ERROR, в случае успеха json строку)
	sendAjaxRequest(pathToScenarijPHP, logOutForm, callbackSuccess, callbackFunctionError);  


	function callbackSuccess(dataReturned)
	{
		//console.log('result='+dataReturned);
				
		if(dataReturned == "OK"){//в случае успеха выхода из аккаунта
		
			targetResponceMessageBox.getElementsByTagName('p')[0].setAttribute('style', 'color: green');
			displayMessageFunction('Профиль пользователя закрыт!');

			userDataBox.innerHTML='';		
		
			userBox.setAttribute('style', 'display: none');
			passwordField.value='';
			loginField.value='';
			setTimeout(function(){authorizationFormBox.setAttribute('style', 'display: block');}, 100);
		}	
		else{ //любая ошибка возвращенная функциями классов
			targetResponceMessageBox.getElementsByTagName('p')[0].setAttribute('style', 'color: red');
			displayMessageFunction('Ошибка выхода из профиля!');
		}
		
	
	}
	
	//в случае ошибки в ходе запроса (например ошибка сервера)
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
		
		xhr.onerror=function(){ callbackFunctionError(this.status);  };
		
	
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
	
	
	
}("autorization_form", "logOutForm", "message", "user_box", "user_data", "ajax"));