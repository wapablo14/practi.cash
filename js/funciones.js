$(document).ready(function(){

///////aqui esta la variable de session 
  var n_session = sessionStorage.getItem("numero_secion");


	var numVal = localStorage.getItem("numResult");
	var dataString="numVal="+numVal+"&selectDatos=";

	//n_session=123213;

	var dataString2="nombre_funcion="+"a_perfil"+"&telefono_cliente_perfil="+n_session+"&key_perfil="+"232";

//aqui van los submenus de la opcion Cartera, estos datos todavia son los delink paulina
	$.when($.ajax({
		type: "POST",
		url:"https://paulina96madrid.000webhostapp.com/datosPrueba/datosEjemplo.php",
		data: dataString,
		crossDomain: true,
		cache: false,
		beforeSend: function(){ $("#insert").val('Connecting...');},
		success: function(data){
			var datos = $('#datosEjemplo');
			var datosString = $.parseJSON(data);
			//console.log(datosString);
			$.each(datosString,function(i,field){
				var name = field.name;
				var datosEjemplo = '<li>' + '<a>' + name + '<i class="icono derecha fas fa-angle-right"></i>'+'</a>' + '</li>';
				datos.append(datosEjemplo);
			});
			datos.append('<li><a id="botonEjemplo">Añadir tarjeta<i class="icono derecha fas fa-angle-right"></i></a></li>');
			$("#botonEjemplo").click(function(){
				window.location.href = "tarjetas.html";
			});
		}	
	}),
//desde aqui se usan los datos del usuario y de la base de datos	
//aqui se le pone el nombre que va de bajo de la foto circular
	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString2,
			crossDomain: true,
			cache: false,
			success: function(data){

				var datosString2 = $.parseJSON(data);
				console.log(datosString2);
				$.each(datosString2,function(i,field){

					var id=field.id;
					var name=field.nombre_cliente;
					var ruta_i = field.imagen;
					//var fullname=field.fullname;
					if(ruta_i!="no_imagen")
					{
						$('#img2').attr('src',ruta_i);
						$('#img_usuario').attr('src',ruta_i);
						$('#img_usuario2').attr('src',ruta_i);
						
					}
					if(ruta_i=="no_imagen")
					{
						$('#img2').attr('src','../img/imagen_usuario/no_foto.png');
						$('#img_usuario').attr('src','../img/imagen_usuario/no_foto.png');
						$('#img_usuario2').attr('src','../img/imagen_usuario/no_foto.png');

					}
					$('#btnEjemplo').text(name);

					$("#nombre_t_cli").text(name);
				});
			}
		})	

	);

/////////////////////////ESTA ES LA PARTE DE SUBIR FOTO DE ajustes.html
	$('[data-toggle="tooltip"]').tooltip();

    $('#img_usuario2').on('click', function(){
		$("#modal_foto").modal();
/*
    	$("#contenido_cuerpo").html("<form align='center' id='insertar_foto' "
    	+"enctype='multipart/form-data'>Haz click en Seleccionar Imagen:<input type='hidden' name='numero'"
    	+" value='' id='numero_a'><input type='hidden' name='nombre_funcion' value='' id='nombre_funcion'>"
    	+"<input type='hidden' name='clave' value='' id='clave_a'><input type='hidden' name='fecha_entrada'"
    	+"value='' id='fecha_a'><br><br><input type='file' name='imagen'><br>"
    	+"<input type='submit' value='Insertar imagen' class='btn btn-success'></form>");

*/
		$("#numero_a").val(n_session);
		$("#nombre_funcion").val("a_suscribir");
		$("#clave_a").val("123");
		$("#fecha_a").val("2019-02-04");

	});	
		
		$("#insertar_foto").submit(insertarFoto)

		function insertarFoto(event){
			event.preventDefault();
				//alert("sssss");		
			var datos = new FormData($("#insertar_foto")[0]);
			//alert(datos);
			$.ajax({
				url:'../api/api.php',
				type: 'POST',
				data: datos,
				contentType: false, //para no permitir envio de datos get
				processData: false,//para no convertir los datos en forma de texto
				cache: false,
				success: function(data){
					//$("#respuesta").html(data);
					var datosString8 = $.parseJSON(data);
					//$.each(datosString8,function(key, value){
					//men_cabecera_modal.text(value.cabecera);
					console.log(data);
					$("#insertar_foto").hide(100);
					//$("#contenido_cuerpo").text("");
					$("#imagen").val("");
					$("#mensaje").text(datosString8.men);

					if(datosString8.id == 'success')
					{
						//$("#quitar_e").remove();
					

						//sessionStorage.setItem("img_session",datosString8.ima);

						//$("#co").load("../Paginas/capa_imagen.html");
						
					/*	var img =$('<img>',{
							id:'img_usuario2',
							src:'../img/imagen_usuario/2-2019-03-05-03-04-56.jpeg',
							alt: 'MyAlt'
						});
					*/
					    //$("#quitar_e").append("<img src='' id='img_usuario2'>");

						$('#img_usuario2').attr('src',datosString8.ima);
						$('#img_usuario').attr('src',datosString8.ima);	
					//img.appendTo(("#quitar_e"));
					
					}




					
				}
			}); 
		}

		$("#c_m_a").click(function(evento){
			$("#insertar_foto").show(300);
			$("#mensaje").text("");
		});
		




