$(document).ready(function(){

    $("#boton").on("click",function(){
	
		/*Validacion del formulario.*/
		var formulario = $("#formulario").validate({
			/*Campos a ser validados.*/
			rules: 
			{
				numero: {required: true, digits: true, minlength: 5, maxlength: 15}
			},
			/*Alerta de campos incorrectos.*/
			messages:
			{
				numero: {required: 'El campo es requerido', digits: 'Ingrese numeros correctos', minlength: 'El mínimo permitido son 5 caracteres', maxlength: 'El máximo permitido son 15 caracteres'}
			},
			/*Metodos campos incorrectos.*/
			highlight: function(element){
			},
			/*Metodos campos correcots.*/
			unhighlight: function(element){
			},
			/*Validacion correcta metodo.*/
			submitHandler: function(form){
				
				window.location.href = "Paginas/index.html";
				
				/*Cargar librerias de Cordova.
				document.addEventListener("deviceready", onDeviceReady, false);
				Funcion ready. 
				function onDeviceReady() {
				}
				Funcion alerta.
				function alertDismissed() {
				window.location.href = "Paginas/index.html";
				}	
				Alerta en cordova.
				navigator.notification.alert(
					'No tienes cuenta.',  // message
					alertDismissed,         // callback
					'PractiCash',            // title
					'Registrar'                 // buttonName
				);*/
			}	
		});	
	});
});