
	//Envio datos Post.
	var n_session = sessionStorage.getItem("numero_secion");

	
	//alert(n_l_es_session);
	//alert("ppppp");
/*
if (n_session==null) 
{
	sessionStorage.removeItem("numero_secion");
	sessionStorage.clear();
	window.location.href = "../index.html";
}*/
/*
	var numVal = localStorage.getItem("numResult");
	var dataString="numVal="+numVal+"&selectDatos=";

	//n_session=123213;

	var dataString2="nombre_funcion="+"a_perfil"+"&telefono_cliente_perfil="+n_session+"&key_perfil="+"232";

//aqui van los submenus de la opcion Cartera
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
			console.log(datosString);
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
			//var fullname=field.fullname;
			$('#btnEjemplo').text(name);

			$("#nombre_t_cli").text(name);
			});
			}
		})	

	);

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
	var dataString4="nombre_funcion="+"a_transaccion"+"&telefono_transaccion="+n_session+"&key_transaccion="+"232";

	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString4,
			crossDomain: true,
			cache: false,

			success: function(data){

				datos_tabla_general =$('#tabla_general');
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
			datos_tabla_general.append('<tr><td>'+fecha2+'</td><td>'+descripcion+'</td><td>'+'$'+saldo+'</td></tr>');
			//$('#saldo_actual').text(descripcion);

		
			});
			}
		})	







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
				$.each(datosString5,function(i,field){

				var fecha=field.fecha;
				var descripcion=field.descripcion;
				var saldo=field.saldo;

				var dia_ini = fecha.substring(8,10);
    			var mes_ini = fecha.substring(5,7);
    			var anio_ini = fecha.substring(0,4);
    			var fecha2 =dia_ini+'-'+mes_ini+'-'+anio_ini;
			
			//datos.append(datosEjemplo);
			datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+descripcion+'</td><td>'+'$'+saldo+'</td></tr>');
			//$('#saldo_actual').text(descripcion);

		
			});
			}
		})	



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
/*	
	});
*/