//aqui se pone el saldo actual
	var dataString3="nombre_funcion="+"ver_saldo"+"&telefono="+n_session+"&key="+"232";

	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString3,
			crossDomain: true,
			cache: false,

			success: function(data){

				var datosString3 = $.parseJSON(data);
				console.log(datosString3);
				$.each(datosString3,function(i,field){

			var total_valor=field.total_valor;
			
			$('#saldo_actual').text("$"+total_valor);

		
			});
			}
		})	
	


//aqui se muestra la tabla de los ultimos movimientos del usuario.html
/*
	var dataString4="nombre_funcion="+"a_transaccion"+"&telefono_transaccion="+n_session+"&key_transaccion="+"232";

	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString4,
			crossDomain: true,
			cache: false,

			success: function(data){

				datos_tabla_general =$('#grid-basic');
				var datosString4 = $.parseJSON(data);
				console.log(datosString4);


				$.each(datosString4,function(i,field){

				var fecha=field.fecha;
				var descripcion=field.descripcion;
				var saldo=field.saldo;

				var dia_ini = fecha.substring(8,10);
    			var mes_ini = fecha.substring(5,7);
    			var anio_ini = fecha.substring(0,4);
    			var fecha2 =dia_ini+'-'+mes_ini+'-'+anio_ini;
		
			
			//datos.append(datosEjemplo);
			
				datos_tabla_general.append('<tr><td>'+fecha2+'</td><td>'+descripcion+'</td><td style="color:green">'+'$'+saldo+'</td></tr>');
						
			//$('#saldo_actual').text(descripcion);

			});

			}
		})	
*/
//aqui se muestra la tabla de los ultimos movimientos del movimientos.html

	var dataString5="nombre_funcion="+"a_transaccion"+"&telefono_transaccion="+n_session+"&key_transaccion="+"232";

	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString5,
			crossDomain: true,
			cache: false,

			success: function(data){

				var datos_tabla_general_m =$('#tabla_general_movimientos');
				var datosString5 = $.parseJSON(data);
				console.log(datosString5);

				var contador3=0;
				var maximo =10;
				$.each(datosString5,function(i,field){
				if(contador3!=maximo)
				{
					var fecha=field.fecha;
					var movimiento=field.descripcion;
					var valor = field.valor;
					var saldo=field.saldo;
					var concepto = field.observacion;
					var usuario = field.nombre_cliente;

					var dia_ini = fecha.substring(8,10);
	    			var mes_ini = fecha.substring(5,7);
	    			var anio_ini = fecha.substring(0,4);
	    			var fecha2 =dia_ini+'-'+mes_ini+'-'+anio_ini;
				
					
				if(valor <0)
				{ 
					datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+concepto+'</td><td>'+movimiento+'</td><td>'+n_session+' ('+usuario+')'+'</td><td style="color:red;">'+valor+'</td><td>'+'$'+saldo+'</td></tr>');
				}
				if(valor>=0)
				{
					datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+concepto+'</td><td>'+movimiento+'</td><td>'+n_session+' ('+usuario+')'+'</td><td style="color:#00FF00;">'+valor+'</td><td>'+'$'+saldo+'</td></tr>');
				}


	//////////////////
				var table = "#mitabla";
				$('.pagination').html('');
				var trnum = 0;
				//aqui obtiene el valor de la lista de numeros de registros
				var maxRows = 10;
	//aqui calcula la cantidad de registros que hay en la tabla			
				var totalRows = $(table+' tbody tr').length;
				//alert(totalRows);
				$(table+' tr:gt(0)').each(function(){
					trnum++;
					if(trnum > maxRows)
					{
						$(this).hide();
					}
					if (trnum <= maxRows)
					{
						$(this).show();
					}
				});

				if (totalRows > maxRows)
				{
					var pagenum = Math.ceil(totalRows/maxRows);
					for(var i = 1; i <=pagenum;)
					{
						$('.pagination').append('<li data-page="'+i+'" >\<span>'+ i++ +'<span class="sr-only">(current)</span></span>\</li>').show();
					}
				}
	//aqui se pone en activo la primera casilla de la paginacion			
				$('.pagination li:first-child').addClass('active');
					
					$('.pagination li').on('click', function(){
						var pageNum = $(this).attr('data-page');
						var trIndex = 0;
						$('.pagination li').removeClass('active');
						$(this).addClass('active');
					
							$(table+' tr:gt(0)').each(function(){
								trIndex++;
								if(trIndex > (maxRows*pageNum) || trIndex <= ((maxRows*pageNum)-maxRows))
								{
									$(this).hide();
								}else{
									$(this).show();
								}
							});
					
				});
/////////////////////
				contador3= contador3+1;
			}
			});
		$("#total_filas").text(contador3);

  
			}
		})	







