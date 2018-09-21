 $(document).ready(function(){
$("#btnRegistrar").on("click", function(){
        var formulario = $("#formulario").validate
         ({
             rules: /* Accedemos a los campos.*/
             {
               tarjeta: {required: true, digits: true, minlength: 16, maxlength: 18},
               cvv : {required: true,  digits: true, minlength: 3, maxlength: 4 }
               
             },
             messages:
             {
                tarjeta : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 16 caracteres', maxlength: 'El máximo permitido son 18 caracteres' },
                cvv : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 3 caracteres', maxlength: 'El máximo permitido son 4 caracteres' },
                
             },
    });
          

    
     
         });
});