$(document).ready(function(){
     $('#mensaje_error').hide();
    
   var cambioDePass = function() {
    var cont = $('#password').val();
    var cont2 = $('#contra_n_usuario').val();
    if (cont === cont2 ) {
        
        $('#mensaje_error').html("Las constraseñas si coinciden");
    } 
    else if(cont=== '' || cont2=== '')
    {
        $('#mensaje_error').hide();
    } 
    else {
         $('#mensaje_error').html("Las constraseñas no coinciden");
        $('#mensaje_error').show();
    }


}

$("#password").on('keyup', cambioDePass);
$("#contra_n_usuario").on('keyup', cambioDePass); 


        
});