//ESTA ES LA PARTE DE MOSTRAR 10 25 O50 REGISTORS DE LA TABLA MOVIMIENTOS

/*
		var table = "#mitabla";
		$('#maxRows').on('change', function(){
			//alert("rrrr");
			$('.pagination').html('');
			var trnum = 0;
			//aqui obtiene el valor de la lista de numeros de registros
			var maxRows = parseInt($(this).val());
//aqui calcula la cantidad de registros que hay en la tabla			
			var totalRows = $(table+' tbody tr').length;
			//alert(totalRows);
			$(table+' tr:gt(0)').each(function(){
				trnum++;
				if(trnum > maxRows)
				{
					$(this).hide();
				}
				if (trnum <= maxRows)
				{
					$(this).show();
				}
			});
			if (totalRows > maxRows)
			{
				var pagenum = Math.ceil(totalRows/maxRows);
				for(var i = 1; i <=pagenum;)
				{
					$('.pagination').append('<li data-page="'+i+'" >\<span>'+ i++ +'<span class="sr-only">(current)</span></span>\</li>').show();
				}
			}
//aqui se pone en activo la primera casilla de la paginacion			
			$('.pagination li:first-child').addClass('active');
			$('.pagination li').on('click', function(){
				var pageNum = $(this).attr('data-page');
				var trIndex = 0;
				$('.pagination li').removeClass('active');
				$(this).addClass('active');
				$(table+' tr:gt(0)').each(function(){
					trIndex++;
					if(trIndex > (maxRows*pageNum) || trIndex <= ((maxRows*pageNum)-maxRows))
					{
						$(this).hide();
					}else{
						$(this).show();
					}
				});
			});
		});


*/







//////////////////aqui es donde va la parte del pago



      $("#btnTransferir").on("click", function(){
      	//alert("si");
        var formulario = $("#formulario").validate
         ({
             rules: /* Accedemos a los campos.*/
             {
               numero: {required: true,digits: true, minlength: 5, maxlength: 10},
               monto: {required: true, digits: true},
             },
             messages:
             {
                numero : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 10 caracteres', maxlength: 'El máximo permitido son 10 caracteres' },
                monto : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros'},            
             },
   

          /*Validacion correcta metodo.*/
            submitHandler: function(form){            
            var key_pagar = $("#password").val();
            var valor_de_pago = $("#monto").val();
            var telefono_recibe = $("#numero").val();
            var concepto = $("#concepto").val();

            var ind1 =0;
	
//alert(n_session+" "+telefono_recibe);
            var dataString6="nombre_funcion="+"a_pago"+"&telefono_paga="+n_session+"&key_pagar="+key_pagar+"&valor_de_pago="+valor_de_pago+"&telefono_recibe="+telefono_recibe+"&concepto="+concepto;

            if($.trim(valor_de_pago).length>0)
            {
            $.ajax({
                type: "POST",
                url:"../api/api.php",
                data: dataString6,
                crossDomain: true,
                cache: false,

                success: function(data){

                 // var datos_tabla_general_m =$('#tabla_general_movimientos');
                  var datosString6 = $.parseJSON(data);
                  console.log(datosString6);
                  
                  var men_cabecera_modal =$('#men_cabecera_modal');
                  var men_cuerpo_modal =$('#men_cuerpo_modal');

                  $.each(datosString6,function(key, value){
                 // alert("sasd");
                  	if(value.id=="no_usuario")
	                {
	                  	men_cabecera_modal.text(value.cabecera);
	  					men_cuerpo_modal.append(value.cuerpo+"  <button class='btn btn-primary'>Aqui</button>");
	  					$("#modal_trans").modal();
	  					$("#numero").val("");
	  					$("#monto").val("");
                  	}

                  	if(value.id=="success")
	                {
	                  	men_cabecera_modal.text(value.cabecera);
	  					men_cuerpo_modal.append(value.cuerpo);
	  					$("#modal_trans").modal();
	  					$("#numero").val("");
	  					$("#monto").val("");
                  	}

                  	if(value.id=="error_pago")
	                {
	                  	men_cabecera_modal.text(value.cabecera);
	  					men_cuerpo_modal.append(value.cuerpo);
	  					$("#modal_trans").modal();
	  					$("#numero").val("");
	  					$("#monto").val("");
                  	}

                   	if(value.id=="no_saldo")
	                {
	                  	men_cabecera_modal.text(value.cabecera);
	  					men_cuerpo_modal.append(value.cuerpo);
	  					$("#modal_trans").modal();
	  					$("#numero").val("");
	  					$("#monto").val("");
                  	}                 	

                  	if(value.id=="telefono_igual")
	                {
	                  	men_cabecera_modal.text(value.cabecera);
	  					men_cuerpo_modal.append(value.cuerpo);
	  					$("#modal_trans").modal();
	  					$("#numero").val("");
	  					$("#monto").val("");
                  	}                  	
				  
				  });
                
                }
            
              })  
          //}
		}
          return false;
          }

    });
          
    
     
    });

