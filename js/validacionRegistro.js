$(document).ready(function(){
	 jQuery.validator.addMethod("nombre", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
        });  

    /* Validar el campo apellido */
        jQuery.validator.addMethod("apellido", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
        }); 
    $("#btnRegistro").on("click",function(){
	
		/*Validacion del formulario.*/
		var formulario = $("#formulario").validate({
			/*Campos a ser validados.*/
			rules: 
			{
			 numero: {required: true, digits: true, minlength: 5, maxlength: 15},
               nombre: {required: true,  nombre: true },
               apellido: {required: true, apellido: true},
               
              
             },
             messages:
             {
                numero : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 5 caracteres', maxlength: 'El máximo permitido son 15 caracteres' },
                nombre : {required: 'Este campo es obligatorio', nombre:'Ingrese su Nombre'},
                apellido : {required: 'Este campo es obligatorio', apellido:'Ingrese su Apellido'},
                
                
             },
			/*Metodos campos incorrectos.*/
			highlight: function(element){
			},
			/*Metodos campos correcots.*/
			unhighlight: function(element){
			},
			/*Validacion correcta metodo.*/
			submitHandler: function(form){
				
				//window.location.href = "Paginas/index.html";
				
				//Cargar librerias de Cordova.
				document.addEventListener("deviceready", onDeviceReady, false);
				//Funcion ready. 
				function onDeviceReady() {
				}
				//Funcion alerta.
				function alertDismissed() {
				window.location.href = "Paginas/usuario.html";
				}	
				//Alerta en cordova.
				navigator.notification.alert(
					'No tienes cuenta.',  // message
					alertDismissed,         // callback
					'PractiCash',            // title
					'Registrar'                 // buttonName
				);
			}	
		});	
	});
});