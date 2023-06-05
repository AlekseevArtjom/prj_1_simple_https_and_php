(function(idForm, idPasswordControl, namePasswordField){

/*
idForm --id формы с паролем
idPasswordControl -- id поля по нажатию на которое показывается или скрывается пароль
namePasswordField --name поля пароля

*/

var targetPasswordField = document.querySelector("#"+idForm+" form " + " input[name="+namePasswordField+"]");
var targetPasswordControl = document.querySelector("#"+idPasswordControl)


//добавляем слушателя на метки показать/скрыть пароль
targetPasswordControl.onclick=function(e){ TogglePassword();};


//скрывает или показывает пароль при нажатии на checkbox
function TogglePassword()
{ //console.log('toggle password');  
	
	if(targetPasswordControl.checked){
			targetPasswordField.setAttribute('type', 'text'); 
	}
	else 	{targetPasswordField.setAttribute('type', 'password');}
}


})('autorization_form', 'passwordControl', 'password');