////////////////////////////////aqui finaliza la parte del pago


////////////////////////aqui empieza la parte de generar el codigo de validacion del numero de telefono validar.html
	$("#enviar_cod").on("click", function(){
		//alert("ffffff");
		
		var numero_tele = $("#tel").val();

        var codedial = $(".selected-flag").attr('title');
        var codigo_i = codedial.split('+');
        var codigo = codigo_i[1];

		var validar_numero_t= validar_numero_t(numero_tele);


        if (validar_numero_t==false) 
        {
            swal("Error","El campo del Numero de Telefono debe ser numerico, y debe contener minimo 5 digitos","error"); 
        }       


        if (validar_numero_t==true) 
        {
        	//numero_tele = "+"+codigo+numero_tele;
        	numero_tele = codigo+numero_tele;
			var dataString10="nombre_funcion="+"a_suscribir"+"&numero="+numero_tele+"&clave="+"23233"+"&fecha_entrada="+"23-23-3"+"&caso="+"generar_codigo_val";
			
			//alert(numero_tele);

        	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString10,
			crossDomain: true,
			cache: false,
			success: function(data){
				//console.log(data);
			//	var datos_num_t =$('#tarjeta');
				var datosString10 = $.parseJSON(data);
				console.log(datosString10);
				//$.each(datosString10,function(i,field){
					//var men=field.mensaje;
					var men = datosString10.mensaje;
					var id_datos = datosString10.id;
					//alert(id_datos);
				if (id_datos == 'success')
				{
					//$("#numero_tele2").attr('value',numero_tele);
					$("#enviar_cod").fadeOut(100);

					$("#titulo_cod").text(men);
					$("#codigo_se").fadeIn(1000);
					$("#boton_val").fadeIn(1500);
	            	
				}
				if (id_datos == 'error')
				{
					 swal("Error","Hubo un error en la base de datos o al validar el telfono","error");
				}
				//var num_tarjeta=field.stripe_code;
				//datos_num_t.val(num_tarjeta);
		
			//});
			}
		})
        }

        
        //alert(numero_tele);
	    
	    function validar_numero_t(num){

	     var filtro = /^[0-9]{5,25}$/;
	     var result = filtro.test(num);
	    
	     return result;
	     }
	});	
////////////////////////aqui finaliza la parte de generar el codigo de validacion del numero de telefono
	


