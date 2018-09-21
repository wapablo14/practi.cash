$(document).ready(function(){

jQuery.validator.addMethod("nombre", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
        });  

    /* Validar el campo nombre */
        jQuery.validator.addMethod("apellido", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
        });     

    /* Validar el formulario */
    $("#btnActualizar").on("click", function(){
        var formulario = $("#formulario").validate
         ({
             rules: /* Accedemos a los campos.*/
             {
               
               nombre: {required: true,  nombre: true },
               apellido: {required: true, apellido: true}
               
              
             },
             messages:
             {
                
                nombre : {required: 'Este campo es obligatorio', nombre:'Ingrese su Nombre'},
                apellido : {required: 'Este campo es obligatorio', apellido:'Ingrese su Apellido'}
                
                
             },
        });
    });          
});
