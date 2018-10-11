
	//Envio datos Post.
	
	var numVal = localStorage.getItem("numResult");
	var dataString="numVal="+numVal+"&selectDatos=";
			
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
	$.getJSON("https://paulina96madrid.000webhostapp.com/datosPrueba/datos.php",function(result){
		console.log(result);
		$.each(result, function(i, field){
			var id=field.id;
			var name=field.name;
			var fullname=field.fullname;
			$('#btnEjemplo').text(name + " " + fullname);
		});
	})
	);
	
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