/////////////////////////////aqui empieza la parte de validacion del numero de telefono
//es decir validar.html

	var numero_tele_temp = 0;
	var clave_temp = 0;


      $("#boton_val").on("click", function(){
    
        var numero_tele = $("#tel").val();

        var codedial = $(".selected-flag").attr('title');
        var codigo_i = codedial.split('+');
        var codigo = codigo_i[1];
        var codigo_val= $("#cod_val").val();
        numero_tele = codigo+numero_tele;

        //alert(numero_tele+" "+codigo+" "+codigo_val);

        var validar_numero= validar_numero(numero_tele);
      
	    function validar_numero(num){

	     var filtro = /^[0-9+]{5,15}$/;
	     var result = filtro.test(num);
	    
	     return result;
	     }        

//EN CASO DE CAMPOS EN BLANCO
        if (validar_numero=="" || codigo_val =="") 
        {
            swal("Error","Debes llenar todos los campos","error"); 
        }       


//EN CASO DE ALGUN CAMPO ESCRITO DE FORMA ERRONEA

        if(validar_numero==false) 
        {
            swal("Error","El Numero de telefono debe tener min 5 digitos y el Codigo de Seguridad debe ser de 5 digitos","error"); 
        }


            if(validar_numero==true)
            {
            	//alert("estan biekljljlkn");
			var dataString11="nombre_funcion="+"a_suscribir"+"&numero="+numero_tele+"&clave="+codigo_val+"&fecha_entrada="+"23-23-3"+"&caso="+"validar_t_c";

        	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString11,
			crossDomain: true,
			cache: false,
			success: function(data){
				console.log(data);
			//	var datos_num_t =$('#tarjeta');
				var datosString11 = $.parseJSON(data);
				console.log(datosString11);
				//$.each(datosString10,function(i,field){
					//var men=field.mensaje;
					var men = datosString11.mensaje;
					var id_datos = datosString11.id;
					//alert(id_datos);
				if (id_datos == 'success')
				{
					var numero_tele2 = '+'+numero_tele;
	            	//$("#numero_tele2").val(numero_tele);
					$("#numero_tele2").attr('value',numero_tele);
					$("#numero_tele3").attr('value',numero_tele2);
					$(".formulario_val").fadeOut(100);
	            	$(".formulario_re").fadeIn(2000);

				}
				if (id_datos == 'error_c')
				{
					 swal("Error","El Codigo de Seguridad No es el Correcto","error");
				}
				if (id_datos == 'error_t')
				{
					alert("El tiempo para ingresar codigo de seguridad Ha expirado");
					window.location.href = "../Paginas/validar_telefono.html";
				}				
			}
		})


//				window.location.href = "registro_usuario.html";
        		
            	/*
            var dataString6="nombre_funcion="+"a_pago"+"&telefono="+numero_tele+"&pin="+pin+"&valor_de_pago="+valor_de_pago+"&telefono_recibe="+telefono_recibe+"&concepto="+concepto;
           	
	            $.ajax({
	                type: "POST",
	                url:"../api/api.php",
	                data: dataString6,
	                crossDomain: true,
	                cache: false,

	                success: function(data){


	                }
	            });*/
        	}

    });
          
    
   
//esta parte es para el marcaje unico de los checkbox

$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});


////////////////////////// aqui termina la parte de la validacion de telefonp


/////////////////////// aqui empieza la parte del registro del usuario registro_usuario.html

		$("#registrarUsuario").submit(registrar_usuario)

		function registrar_usuario(event){
			event.preventDefault();
			//	alert("sssss");		
			var datos = new FormData($("#registrarUsuario")[0]);

			var numero_pin  = datos.get("numero_pin");
			var correo  = datos.get("correo");
			var f_nacimiento  = datos.get("f_nacimiento");
			var sexo  = datos.get("sexo");			

	        var validar_numero_pin = validar_numero(numero_pin);
	        var validar_correo = validar_correo(correo);
	        var validar_fecha = validar_fecha(f_nacimiento);

		  //alert(validar_numero_pin+" "+validar_correo+" "+validar_fecha+" "+sexo)
		    function validar_numero(num){

		     var filtro = /^[0-9a-zA-Z]{5}$/;
		     var result = filtro.test(num);		    
		     return result;
		     } 

     	    function validar_correo(correo_em){

		     var filtro = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
		     var result = filtro.test(correo_em);
		    
		     return result;
		     }
		      

     	    function validar_fecha(fe){
		     var filtro = /^[0-9]{2}[\-]{1}[0-9]{2}[\-]{1}[0-9]{4}$/;

		     var arreglo_fecha = fe.split('-');
        	 var dia = arreglo_fecha[0];
        	 var mes = arreglo_fecha[1];

        	 if(dia>31 || mes>12) 
        	 {
        	 	var result = false;
        	 }else{
        	 	var result = filtro.test(fe);
        	 }
		    
		     return result;
		     }


		     if(validar_numero_pin == false || validar_correo == false || validar_fecha == false || sexo==null) 
		     {
		     	swal("Error", "El codigo PIN debe ser solo de cinco caracteres y solo puedes usar numeros o letras;  \nEl correo debe tener el formato xxxxx@xxxx.xxx; \nLa Fecha de Nacimiento de ser en formato dd-mm-aaaa; \nDebes rellenar los campos Pin, Correo, Fecha de Nacimiento y Sexo","error");
		     }


		    if(validar_numero_pin == true && validar_correo == true && validar_fecha == true &&  sexo!=null) 
			{			
				$.ajax({
					url:'../api/api.php',
					type: 'POST',
					data: datos,
					contentType: false, //para no permitir envio de datos get
					processData: false,//para no convertir los datos en forma de texto
					cache: false,
					success: function(data){
						//console.log(data);
						var datosString12 = $.parseJSON(data);
						console.log(datosString12);
						if(datosString12.id == 'success')
						{
							alert("Usuario Registrado Correctamente");
							window.location.href = "../index.html";
						}
						if(datosString12.id == 'error')
						{
							alert("Hubo un problema al registrar el usuario");
							window.location.href = "../index.html";
						}

						if(datosString12.id == 'e_imagen')
						{
							swal("Error", datosString12.mensaje,"error"); 
						}						
					}
				}); 
			}
		}
