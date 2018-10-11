    $(document).ready(function(){
      $("#btnTransferir").on("click", function(){
        var formulario = $("#formulario").validate
         ({
             rules: /* Accedemos a los campos.*/
             {
               numero: {required: true,digits: true, minlength: 10, maxlength: 10},
               monto: {required: true, digits: true},
              
             },
             messages:
             {
                numero : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 10 caracteres', maxlength: 'El máximo permitido son 10 caracteres' },
                monto : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros'},
                
                
             },
    });
          

    
     
         });
  });

  
 