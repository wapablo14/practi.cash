 $(document).ready(function(){
      $("#btnRecarga").on("click", function(){
        var formulario = $("#formulario").validate
         ({
             rules: /* Accedemos a los campos.*/
             {
               tarjeta: {required: true,digits: true, minlength: 16, maxlength: 18},
               monto: {required: true, digits: true},
              
             },
             messages:
             {
                tarjeta : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 16 caracteres', maxlength: 'El máximo permitido son 18 caracteres' },
                monto : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros'},
                
                
             },
    });
          

    
     
         });
  });

  /*Activa el boton contraseña*/
  $("#password").password('toggle');