//////////////////////////// aqui termina la parte de registro de usuario




////////////////////en esta parte se redirecciona a usuario.html al pulsar boton cerrar
	 $("#cer_modal").on("click",function(){
		window.location.href = "usuario.html";
	 
	 });



//esta es la parte de cerrar seccion
    $("#cerrar_se").on("click",function(){

//alert("sadsd");
		sessionStorage.removeItem("numero_secion");
		sessionStorage.clear();

		window.location.href = "../index.html";
    	});


    $("#botonMapa").on("click",function(){
	window.open('https://paulina96madrid.000webhostapp.com/ejemploDatos/usuario.php', '_self','location=no');
	/*	
	//Cargar librerias de Cordova.
				document.addEventListener("deviceready", onDeviceReady, false);
				//Funcion ready. 
				function onDeviceReady() {
				}
				//Funcion alerta.
				function alertDismissed() {
				window.open('https://paulina96madrid.000webhostapp.com/usuario.php', '_self','location=no');
				}	
				//Alerta en cordova.
				navigator.notification.alert(
					'No tienes cuenta.',  // message
					alertDismissed,         // callback
					'PractiCash',            // title
					'Registrar'                 // buttonName
				);*/
	
	});

/////esta es la parte de listar la tarjeta asociada al cliente en recargar tarjeta
	var dataString7="nombre_funcion="+"a_tarjeta"+"&telefono_cliente_tarjeta="+n_session+"&key_tarjeta="+"232";

	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString7,
			crossDomain: true,
			cache: false,
			success: function(data){
				var datos_num_t =$('#tarjeta');
				var datosString7 = $.parseJSON(data);
				console.log(datosString7);
				$.each(datosString7,function(i,field){

				var num_tarjeta=field.stripe_code;
				datos_num_t.val(num_tarjeta);
		
			});
			}
		})	


/*
        if ($("#radio_fecha").is(":checked")) 
        {
        	$( "#datepicker1").prop( 'disabled', false );
        	$("#datepicker2").prop( 'disabled', false );
        	$("#cant_filas").attr('disabled', 'disable');
        //$("#buscar_tra").css({'color':'#2C3E50','background':'#B2BABB'});  
           // $('#div1').show();
        }
        if ($("#radio_ran").is(":checked")) 
        {
        	$("#datepicker1").attr('disabled', 'disabled');
        	$("#datepicker2").attr('disabled', 'disabled');
			$( "#cant_filas").prop( 'disabled', false ); 
        }*/

        var radio_indicador ="radio_ran";

//en esta parte se habilatan los campos para buscar por fecha
	$('input[type=radio][name=act_calen]').change(function() {

	    radio_indicador = $(this).attr('id');
		//alert(ind);

        if (radio_indicador == "radio_fecha") 
        {
        	$("#datepicker1").prop('disabled', false );
        	$("#datepicker2").prop('disabled', false );
        	$("#cant_filas").attr('disabled', 'disabled');
        //$("#buscar_tra").css({'color':'#2C3E50','background':'#B2BABB'});  
           // $('#div1').show();
        }
        if (radio_indicador == "radio_ran") 
        {
        	$("#datepicker1").attr('disabled', 'disabled');
        	$("#datepicker2").attr('disabled', 'disabled');
			$( "#cant_filas").prop('disabled', false ); 
        }


  /*
    // $("#act_calen").click(function () {
  // alert("stttttttt");
        if ($("#act_calen").is(":checked")) 
        {
        	$( "#datepicker1" ).prop( 'disabled', false );
        	$( "#datepicker2" ).prop( 'disabled', false );
        	$( "#buscar_tra" ).prop( 'disabled', false );
        	$("#buscar_tra").css({'color':'white','background':'blue'});
        //	$("#datepicker1").attr('disabled', 'disabled');
        //$("#buscar_tra").css({'color':'#2C3E50','background':'#B2BABB'});  
           // $('#div1').show();
        }else{
        	$("#datepicker2").attr('disabled', 'disabled');
        	$("#datepicker2").attr('disabled', 'disabled');
        }*/
    })


