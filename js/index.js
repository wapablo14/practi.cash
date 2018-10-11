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
				
				//Ajax comprobacion inputs.
				var numero=$("#numero").val();
				var dataString="numero="+numero+"&login=";
				if($.trim(numero).length>0){
				$.ajax({
					type: "POST",
					url: "https://paulina96madrid.000webhostapp.com/datosPrueba/loginPrueba.php",
					crossDomain: true, 
					cache: false,
					data: dataString,
					success: function(data){
					if(data == "success"){    
						localStorage.loginstatus = "true";
						window.location.href = "Paginas/usuario.html";
					}
					else if(data == "error"){
						alert('No registrado.');
						alert('Registro.');
						//Ajax envio inputs.
						var numero=$("#numero").val();
						var dataString="numero="+numero+"&insert=";
						$.ajax({
							type: "POST",
							url:"https://paulina96madrid.000webhostapp.com/datosPrueba/loginPrueba.php",
							data: dataString,
							crossDomain: true,
							cache: false,
							beforeSend: function(){ $("#insert").val('Connecting...');},
							success: function(data){
							if(data=="success")
							{
								alert("Registro creado.");
								window.location.href = "Paginas/registro.html";
							}
							else if(data=="error")
							{
								alert("Error de registro.");
							}
							else if(data == "exist")
							{
								alert("Registro ya existe.");
							}
							}
						});              
					}
					}
				});
				}
			return false;
					
					//window.location.href = "Paginas/index.html";			
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