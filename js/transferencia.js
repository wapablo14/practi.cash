    $(document).ready(function(){
//aqui se registra la transferencia
  var n_session = sessionStorage.getItem("numero_secion");
//alert("yyyyyr");

/*      $("#btnTransferir").on("click", function(){
        var formulario = $("#formulario").validate
         ({
             rules: /* Accedemos a los campos.*/
  /*           {
               numero: {required: true,digits: true, minlength: 5, maxlength: 10},
               monto: {required: true, digits: true},
              
             },
             messages:
             {
                numero : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 10 caracteres', maxlength: 'El máximo permitido son 10 caracteres' },
                monto : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros'},
                
                
             },
   

          /*Validacion correcta metodo.*/
/*              submitHandler: function(form){

            //aqui es donde va la parte del pago
            var key_pagar = $("#password").val();
            var valor_de_pago = $("#monto").val();
            var telefono_recibe = $("#numero").val();

            var dataString6="nombre_funcion="+"a_pago"+"&telefono_paga="+n_session+"&key_pagar="+key_pagar+"&valor_de_pago="+valor_de_pago+"&telefono_recibe="+telefono_recibe;

            if($.trim(valor_de_pago).length>0){
            $.ajax({
                type: "POST",
                url:"../api/api.php",
                data: dataString6,
                crossDomain: true,
                cache: false,

                success: function(data){

                  var datos_tabla_general_m =$('#tabla_general_movimientos');
                  var datosString6 = $.parseJSON(data);
                  console.log(datosString6);

                //$.each(datosString6,function(i,field){

                //var mensaje=field.mensa;
                alert(datosString6.mensa);
                window.location.href = "usuario.html";

                //});
                  
              
                }
              })  
          }  

          return false;
          }

    });
          
    
     
         });*/
  });

  
 