//AQUI ES DONDE SE BUSCAN LAS FECHAS PARA LA TABLA MOVIMIENTOS
    $("#buscar_tra").click(function(evento){

    	if(radio_indicador=="radio_fecha")
    	{

		    var fecha_inicial1=$("#datepicker1").val();
		    var fecha_final1=$("#datepicker2").val();
			//alert(fecha_final1+" "+fecha_inicial1)

		    //aqui se valida si la fechas estan en formato DD-MM-YYYY
		    var val_fecha_i = validar_fecha(fecha_inicial1);
		    var val_fecha_f = validar_fecha(fecha_final1);
			//alert(val_fecha_i+" "+val_fecha_f);

		    function validar_fecha(fecha)
		    {
			    var filtro = /^([0-2][0-9](-)|3[0-1](-))(0[1-9](-)|1[0-2](-))(20[1-9][0-9])$/;
			    var result = filtro.test(fecha);   
			    return result;
		    }
			/*aqui se formatea la fecha inicial para que java scrip la reconozca*/
			var dia_ini = fecha_inicial1.substring(0,2);
			var mes_ini = fecha_inicial1.substring(3,5);
			var anio_ini = fecha_inicial1.substring(6,10);

			//alert(dia_ini+" "+mes_ini+" "+anio_ini);
			var fecha_inicial2 = anio_ini+"-"+mes_ini+"-"+dia_ini;

			/*aqui se formatea la fecha final para que java scrip la reconozca*/
			var dia_fin = fecha_final1.substring(0,2);
			var mes_fin = fecha_final1.substring(3,5);
			var anio_fin = fecha_final1.substring(6,10);

			//alert(dia_ini+" "+mes_ini+" "+anio_ini);
			var fecha_final2 = anio_fin+"-"+mes_fin+"-"+dia_fin;

		    fecha_inicial = new Date(fecha_inicial2);
		    fecha_final = new Date(fecha_final2)

			//val_fecha_i==false;;
			 //val_fecha_f==false;
			if(val_fecha_i==false || val_fecha_f==false)
			{
			    swal("Error","El formato de fecha permitido es: DD-MM-YYYY","error");
			}

			if(fecha_inicial=="" || fecha_final=="")
			{
			    swal("Error","Debes elegir una fecha inicial y una fecha final","error");
			}

			if(fecha_inicial>fecha_final)
			{
			   swal("Error","No puedes seleccionar una fecha inicial que sea mayor a la fecha final","error");
			}


			var dataString9="nombre_funcion="+"a_transaccion"+"&telefono_transaccion="+n_session+"&key_transaccion="+"232"+"&fecha_inicial="+fecha_inicial2+"&fecha_final="+fecha_final2;

			$.ajax({
					type: "POST",
					url:"../api/api.php",
					data: dataString9,
					crossDomain: true,
					cache: false,

					success: function(data){
						var datos_tabla_general_m =$('#tabla_general_movimientos');
						var datosString9 = $.parseJSON(data);
						console.log(datosString9);

						datos_tabla_general_m.text("");
						var contador2=0;

						$.each(datosString9,function(i,field){

							var fecha=field.fecha;
							var movimiento=field.descripcion;
							var valor = field.valor;
							var saldo=field.saldo;
							var  usuario = field.nombre_cliente;
							var concepto = field.observacion;

							var dia_ini = fecha.substring(8,10);
			    			var mes_ini = fecha.substring(5,7);
			    			var anio_ini = fecha.substring(0,4);
			    			var fecha2 =dia_ini+'-'+mes_ini+'-'+anio_ini;
							
							
							if(valor <0)
							{ 
								datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+concepto+'</td><td>'+movimiento+'</td><td>'+n_session+' ('+usuario+')'+'</td><td style="color:red;">'+valor+'</td><td>'+'$'+saldo+'</td></tr>');
							}
							if(valor>=0)
							{
								datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+concepto+'</td><td>'+movimiento+'</td><td>'+n_session+' ('+usuario+')'+'</td><td style="color:#00FF00;">'+valor+'</td><td>'+'$'+saldo+'</td></tr>');
							}

							contador2 = contador2+1;
						});
					$("#total_filas").text(contador2);
		
	//////////////////
				var table = "#mitabla";
				$('.pagination').html('');
				var trnum = 0;
				//aqui obtiene el valor de la lista de numeros de registros
				var maxRows = 10;
	//aqui calcula la cantidad de registros que hay en la tabla			
				var totalRows = $(table+' tbody tr').length;
				//alert(totalRows);
				$(table+' tr:gt(0)').each(function(){
					trnum++;
					if(trnum > maxRows)
					{
						$(this).hide();
					}
					if (trnum <= maxRows)
					{
						$(this).show();
					}
				});

				if (totalRows > maxRows)
				{
					var pagenum = Math.ceil(totalRows/maxRows);
					for(var i = 1; i <=pagenum;)
					{
						$('.pagination').append('<li data-page="'+i+'" >\<span>'+ i++ +'<span class="sr-only">(current)</span></span>\</li>').show();
					}
				}
	//aqui se pone en activo la primera casilla de la paginacion			
				$('.pagination li:first-child').addClass('active');
					
					$('.pagination li').on('click', function(){
						var pageNum = $(this).attr('data-page');
						var trIndex = 0;
						$('.pagination li').removeClass('active');
						$(this).addClass('active');
					
							$(table+' tr:gt(0)').each(function(){
								trIndex++;
								if(trIndex > (maxRows*pageNum) || trIndex <= ((maxRows*pageNum)-maxRows))
								{
									$(this).hide();
								}else{
									$(this).show();
								}
							});
					});
	/////////////////////
						  
					}
				})
		}// final de radio_indicador=="radio_fecha"




