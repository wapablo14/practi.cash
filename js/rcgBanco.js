  $(document).ready(function(){
      $("#btnRecarga").on("click", function(){
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