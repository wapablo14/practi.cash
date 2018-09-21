$(document).ready(function(){
 jQuery.validator.addMethod("nombre", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
        });  

    /* Validar el campo nombre */
        jQuery.validator.addMethod("apellido", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
        });     

    /* Validar el formulario */
    $("#btnRegistro").on("click", function(){
        var formulario = $("#formulario").validate
         ({
             rules: /* Accedemos a los campos.*/
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
    });
          

    
     
         });
});