//esta es la parte cuando se elige una cantidad fija de registros
    	if(radio_indicador=="radio_ran")
    	{ 
    		var cantidad_filas = $("#cant_filas").val();
    		//alert(cantidad_filas);
	var dataString5="nombre_funcion="+"a_transaccion"+"&telefono_transaccion="+n_session+"&key_transaccion="+"232";

	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString5,
			crossDomain: true,
			cache: false,

			success: function(data){

				var datos_tabla_general_m =$('#tabla_general_movimientos');
				var datosString5 = $.parseJSON(data);
				console.log(datosString5);
				
				datos_tabla_general_m.text("");
				var contador =0;

				$.each(datosString5,function(i,field){

				if(contador!=cantidad_filas)
				{ 
					var fecha=field.fecha;
					var movimiento=field.descripcion;
					var valor = field.valor;
					var saldo=field.saldo;
					var concepto = field.observacion;
					var usuario = field.nombre_cliente;

					var dia_ini = fecha.substring(8,10);
	    			var mes_ini = fecha.substring(5,7);
	    			var anio_ini = fecha.substring(0,4);
	    			var fecha2 =dia_ini+'-'+mes_ini+'-'+anio_ini;
				
					
				if(valor <0)
				{ 
					datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+concepto+'</td><td>'+movimiento+'</td><td>'+n_session+' ('+usuario+')'+'</td><td style="color:red;">'+valor+'</td><td>'+'$'+saldo+'</td></tr>');
				}
				if(valor>=0)
				{
					datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+concepto+'</td><td>'+movimiento+'</td><td>'+n_session+' ('+usuario+')'+'</td><td style="color:#00FF00;">'+valor+'</td><td>'+'$'+saldo+'</td></tr>');

					//datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+concepto+'</td><td style="color:#00FF00;">'+valor+'</td><td>'+'$'+saldo+'</td></tr>');	
				}



	//////////////////
				var table = "#mitabla";
				$('.pagination').html('');
				var trnum = 0;
				//aqui obtiene el valor de la lista de numeros de registros
				var maxRows = 10;
	//aqui calcula la cantidad de registros que hay en la tabla			
				var totalRows = $(table+' tbody tr').length;
				//alert(totalRows);
				$(table+' tr:gt(0)').each(function(){
					trnum++;
					if(trnum > maxRows)
					{
						$(this).hide();
					}
					if (trnum <= maxRows)
					{
						$(this).show();
					}
				});

				if (totalRows > maxRows)
				{
					var pagenum = Math.ceil(totalRows/maxRows);
					for(var i = 1; i <=pagenum;)
					{
						$('.pagination').append('<li data-page="'+i+'" >\<span>'+ i++ +'<span class="sr-only">(current)</span></span>\</li>').show();
					}
				}
	//aqui se pone en activo la primera casilla de la paginacion			
				$('.pagination li:first-child').addClass('active');
					
					$('.pagination li').on('click', function(){
						var pageNum = $(this).attr('data-page');
						var trIndex = 0;
						$('.pagination li').removeClass('active');
						$(this).addClass('active');
					
							$(table+' tr:gt(0)').each(function(){
								trIndex++;
								if(trIndex > (maxRows*pageNum) || trIndex <= ((maxRows*pageNum)-maxRows))
								{
									$(this).hide();
								}else{
									$(this).show();
								}
							});
					});
	/////////////////////
					contador = contador+1;
				}
				$("#total_filas").text(contador);
			});
  
			}
		})	

    	}

	});



////////aqui se inserta el numero en el campo oculto para que lo genere
//el generador de codigo qr

  $("[id='numerot']").attr("value",n_session);
	$("#qr").qrcode({'text':n_session});

////esta es la ventana modal de mi QR, y en donde se carga el numero de telefono
  $("#b_modal_qr").click(function(){
    $("#modal_mi_qr").modal();

    $("#num_tel").text(n_session);
   
  });

//alert(n_session+"rererer");
});