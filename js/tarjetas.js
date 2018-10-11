$(document).ready(function(){
	//Img funcion.
	$('.img-check').click(function(){
		$(this).toggleClass('check');
	});
	
	$("#btnRegistrar").click(function(){
        var formulario = $("#formulario").validate
         ({
			rules: /* Accedemos a los campos.*/
			{
				numero: {required: true, digits: true, minlength: 16, maxlength: 18},
				cv : {required: true,  digits: true, minlength: 3, maxlength: 4 }
			},
			messages:
			{
				numero : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 16 caracteres', maxlength: 'El máximo permitido son 18 caracteres' },
				cv : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 3 caracteres', maxlength: 'El máximo permitido son 4 caracteres' },
			},
			submitHandler: function(form){
				//Seleccion.	
				var numSelect = [];
				$('#bncs option:selected').each(function(){
					numSelect.push($(this).val());
				});
				
				//Seleccion checkbox.
				var numCheckbox = [];
				$('.hidden:checked').each(function(){
					numCheckbox.push($(this).val());
				});
				
				//Envio datos Post.
				var nombre = numCheckbox;
				var tipo = numSelect;
				var numVal = localStorage.getItem("numResult");
				var numero = $('#numero').val();
				var date = $('#date').val();
				var cv = $('#cv').val();
				var dataString="nombre="+nombre+"&tipo="+tipo+"&numero="+numero+"&date="+date+"&cv="+cv+"&numVal="+numVal+"&insertDatos=";
			
				if($.trim(numero).length>0)
				{	
				$.ajax({
				type: "POST",
				url:"https://paulina96madrid.000webhostapp.com/datosPrueba/loginEjemplo.php",
				data: dataString,
				crossDomain: true,
				cache: false,
				beforeSend: function(){ $("#insert").val('Connecting...');},
				success: function(data){
					if(data=="success")
					{
						alert("Registro actualizado.");
						window.location.href = "usuario.html";
					}
					else if(data=="error")
					{
						alert("Error de registro.");
					}
				}	
				});
				}
				return false;		
				
			}	
		});
	});	
				/*//Envio datos Post.
				var numVal = localStorage.getItem("numResult");
				var dataString="numVal="+numVal+"&selectDatos=";
			
				if($.trim(numero).length>0)
				{	
				$.when($.ajax({
				type: "POST",
				url:"http://localhost/ejemploPrueba/datosEjemplo.php",
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
						window.location.href = "usuario.html";
					});
				}	
				}),
				$.getJSON("http://localhost/ejemploPrueba/datos.php",function(result){
				console.log(result);
				$.each(result, function(i, field){
				var id=field.id;
				var name=field.name;
				var fullname=field.fullname;
				$('#btnEjemplo').text(name + " " + fullname);
				});
				})
				);
				}
				return false;*/
				
});