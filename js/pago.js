$(document).ready(function(){
	$("#btnPagar").on("click",function(){
		var formulario = $("#formulario").validate
		({
			rules: /* Accedemos a los campos.*/
             {
               
               monto: {required: true, digits: true}
              
             },
             messages:
             {
                
                monto : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros'}
                
                
             },
		});
		 
	});
});

  /*Boton contraseña*/
  $("#password").password('toggle');